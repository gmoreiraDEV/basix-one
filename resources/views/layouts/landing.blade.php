<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ $title ?? 'Basix One' }}</title>
  <meta name="description" content="{{ $meta['description'] ?? '' }}">
  <meta property="og:title" content="{{ $title ?? 'Basix One' }}">
  <meta property="og:description" content="{{ $meta['description'] ?? '' }}">
  <meta property="og:image" content="{{ $meta['og_image'] ?? '' }}">
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased bg-white text-slate-800">
  <header class="border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="/" class="font-bold text-lg">Basix One</a>
      <nav class="flex items-center gap-4">
        <a href="#features" class="hover:underline">Recursos</a>
        <a href="#pricing" class="hover:underline">Planos</a>
        <a href="/login" class="px-3 py-1 rounded border">Entrar</a>
        <a href="/register" class="px-3 py-1 rounded bg-indigo-600 text-white">Começar</a>
      </nav>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="border-t">
    <div class="max-w-7xl mx-auto px-4 py-8 text-sm text-slate-500">
      © {{ date('Y') }} Basix One. Todos os direitos reservados.
    </div>
  </footer>
</body>
</html>
