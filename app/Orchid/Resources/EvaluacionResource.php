<?php

namespace App\Orchid\Resources;

use App\Models\Documento;
use App\Models\Evaluacione;
use App\Models\User;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\TD;

class EvaluacionResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Evaluacione::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('puntuacion')
                ->title('Puntuación')
                ->type('number')
                ->min(0)
                ->max(100)
                ->required(),
                
            TextArea::make('comentario')
                ->title('Comentario')
                ->rows(5)
                ->placeholder('Comentario sobre el documento'),
                
            Relation::make('documento_id')
                ->title('Documento')
                ->fromModel(Documento::class, 'titulo')
                ->required(),
                
            Relation::make('user_id')
                ->title('Evaluador')
                ->fromModel(User::class, 'name')
                ->where('tipo', 'docente')
                ->required(),
                
            DateTimer::make('fecha_evaluacion')
                ->title('Fecha de Evaluación')
                ->format('Y-m-d')
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
            TD::make('documento.titulo', 'Documento')
                ->width('250px')
                ->render(function ($model) {
                    return mb_substr($model->documento->titulo, 0, 50) . (mb_strlen($model->documento->titulo) > 50 ? '...' : '');
                }),
            TD::make('evaluador.name', 'Evaluador'),
            TD::make('puntuacion', 'Puntuación')
                ->render(function ($model) {
                    return $model->puntuacion . '/100';
                }),
            TD::make('fecha_evaluacion', 'Fecha')
                ->render(function ($model) {
                    return $model->fecha_evaluacion->format('d/m/Y');
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
        return 'platform.evaluaciones';
    }

    public function legend(): array
    {
        return [
            // Sight::make('id'),
            // Sight::make('nombre'),
        ];
    }
}

