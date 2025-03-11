<?php

namespace App\Orchid\Resources;

use App\Models\Facultade;
use App\Models\Universidade;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\TD;

class FacultadResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Facultade::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('nombre')
                ->title('Nombre de la Facultad')
                ->placeholder('Ingrese el nombre completo')
                ->required(),
                
            Input::make('sigla')
                ->title('Sigla')
                ->placeholder('Ej: FCE, FCPN, etc.'),
                
            TextArea::make('descripcion')
                ->title('Descripción')
                ->rows(3)
                ->placeholder('Descripción de la facultad'),
                
            Relation::make('universidade_id')
                ->title('Universidad')
                ->fromModel(Universidade::class, 'nombre')
                ->applyScope('activas')
                ->required(),
                
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
            TD::make('nombre', 'Nombre'),
            TD::make('sigla', 'Sigla'),
            TD::make('universidad.nombre', 'Universidad'),
            TD::make('estado', 'Estado')
                ->render(function ($model) {
                    return $model->estado === 'activo' 
                        ? '<span class="text-success">Activo</span>' 
                        : '<span class="text-danger">Inactivo</span>';
                }),
            TD::make('created_at', 'Fecha de creación')
                ->render(function ($model) {
                    return $model->created_at->format('d/m/Y');
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
        return 'platform.facultades';
    }

    public function legend(): array
    {
        return [
            // Sight::make('id'),
            // Sight::make('nombre'),
        ];
    }
}

