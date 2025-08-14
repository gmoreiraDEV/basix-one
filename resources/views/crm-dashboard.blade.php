<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          CRM — Dashboard
      </h2>
  </x-slot>

  <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
              <p>Brand: {{ $theme['brand'] ?? '...' }}</p>
              <p>Primary: {{ $theme['primary'] ?? '' }} | Secondary: {{ $theme['secondary'] ?? '' }}</p>
          </div>
      </div>
  </div>
</x-app-layout>
