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
        <select name="asistentes[]" id="asistentes" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @foreach($personas as $persona)
                <option value="{{ $persona->id }}" {{ (isset($reunion) && $reunion->asistentes->contains($persona->id)) ? 'selected' : '' }}>
                    {{ $persona->nombre }} {{ $persona->apellido }}
                </option>
            @endforeach
        </select>
        <p class="text-xs text-gray-500 mt-1">Mantén presionado Ctrl (o Cmd en Mac) para seleccionar múltiples asistentes.</p>
        @error('asistentes')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="py-4 text-right">
    <a href="{{ route('dashboard.reuniones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Cancelar
    </a>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        {{ $submitButtonText ?? 'Guardar' }}
    </button>
</div>