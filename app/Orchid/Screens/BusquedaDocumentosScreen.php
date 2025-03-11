<?php

namespace App\Orchid\Screens;

use App\Models\Carrera;
use App\Models\Documento;
use App\Models\Facultad;
use App\Models\Universidad;
use App\Models\Universidade;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class BusquedaDocumentosScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        $documentos = Documento::with(['carrera.facultad.universidad', 'autores'])
            ->where('visibilidad', '!=', 'privado')
            ->where('estado', 'activo')
            ->paginate(10);
            
        return [
            'documentos' => $documentos,
            'universidades' => Universidade::activas()->get(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Búsqueda de Documentos Académicos';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Buscar')
                ->icon('magnifier')
                ->method('buscar'),
                
            Button::make('Limpiar')
                ->icon('refresh')
                ->method('limpiar'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('busqueda')
                    ->title('Buscar por título o autor')
                    ->placeholder('Ingrese términos de búsqueda'),
                    
                Select::make('universidade_id')
                    ->title('Universidad')
                    ->fromModel(Universidade::class, 'nombre')
                    ->empty('Todas las universidades')
                    ->applyScope('activas'),
                    
                Select::make('facultade_id')
                    ->title('Facultad')
                    ->empty('Todas las facultades'),
                    
                Select::make('carrera_id')
                    ->title('Carrera')
                    ->empty('Todas las carreras'),
                    
                Select::make('tipo')
                    ->title('Tipo de documento')
                    ->options([
                        'tesis' => 'Tesis',
                        'trabajo_grado' => 'Trabajo de Grado',
                        'proyecto_grado' => 'Proyecto de Grado',
                        'adscripcion' => 'Adscripción',
                    ])
                    ->empty('Todos los tipos'),
            ]),
            
            Layout::table('documentos', [
                TD::make('titulo', 'Título')
                    ->width('250px')
                    ->render(function ($documento) {
                        return Link::make($documento->titulo)
                            ->route('platform.documento.ver', $documento->id);
                    }),
                TD::make('tipo', 'Tipo')
                    ->render(function ($documento) {
                        $tipos = [
                            'tesis' => 'Tesis',
                            'trabajo_grado' => 'Trabajo de Grado',
                            'proyecto_grado' => 'Proyecto de Grado',
                            'adscripcion' => 'Adscripción',
                        ];
                        return $tipos[$documento->tipo] ?? $documento->tipo;
                    }),
                TD::make('autores', 'Autores')
                    ->render(function ($documento) {
                        return $documento->autores->pluck('name')->implode(', ');
                    }),
                TD::make('carrera.nombre', 'Carrera'),
                TD::make('carrera.facultad.nombre', 'Facultad'),
                TD::make('carrera.facultad.universidad.nombre', 'Universidad'),
                TD::make('fecha_publicacion', 'Fecha')
                    ->render(function ($documento) {
                        return $documento->fecha_publicacion->format('d/m/Y');
                    }),
            ]),
        ];
    }
    
    /**
     * Método para buscar documentos
     */
    public function buscar(Request $request)
    {
        $query = Documento::with(['carrera.facultad.universidad', 'autores'])
            ->where('visibilidad', '!=', 'privado')
            ->where('estado', 'activo');
            
        if ($request->filled('busqueda')) {
            $busqueda = $request->input('busqueda');
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', "%{$busqueda}%")
                  ->orWhere('resumen', 'like', "%{$busqueda}%")
                  ->orWhereHas('autores', function ($q) use ($busqueda) {
                      $q->where('name', 'like', "%{$busqueda}%");
                  });
            });
        }
        
        if ($request->filled('universidade_id')) {
            $query->whereHas('carrera.facultad', function ($q) use ($request) {
                $q->where('universidade_id', $request->input('universidade_id'));
            });
        }
        
        if ($request->filled('facultade_id')) {
            $query->whereHas('carrera', function ($q) use ($request) {
                $q->where('facultade_id', $request->input('facultade_id'));
            });
        }
        
        if ($request->filled('carrera_id')) {
            $query->where('carrera_id', $request->input('carrera_id'));
        }
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }
        
        return [
            'documentos' => $query->paginate(10),
            'universidades' => Universidade::activas()->get(),
        ];
    }
    
    /**
     * Método para limpiar los filtros
     */
    public function limpiar()
    {
        return redirect()->route('platform.busqueda');
    }
}

