<x-layouts.rbac>
    @section('title', 'Editar Reunión')

    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <h2 class="text-2xl font-semibold leading-tight">Editar Reunión: {{ $reunion->titulo }}</h2>

            <div class="mt-8">
                <form action="{{ route('dashboard.reuniones.update', $reunion) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                    @method('PUT')
                    @include('reuniones._form', ['submitButtonText' => 'Actualizar Reunión'])
                </form>
            </div>
        </div>
    </div>
</x-layouts.rbac>