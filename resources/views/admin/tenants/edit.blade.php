<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Editar Tenant</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                @if (session('status'))
                    <div class="mb-4 text-green-600">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.tenants.update', $tenant) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium mb-1">Nome *</label>
                        <input id="name" name="name" type="text" class="w-full border rounded p-2"
                            value="{{ old('name', $tenant->name) }}" required>
                        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Slug</label>
                        <input id="slug" name="slug" type="text" class="w-full border rounded p-2"
                            value="{{ old('slug', $tenant->slug) }}">
                        @error('slug') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Domínio</label>
                        <input name="domain" type="text" class="w-full border rounded p-2"
                            value="{{ old('domain', $tenant->domain) }}">
                        @error('domain') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium mb-1">Cor primária</label>
                            <input name="primary_color" type="text" class="w-full border rounded p-2"
                                value="{{ old('primary_color', optional($tenant->settings)->primary_color ?? '#150259') }}">
                        </div>
                        <div>
                            <label class="block font-medium mb-1">Cor secundária</label>
                            <input name="secondary_color" type="text" class="w-full border rounded p-2"
                                value="{{ old('secondary_color', optional($tenant->settings)->secondary_color ?? '#F244C4') }}">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Logo</label>
                        @if($tenant->logo_url)
                            <img src="{{ $tenant->logo_url }}" alt="Logo atual" class="h-12 mb-2">
                        @endif
                        <input name="logo" type="file" accept="image/*" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">E-mail de remetente</label>
                        <input name="email_from" type="email" class="w-full border rounded p-2"
                            value="{{ old('email_from', optional($tenant->settings)->email_from) }}">
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.tenants.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Salvar alterações</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
