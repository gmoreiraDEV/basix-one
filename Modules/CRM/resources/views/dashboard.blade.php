<x-app-layout>
  <x-slot name="header"><h2 class="font-semibold text-xl">CRM — Dashboard</h2></x-slot>
  <div class="p-6">
    <p>Brand: {{ $theme['brand'] ?? '...' }}</p>
  </div>
</x-app-layout>
