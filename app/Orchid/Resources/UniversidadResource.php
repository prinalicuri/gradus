<?php

namespace App\Orchid\Resources;

use App\Models\Universidade;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class UniversidadResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = Universidade::class;

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('nombre')
                ->title('Nombre de la Universidad')
                ->placeholder('Ingrese el nombre completo')
                ->required(),
                
            Input::make('sigla')
                ->title('Sigla')
                ->placeholder('Ej: UMSS, UMSA, UCB, etc.'),
                
            TextArea::make('direccion')
                ->title('Dirección')
                ->rows(3)
                ->placeholder('Dirección física de la universidad'),
                
            Input::make('telefono')
                ->title('Teléfono')
                ->placeholder('Número de contacto'),
                
            Input::make('email')
                ->title('Email')
                ->placeholder('Correo electrónico institucional'),
                
            Input::make('sitio_web')
                ->title('Sitio Web')
                ->placeholder('URL del sitio web'),
                
            Upload::make('logo')
                ->title('Logo')
                ->acceptedFiles('image/*')
                ->maxFiles(1)
                ->help('Suba el logo de la universidad'),
                
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
            TD::make('email', 'Email'),
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
        return 'platform.universidades';
    }

    public function legend(): array
    {
        return [
            // Sight::make('id'),
            // Sight::make('nombre'),
        ];
    }
}