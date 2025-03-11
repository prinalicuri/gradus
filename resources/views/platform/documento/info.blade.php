<div class="bg-white p-4 rounded shadow mb-4">
    <div class="mb-4">
        <h2 class="text-2xl font-bold">{{ $documento->titulo }}</h2>
        <div class="text-gray-600">
            <span class="badge badge-info">
                @php
                    $tipos = [
                        'tesis' => 'Tesis',
                        'trabajo_grado' => 'Trabajo de Grado',
                        'proyecto_grado' => 'Proyecto de Grado',
                        'adscripcion' => 'Adscripción',
                    ];
                @endphp
                {{ $tipos[$documento->tipo] ?? $documento->tipo }}
            </span>
            <span class="ml-2">{{ $documento->fecha_publicacion->format('d/m/Y') }}</span>
        </div>
    </div>
    
    <div class="mb-4">
        <h3 class="text-lg font-semibold">Institución</h3>
        <div>
            <p><strong>Universidad:</strong> {{ $documento->carrera->facultad->universidad->nombre }}</p>
            <p><strong>Facultad:</strong> {{ $documento->carrera->facultad->nombre }}</p>
            <p><strong>Carrera:</strong> {{ $documento->carrera->nombre }}</p>
        </div>
    </div>
    
    <div class="mb-4">
        <h3 class="text-lg font-semibold">Autores</h3>
        <ul class="list-disc pl-5">
            @foreach($documento->autores as $autor)
                <li>{{ $autor->name }} {{ $autor->apellido }}</li>
            @endforeach
        </ul>
    </div>
    
    <div class="mb-4">
        <h3 class="text-lg font-semibold">Tutores</h3>
        <ul class="list-disc pl-5">
            @foreach($documento->tutores as $tutor)
                <li>{{ $tutor->name }} {{ $tutor->apellido }} ({{ $tutor->pivot->tipo }})</li>
            @endforeach
        </ul>
    </div>
    
    <div class="mb-4">
        <h3 class="text-lg font-semibold">Tribunal</h3>
        <ul class="list-disc pl-5">
            @foreach($documento->tribunales as $tribunal)
                <li>{{ $tribunal->name }} {{ $tribunal->apellido }} ({{ $tribunal->pivot->cargo }})</li>
            @endforeach
        </ul>
    </div>
    
    <div class="mb-4">
        <h3 class="text-lg font-semibold">Resumen</h3>
        <div class="p-3 bg-gray-100 rounded">
            {{ $documento->resumen }}
        </div>
    </div>
    
    @if($documento->visibilidad === 'publico' && $documento->archivo_url)
        <div class="mb-4">
            <h3 class="text-lg font-semibold">Documento Completo</h3>
            <div class="p-3 bg-gray-100 rounded">
                <p>El documento completo está disponible para su descarga.</p>
            </div>
        </div>
    @endif
</div>

