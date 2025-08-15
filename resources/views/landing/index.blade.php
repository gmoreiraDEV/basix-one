@extends('layouts.landing')

@section('content')
  <section class="bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 py-16 grid gap-8 md:grid-cols-2 items-center">
      <div>
        <h1 class="text-4xl font-bold leading-tight mb-4">
          CRM + ERP White Label em um só lugar
        </h1>
        <p class="text-lg text-slate-600 mb-6">
          Lance sua plataforma multi-tenant e venda sob sua marca.
        </p>
        <div class="flex gap-3">
          <a href="/register" class="px-5 py-3 rounded bg-indigo-600 text-white">Criar minha conta</a>
          <a href="/login" class="px-5 py-3 rounded border">Já tenho conta</a>
        </div>
        <p class="mt-3 text-sm text-slate-500">Teste grátis. Sem cartão.</p>
      </div>
      <div>
        <img src="{{ asset('images/hero-dashboard.png') }}" alt="Basix One" class="w-full rounded-xl shadow">
      </div>
    </div>
  </section>

  <section id="features" class="py-16">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-2xl font-semibold mb-6">Recursos principais</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="p-6 rounded-xl border">
          <h3 class="font-semibold mb-2">CRM completo</h3>
          <p class="text-slate-600">Leads, funis, atividades e automações.</p>
        </div>
        <div class="p-6 rounded-xl border">
          <h3 class="font-semibold mb-2">ERP essencial</h3>
          <p class="text-slate-600">Produtos, NFs (extensível), estoque e financeiro.</p>
        </div>
        <div class="p-6 rounded-xl border">
          <h3 class="font-semibold mb-2">White label</h3>
          <p class="text-slate-600">Domínio & tema por cliente, branding no painel.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="pricing" class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-2xl font-semibold mb-6">Planos</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="p-6 rounded-xl border bg-white">
          <h3 class="font-semibold mb-2">Starter</h3>
          <p class="text-3xl font-bold mb-4">R$ 99/mês</p>
          <ul class="text-slate-600 list-disc ml-5 mb-6">
            <li>Até 3 clientes</li><li>CRM + ERP</li><li>Suporte básico</li>
          </ul>
          <a href="/register" class="px-4 py-2 rounded bg-indigo-600 text-white inline-block">Assinar</a>
        </div>
        <div class="p-6 rounded-xl border bg-white">
          <h3 class="font-semibold mb-2">Pro</h3>
          <p class="text-3xl font-bold mb-4">R$ 299/mês</p>
          <ul class="text-slate-600 list-disc ml-5 mb-6">
            <li>Até 20 clientes</li><li>Automação</li><li>Suporte prioritário</li>
          </ul>
          <a href="/register" class="px-4 py-2 rounded bg-indigo-600 text-white inline-block">Assinar</a>
        </div>
        <div class="p-6 rounded-xl border bg-white">
          <h3 class="font-semibold mb-2">Enterprise</h3>
          <p class="text-3xl font-bold mb-4">Sob consulta</p>
          <ul class="text-slate-600 list-disc ml-5 mb-6">
            <li>Ilimitado</li><li>SLA</li><li>Onboarding dedicado</li>
          </ul>
          <a href="/contact" class="px-4 py-2 rounded border inline-block">Falar com vendas</a>
        </div>
      </div>
    </div>
  </section>
@endsection
