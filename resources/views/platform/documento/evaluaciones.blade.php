@if(count($evaluaciones) > 0)
    <div class="bg-white p-4 rounded shadow mb-4">
        <h3 class="text-lg font-semibold mb-3">Evaluaciones y Reseñas</h3>
        
        <div class="grid gap-4">
            @foreach($evaluaciones as $evaluacion)
                <div class="border p-3 rounded">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <span class="font-semibold">{{ $evaluacion->evaluador->name }}</span>
                            <span class="text-gray-600 text-sm ml-2">{{ $evaluacion->fecha_evaluacion->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <span class="badge badge-primary">{{ $evaluacion->puntuacion }}/100</span>
                        </div>
                    </div>
                    
                    @if($evaluacion->comentario)
                        <p class="text-gray-700">{{ $evaluacion->comentario }}</p>
                    @else
                        <p class="text-gray-500 italic">Sin comentarios</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

