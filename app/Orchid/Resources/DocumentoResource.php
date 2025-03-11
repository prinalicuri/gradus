<?php

namespace App\Orchid\Resources;

use App\Models\Carrera;
use App\Models\Documento;
use App\Models\User;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\TD;

class DocumentoResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Documento::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('titulo')
                ->title('Título del Documento')
                ->placeholder('Ingrese el título completo')
                ->required(),
                
            TextArea::make('resumen')
                ->title('Resumen')
                ->rows(5)
                ->placeholder('Resumen del documento')
                ->required(),
                
            Select::make('tipo')
                ->title('Tipo de Documento')
                ->options([
                    'tesis' => 'Tesis',
                    'trabajo_grado' => 'Trabajo de Grado',
                    'proyecto_grado' => 'Proyecto de Grado',
                    'adscripcion' => 'Adscripción',
                ])
                ->required(),
                
            DateTimer::make('fecha_publicacion')
                ->title('Fecha de Publicación')
                ->format('Y-m-d')
                ->required(),
                
            Upload::make('archivo_url')
                ->title('Archivo PDF')
                ->acceptedFiles('.pdf')
                ->maxFiles(1)
                ->help('Suba el documento en formato PDF'),
                
            Select::make('visibilidad')
                ->title('Visibilidad')
                ->options([
                    'publico' => 'Público (Documento completo)',
                    'resumen' => 'Solo Resumen',
                    'privado' => 'Privado',
                ])
                ->required(),
                
            Relation::make('carrera_id')
                ->title('Carrera')
                ->fromModel(Carrera::class, 'nombre')
                ->applyScope('activas')
                ->required(),
                
            Relation::make('autores')
                ->title('Autores')
                ->fromModel(User::class, 'name')
                ->where('tipo', 'estudiante')
                ->multiple()
                ->help('Seleccione los estudiantes autores del documento'),
                
            Relation::make('tutores')
                ->title('Tutores')
                ->fromModel(User::class, 'name')
                ->where('tipo', 'docente')
                ->multiple()
                ->help('Seleccione los docentes tutores del documento'),
                
            Relation::make('tribunales')
                ->title('Tribunal')
                ->fromModel(User::class, 'name')
                ->where('tipo', 'docente')
                ->multiple()
                ->help('Seleccione los docentes que conforman el tribunal'),
                
            Select::make('estado')
                ->title('Estado')
                ->options([
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ])
                ->required(),
        ];
    }

    /**
     * Get the columns displayed by the resource.
     *
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('titulo', 'Título')
                ->width('250px')
                ->render(function ($model) {
                    return mb_substr($model->titulo, 0, 50) . (mb_strlen($model->titulo) > 50 ? '...' : '');
                }),
            TD::make('tipo', 'Tipo')
                ->render(function ($model) {
                    $tipos = [
                        'tesis' => 'Tesis',
                        'trabajo_grado' => 'Trabajo de Grado',
                        'proyecto_grado' => 'Proyecto de Grado',
                        'adscripcion' => 'Adscripción',
                    ];
                    return $tipos[$model->tipo] ?? $model->tipo;
                }),
            TD::make('fecha_publicacion', 'Fecha')
                ->render(function ($model) {
                    return $model->fecha_publicacion->format('d/m/Y');
                }),
            TD::make('carrera.nombre', 'Carrera'),
            TD::make('visibilidad', 'Visibilidad')
                ->render(function ($model) {
                    $visibilidad = [
                        'publico' => '<span class="text-success">Público</span>',
                        'resumen' => '<span class="text-warning">Resumen</span>',
                        'privado' => '<span class="text-danger">Privado</span>',
                    ];
                    return $visibilidad[$model->visibilidad] ?? $model->visibilidad;
                }),
            TD::make('estado', 'Estado')
                ->render(function ($model) {
                    return $model->estado === 'activo' 
                        ? '<span class="text-success">Activo</span>' 
                        : '<span class="text-danger">Inactivo</span>';
                }),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            // Filtros si son necesarios
        ];
    }
    
    /**
     * Get the permission key for the resource.
     *
     * @return string|null
     */
    public static function permission(): ?string
    {
        return 'platform.documentos';
    }

    public function legend(): array
    {
        return [
            // Sight::make('id'),
            // Sight::make('nombre'),
        ];
    }
}

