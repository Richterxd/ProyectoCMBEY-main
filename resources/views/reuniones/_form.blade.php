@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $reunion->titulo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        @error('titulo')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="fecha_reunion" class="block text-sm font-medium text-gray-700">Fecha de la Reunión</label>
        <input type="date" name="fecha_reunion" id="fecha_reunion" value="{{ old('fecha_reunion', isset($reunion) ? $reunion->fecha_reunion->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        @error('fecha_reunion')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="solicitud_id" class="block text-sm font-medium text-gray-700">Solicitud Asociada</label>
        <select name="solicitud_id" id="solicitud_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            @foreach($solicitudes as $id => $titulo)
                <option value="{{ $id }}" {{ (isset($reunion) && $reunion->solicitud_id == $id) ? 'selected' : '' }}>{{ $titulo }}</option>
            @endforeach
        </select>
        @error('solicitud_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="institucion_id" class="block text-sm font-medium text-gray-700">Institución Responsable</label>
        <select name="institucion_id" id="institucion_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            @foreach($instituciones as $id => $titulo)
                <option value="{{ $id }}" {{ (isset($reunion) && $reunion->institucion_id == $id) ? 'selected' : '' }}>{{ $titulo }}</option>
            @endforeach
        </select>
        @error('institucion_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('descripcion', $reunion->descripcion ?? '') }}</textarea>
        @error('descripcion')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación</label>
        <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $reunion->ubicacion ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        @error('ubicacion')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="asistentes" class="block text-sm font-medium text-gray-700">Asistentes</label>
        <div class="mt-1 border border-gray-300 rounded-lg p-4 max-h-60 overflow-y-auto bg-white">
            @foreach($personas as $persona)
                <div class="flex items-center justify-between py-2 px-2 hover:bg-gray-50 rounded">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="asistentes[]" 
                               value="{{ $persona->cedula }}" 
                               id="asistente_{{ $persona->cedula }}"
                               class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                               {{ (isset($reunion) && $reunion->asistentes->contains('cedula', $persona->cedula)) ? 'checked' : '' }}>
                        <label for="asistente_{{ $persona->cedula }}" class="text-sm text-gray-900 cursor-pointer">
                            {{ $persona->nombre }} {{ $persona->apellido }} 
                            <span class="text-gray-500 text-xs">({{ $persona->cedula }})</span>
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" 
                               name="concejal" 
                               value="{{ $persona->cedula }}" 
                               id="concejal_{{ $persona->cedula }}"
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300"
                               {{ (isset($reunion) && $reunion->concejal() && $reunion->concejal()->cedula === $persona->cedula) ? 'checked' : '' }}>
                        <label for="concejal_{{ $persona->cedula }}" class="ml-1 text-xs text-green-600 cursor-pointer">Concejal</label>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between mt-2">
            <p class="text-xs text-gray-500">Selecciona los asistentes y marca uno como Concejal.</p>
            <div class="flex items-center text-xs text-gray-500">
                <span class="inline-block w-3 h-3 bg-blue-100 border border-blue-300 rounded mr-1"></span>
                <span class="mr-3">Asistente</span>
                <span class="inline-block w-3 h-3 bg-green-100 border border-green-300 rounded mr-1"></span>
                <span>Concejal</span>
            </div>
        </div>
        @error('asistentes')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @error('concejal')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="nuevo_estado_solicitud" class="block text-sm font-medium text-gray-700">Actualizar Estado de Solicitud (Opcional)</label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                <i class='bx bx-sync'></i>
            </span>
            <input type="text" 
                   name="nuevo_estado_solicitud" 
                   id="nuevo_estado_solicitud" 
                   class="flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                   placeholder="Ej: En proceso: Acuerdo de ejecución"
                   value="{{ old('nuevo_estado_solicitud') }}">
        </div>
        <p class="text-xs text-gray-500 mt-1">Si especifica un nuevo estado, se actualizará el estado detallado de la solicitud asociada.</p>
        @error('nuevo_estado_solicitud')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<script>
    // JavaScript para mejorar la experiencia del usuario
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar la selección de Concejal
        const asistentesCheckboxes = document.querySelectorAll('input[name="asistentes[]"]');
        const concejalRadios = document.querySelectorAll('input[name="concejal"]');
        
        // Cuando se selecciona/deselecciona un asistente
        asistentesCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const cedula = this.value;
                const concejalRadio = document.getElementById('concejal_' + cedula);
                
                if (!this.checked && concejalRadio.checked) {
                    // Si se deselecciona un asistente que era Concejal, limpiar selección de Concejal
                    concejalRadio.checked = false;
                }
            });
        });
        
        // Cuando se selecciona un Concejal, asegurar que también esté marcado como asistente
        concejalRadios.forEach(function(radio) {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const cedula = this.value;
                    const asistenteCheckbox = document.getElementById('asistente_' + cedula);
                    
                    // Asegurar que el Concejal también esté marcado como asistente
                    if (!asistenteCheckbox.checked) {
                        asistenteCheckbox.checked = true;
                    }
                }
            });
        });
    });
</script>

<div class="py-4 text-right">
    <a href="{{ route('dashboard.reuniones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Cancelar
    </a>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        {{ $submitButtonText ?? 'Guardar' }}
    </button>
</div>