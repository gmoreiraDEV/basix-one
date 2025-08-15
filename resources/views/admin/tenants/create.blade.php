<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl">Novo Tenant</h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow">

        @if (session('status'))
          <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.tenants.store') }}" enctype="multipart/form-data" class="space-y-6">
          @csrf

          <div>
            <label class="block font-medium mb-1">Nome *</label>
            <input id="name" name="name" type="text" class="w-full border rounded p-2" value="{{ old('name') }}" required>
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>
          
          <div>
            <label class="block font-medium mb-1">Slug (opcional)</label>
            <input id="slug" name="slug" type="text" class="w-full border rounded p-2" value="{{ old('slug') }}" placeholder="ex.: acme">
            <p id="slug-hint" class="text-xs mt-1"></p>
            @error('slug') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block font-medium mb-1">Domínio (opcional)</label>
            <input name="domain" type="text" class="w-full border rounded p-2" value="{{ old('domain') }}" placeholder="ex.: acme.one.basixdigital.com.br">
            @error('domain') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block font-medium mb-1">Cor primária</label>
              <input name="primary_color" type="text" class="w-full border rounded p-2" value="{{ old('primary_color', '#150259') }}">
              @error('primary_color') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block font-medium mb-1">Cor secundária</label>
              <input name="secondary_color" type="text" class="w-full border rounded p-2" value="{{ old('secondary_color', '#F244C4') }}">
              @error('secondary_color') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div>
            <label class="block font-medium mb-1">Logo (opcional)</label>
            <input name="logo" type="file" accept="image/*" class="w-full border rounded p-2">
            @error('logo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label class="block font-medium mb-1">E-mail de remetente (opcional)</label>
            <input name="email_from" type="email" class="w-full border rounded p-2" value="{{ old('email_from') }}" placeholder="no-reply@seu-dominio.com">
            @error('email_from') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="flex justify-end gap-3">
            <a href="/app?tenant=demo" class="px-4 py-2 border rounded">Cancelar</a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Criar tenant</button>
          </div>
        </form>

        {{-- Script direto no final para garantir execução --}}
        <script>
          (function () {
            const name = document.getElementById('name');
            const slug = document.getElementById('slug');
            const hint = document.getElementById('slug-hint');

            const toSlug = (text) =>
              text.toLowerCase()
                  .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                  .replace(/[^a-z0-9]+/g,'-')
                  .replace(/^-+|-+$/g,'');

            let lastCheck = null;
            let debounceTimer = null;

            function setHint(msg, ok=null) {
              hint.textContent = msg || '';
              hint.className = 'text-xs mt-1 ' + (ok===true ? 'text-green-600' : ok===false ? 'text-red-600' : 'text-slate-500');
            }

            function debounce(fn, delay) {
              return function(...args) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => fn.apply(this, args), delay);
              };
            }

            async function checkAvailability(value) {
              if (!value) { setHint('Informe um slug.'); return; }
              setHint('Verificando disponibilidade...', null);
              lastCheck = value;
              const url = `{{ route('admin.tenants.check-slug') }}?slug=${encodeURIComponent(value)}`;
              try {
                const res = await fetch(url, { headers: { 'X-Requested-With':'XMLHttpRequest' }});
                const data = await res.json();
                if (lastCheck !== value) return; // evita race condition
                if (data.ok) setHint(`Disponível: ${data.slug}`, true);
                else setHint(`Indisponível${data.slug ? ': '+data.slug : ''}`, false);
              } catch (e) {
                setHint('Falha ao verificar slug.', false);
              }
            }

            const debouncedCheck = debounce(checkAvailability, 300);

            name?.addEventListener('input', () => {
              if (slug.value.trim() === '') {
                slug.value = toSlug(name.value);
                debouncedCheck(slug.value);
              }
            });

            slug?.addEventListener('input', () => {
              slug.value = toSlug(slug.value);
              debouncedCheck(slug.value);
            });

            if (name && name.value && !slug.value) {
              slug.value = toSlug(name.value);
              debouncedCheck(slug.value);
            }
          })();
        </script>

      </div>
    </div>
  </div>
</x-app-layout>
