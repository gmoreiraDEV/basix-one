<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Tenants</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow space-y-6">

                @if (session('status'))
                    <div class="mb-4 text-green-600">{{ session('status') }}</div>
                @endif

                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Lista de Tenants</h3>
                    <a href="{{ route('admin.tenants.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Novo Tenant</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-slate-200">
                        <thead class="bg-slate-100">
                            <tr>
                                <th class="px-4 py-2 border">Logo</th>
                                <th class="px-4 py-2 border">Nome</th>
                                <th class="px-4 py-2 border">Slug</th>
                                <th class="px-4 py-2 border">Domínio</th>
                                <th class="px-4 py-2 border">Criado em</th>
                                <th class="px-4 py-2 border text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tenants as $tenant)
                                <tr class="hover:bg-slate-50 {{ $tenant->trashed() ? 'opacity-60' : '' }}">
                                    <td class="px-4 py-2 border text-center">
                                        @if($tenant->logo_url)
                                            <img src="{{ $tenant->logo_url }}" alt="Logo" class="h-8 mx-auto">
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">
                                        {{ $tenant->name }}
                                        @if($tenant->trashed())
                                            <span class="text-xs text-red-500 ml-1">(Excluído)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">{{ $tenant->slug }}</td>
                                    <td class="px-4 py-2 border">{{ $tenant->domain ?? '—' }}</td>
                                    <td class="px-4 py-2 border">{{ $tenant->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-2 border text-center space-x-2">
                                        @if(!$tenant->trashed())
                                            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="text-blue-600 hover:underline">Editar</a>
                                            <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este tenant?')" class="text-red-600 hover:underline">
                                                    Excluir
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.tenants.restore', $tenant->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" onclick="return confirm('Deseja restaurar este tenant?')" class="text-green-600 hover:underline">
                                                    Restaurar
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-slate-500">Nenhum tenant encontrado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $tenants->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
