<?php

namespace App\Orchid\Screens;

use App\Models\Documento;
use App\Models\Evaluacione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class VerDocumentoScreen extends Screen
{
    /**
     * @var Documento
     */
    public $documento;

    /**
     * Query data.
     *
     * @param Documento $documento
     * @return array
     */
    public function query(Documento $documento): array
    {
        $this->documento = $documento->load(['carrera.facultad.universidad', 'autores', 'tutores', 'tribunales', 'evaluaciones.evaluador']);
        
        return [
            'documento' => $this->documento,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->documento->titulo;
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Volver')
                ->icon('arrow-left')
                ->route('platform.busqueda'),
                
            Button::make('Descargar PDF')
                ->icon('cloud-download')
                ->method('descargar')
                ->canSee($this->documento->visibilidad === 'publico' && $this->documento->archivo_url),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        $user = Auth::user();
        $userTipo = $user ? $user->tipo : null;
        
        return [
            Layout::view('platform.documento.info', [
                'documento' => $this->documento,
            ]),
            
            Layout::rows([
                Input::make('puntuacion')
                    ->title('Puntuación (0-100)')
                    ->type('number')
                    ->min(0)
                    ->max(100)
                    ->canSee($userTipo === 'docente'),
                    
                TextArea::make('comentario')
                    ->title('Comentario')
                    ->rows(5)
                    ->canSee($userTipo === 'docente'),
                    
                Button::make('Enviar Evaluación')
                    ->icon('check')
                    ->method('evaluarDocumento')
                    ->canSee($userTipo === 'docente'),
            ]),
            
            Layout::view('platform.documento.evaluaciones', [
                'evaluaciones' => $this->documento->evaluaciones,
            ]),
        ];
    }
    
    /**
     * Método para descargar el documento
     */
    public function descargar()
    {
        if ($this->documento->visibilidad !== 'publico' || !$this->documento->archivo_url) {
            Toast::error('No tiene permisos para descargar este documento');
            return back();
        }
        
        return response()->download(storage_path('app/public/' . $this->documento->archivo_url));
    }
    
    /**
     * Método para evaluar el documento
     */
    public function evaluarDocumento(Request $request)
    {
        $request->validate([
            'puntuacion' => 'required|numeric|min:0|max:100',
            'comentario' => 'nullable|string',
        ]);
        
        $user = Auth::user();
        
        if (!$user || $user->tipo !== 'docente') {
            Toast::error('Solo los docentes pueden evaluar documentos');
            return back();
        }
        
        Evaluacione::create([
            'puntuacion' => $request->input('puntuacion'),
            'comentario' => $request->input('comentario'),
            'documento_id' => $this->documento->id,
            'user_id' => $user->id,
            'fecha_evaluacion' => now(),
        ]);
        
        Toast::success('Evaluación registrada correctamente');
        return back();
    }
}
