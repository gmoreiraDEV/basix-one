<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTenantRequest;
use App\Models\Tenant;
use App\Models\TenantSetting;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::withTrashed()->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('admin.tenants.create');
    }

    public function store(StoreTenantRequest $request)
    {
        $data = $request->validated();

        // slug: usa o informado ou gera do nome
        $slug = $data['slug'] ?? Str::slug($data['name']);
        $id   = (string) Str::uuid();

        // upload do logo (opcional)
        $logoUrl = null;
        if ($request->hasFile('logo')) {
            $path    = $request->file('logo')->store('logos', 'public');
            $logoUrl = Storage::url($path);
        }

        // cria o tenant
        $tenant = Tenant::create([
            'id'     => $id,
            'name'   => $data['name'],
            'slug'   => $slug,
            'domain' => $data['domain'] ?? null,
            'logo_url' => $logoUrl,
        ]);

        // settings padrão
        TenantSetting::updateOrCreate(
            ['tenant_id' => $tenant->id],
            [
                'brand_name'     => $data['brand_name'] ?? $tenant->name,
                'logo_url'       => $logoUrl,
                'primary_color'  => $data['primary_color']  ?? '#150259',
                'secondary_color'=> $data['secondary_color']?? '#F244C4',
                'email_from'     => $data['email_from'] ?? null,
                'features'       => ['crm' => true, 'erp' => true],
            ]
        );

        return redirect()->to('/app/crm?tenant='.$slug)
            ->with('status', 'Tenant criado com sucesso!');
    }

    public function checkSlug(Request $request)
    {
        $slug = Str::slug($request->get('slug', ''));

        if (empty($slug)) {
            return response()->json([
                'ok' => false,
                'slug' => null,
                'message' => 'Slug inválido.'
            ], 400);
        }

        // Verifica se já existe
        $exists = Tenant::where('slug', $slug)->exists();

        return response()->json([
            'ok' => !$exists,
            'slug' => $slug
        ]);
    }

    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(StoreTenantRequest $request, Tenant $tenant)
    {
        $data = $request->validated();

        // slug: usa o informado ou mantém o atual
        $slug = $data['slug'] ?? $tenant->slug;

        // upload do logo (opcional)
        $logoUrl = $tenant->logo_url;
        if ($request->hasFile('logo')) {
            $path    = $request->file('logo')->store('logos', 'public');
            $logoUrl = Storage::url($path);
        }

        // atualiza o tenant
        $tenant->update([
            'name'     => $data['name'],
            'slug'     => $slug,
            'domain'   => $data['domain'] ?? null,
            'logo_url' => $logoUrl,
        ]);

        // atualiza settings
        TenantSetting::updateOrCreate(
            ['tenant_id' => $tenant->id],
            [
                'brand_name'      => $data['brand_name'] ?? $tenant->name,
                'logo_url'        => $logoUrl,
                'primary_color'   => $data['primary_color']  ?? '#150259',
                'secondary_color' => $data['secondary_color']?? '#F244C4',
                'email_from'      => $data['email_from'] ?? null,
                'features'        => ['crm' => true, 'erp' => true],
            ]
        );

        return redirect()->route('admin.tenants.index')
            ->with('status', 'Tenant atualizado com sucesso!');
    }

    public function destroy(Tenant $tenant)
    {
        // Opcional: Remover arquivo de logo do storage, se houver
        if ($tenant->logo_url) {
            // supondo que seja armazenado via Storage::url()
            $path = str_replace('/storage/', '', $tenant->logo_url);
            \Storage::disk('public')->delete($path);
        }

        $tenant->delete(); // Soft Delete

        return redirect()
            ->route('admin.tenants.index')
            ->with('status', 'Tenant excluído com sucesso.');
    }
    
    public function restore($id)
    {
        $tenant = Tenant::onlyTrashed()->findOrFail($id);
        $tenant->restore();

        return redirect()->route('admin.tenants.index')
                        ->with('status', 'Tenant restaurado com sucesso.');
    }
}
