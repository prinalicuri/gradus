<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Dashboard')
                ->icon('chart')
                ->route('platform.index'),

            Menu::make('Universidades')
                ->icon('building')
                ->route('platform.resource.list', ['resource' => 'universidadresource'])
                ->permission('platform.universidades'),

            Menu::make('Facultades')
                ->icon('book-open')
                ->route('platform.resource.list', ['resource' => 'facultadresource'])
                ->permission('platform.facultades'),

            Menu::make('Carreras')
                ->icon('graduation-cap')
                ->route('platform.resource.list', ['resource' => 'carreraresource'])
                ->permission('platform.carreras'),

            Menu::make('Documentos Académicos')
                ->icon('file-text')
                ->route('platform.resource.list', ['resource' => 'documentoresource'])
                ->permission('platform.documentos'),

            Menu::make('Evaluaciones')
                ->icon('star')
                ->route('platform.resource.list', ['resource' => 'evaluacionresource'])
                ->permission('platform.evaluaciones'),

            Menu::make('Búsqueda de Documentos')
                ->icon('magnifier')
                ->route('platform.busqueda')
                ->permission('platform.busqueda'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
                
            ItemPermission::group(__('Recursos'))
                ->addPermission('platform.universidades', __('Universidades'))
                ->addPermission('platform.facultades', __('Facultades'))
                ->addPermission('platform.carreras', __('Carreras'))
                ->addPermission('platform.documentos', __('Documentos'))
                ->addPermission('platform.evaluaciones', __('Evaluaciones'))
                ->addPermission('platform.busqueda', __('Búsqueda de Documentos')),
        ];
    }
}
