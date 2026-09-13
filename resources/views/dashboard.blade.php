<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4">Acompanhe suas atividades no sistema de eventos.</p>

                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded border p-4">
                            <p class="text-sm text-gray-500">Eventos ativos</p>
                            <p class="text-2xl font-bold">{{ $eventosAtivos }}</p>
                        </div>

                        <div class="rounded border p-4">
                            <p class="text-sm text-gray-500">Minhas inscrições</p>
                            <p class="text-2xl font-bold">{{ $minhasInscricoes }}</p>
                        </div>

                        <div class="rounded border p-4">
                            <p class="text-sm text-gray-500">Eventos organizados</p>
                            <p class="text-2xl font-bold">{{ $eventosOrganizados }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
