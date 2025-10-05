<x-layouts.rbac>
    @section('title', 'Crear Nueva Reunión')

    <div class="container mx-auto px-4 sm:px-8">
        <div class="py-8">
            <h2 class="text-2xl font-semibold leading-tight">Crear Nueva Reunión</h2>

            <div class="mt-8">
                <form action="{{ route('dashboard.reuniones.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
                    @include('reuniones._form', ['submitButtonText' => 'Crear Reunión'])
                </form>
            </div>
        </div>
    </div>
</x-layouts.rbac>