<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Facultade;
use App\Models\Universidade;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Orchid\Platform\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
                'platform.index' => true,
                'platform.systems.roles' => true,
                'platform.systems.users' => true,
                'platform.universidades' => true,
                'platform.facultades' => true,
                'platform.carreras' => true,
                'platform.documentos' => true,
                'platform.evaluaciones' => true,
                'platform.busqueda' => true,
            ],
        ]);
        
        $universidadRole = Role::create([
            'name' => 'Universidade',
            'slug' => 'universidad',
            'permissions' => [
                'platform.index' => true,
                'platform.facultades' => true,
                'platform.busqueda' => true,
            ],
        ]);
        
        $facultadRole = Role::create([
            'name' => 'Facultade',
            'slug' => 'facultad',
            'permissions' => [
                'platform.index' => true,
                'platform.carreras' => true,
                'platform.busqueda' => true,
            ],
        ]);
        
        $carreraRole = Role::create([
            'name' => 'Carrera',
            'slug' => 'carrera',
            'permissions' => [
                'platform.index' => true,
                'platform.documentos' => true,
                'platform.busqueda' => true,
            ],
        ]);
        
        $docenteRole = Role::create([
            'name' => 'Docente',
            'slug' => 'docente',
            'permissions' => [
                'platform.index' => true,
                'platform.evaluaciones' => true,
                'platform.busqueda' => true,
            ],
        ]);
        
        $estudianteRole = Role::create([
            'name' => 'Estudiante',
            'slug' => 'estudiante',
            'permissions' => [
                'platform.index' => true,
                'platform.busqueda' => true,
            ],
        ]);
        
        // Crear usuario administrador
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gradus.com',
            'password' => Hash::make('password123'),
            'apellido' => 'Sistema',
            'ci' => 'ADM-001',
            'telefono' => '70000000',
            'tipo' => 'administrativo',
        ]);
        
        $admin->roles()->attach($adminRole);
        
        // Crear universidades de ejemplo
        $umsa = Universidade::create([
            'nombre' => 'Universidad Mayor de San Andrés',
            'sigla' => 'UMSA',
            'direccion' => 'Av. Villazón N° 1995, Plaza del Bicentenario',
            'telefono' => '2441570',
            'email' => 'info@umsa.bo',
            'sitio_web' => 'https://www.umsa.bo',
            'estado' => 'activo',
        ]);
        
        $umss = Universidade::create([
            'nombre' => 'Universidad Mayor de San Simón',
            'sigla' => 'UMSS',
            'direccion' => 'Cochabamba',
            'telefono' => '4525252',
            'email' => 'info@umss.edu.bo',
            'sitio_web' => 'https://www.umss.edu.bo',
            'estado' => 'activo',
        ]);
        
        // Crear facultades de ejemplo
        $fcpn = Facultade::create([
            'nombre' => 'Facultad de Ciencias Puras y Naturales',
            'sigla' => 'FCPN',
            'descripcion' => 'Facultad de ciencias exactas',
            'universidade_id' => $umsa->id,
            'estado' => 'activo',
        ]);
        
        $fce = Facultade::create([
            'nombre' => 'Facultad de Ciencias Económicas',
            'sigla' => 'FCE',
            'descripcion' => 'Facultad de economía y finanzas',
            'universidade_id' => $umsa->id,
            'estado' => 'activo',
        ]);
        
        // Crear carreras de ejemplo
        $informatica = Carrera::create([
            'nombre' => 'Informática',
            'codigo' => 'INF',
            'descripcion' => 'Carrera de Informática',
            'facultade_id' => $fcpn->id,
            'estado' => 'activo',
        ]);
        
        $matematica = Carrera::create([
            'nombre' => 'Matemática',
            'codigo' => 'MAT',
            'descripcion' => 'Carrera de Matemática',
            'facultade_id' => $fcpn->id,
            'estado' => 'activo',
        ]);
        
        $administracion = Carrera::create([
            'nombre' => 'Administración de Empresas',
            'codigo' => 'ADM',
            'descripcion' => 'Carrera de Administración',
            'facultade_id' => $fce->id,
            'estado' => 'activo',
        ]);
        
        // Crear usuarios de ejemplo
        $docenteUser = User::create([
            'name' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'docente@gradus.com',
            'password' => Hash::make('password'),
            'tipo' => 'docente',
            'ci' => '1234567',
            'telefono' => '70123456',
        ]);
        
        $docenteUser->roles()->attach($docenteRole);
        
        $estudianteUser = User::create([
            'name' => 'María',
            'apellido' => 'López',
            'email' => 'estudiante@gradus.com',
            'password' => Hash::make('password'),
            'tipo' => 'estudiante',
            'ci' => '7654321',
            'telefono' => '70654321',
        ]);
        
        $estudianteUser->roles()->attach($estudianteRole);
        
        // Crear administradores para universidad, facultad y carrera
        $uniAdmin = User::create([
            'name' => 'Admin',
            'apellido' => 'Universidad',
            'email' => 'universidad@gradus.com',
            'password' => Hash::make('password'),
            'tipo' => 'administrativo',
            'ci' => 'UNI-001',
            'telefono' => '70111111',
        ]);
        
        $uniAdmin->roles()->attach($universidadRole);
        $umsa->administradores()->attach($uniAdmin->id, ['role' => 'admin']);
        
        $facAdmin = User::create([
            'name' => 'Admin',
            'apellido' => 'Facultad',
            'email' => 'facultad@gradus.com',
            'password' => Hash::make('password'),
            'tipo' => 'administrativo',
            'ci' => 'FAC-001',
            'telefono' => '70222222',
        ]);
        
        $facAdmin->roles()->attach($facultadRole);
        $fcpn->administradores()->attach($facAdmin->id, ['role' => 'admin']);
        
        $carAdmin = User::create([
            'name' => 'Admin',
            'apellido' => 'Carrera',
            'email' => 'carrera@gradus.com',
            'password' => Hash::make('password'),
            'tipo' => 'administrativo',
            'ci' => 'CAR-001',
            'telefono' => '70333333',
        ]);

        $carAdmin->roles()->attach($carreraRole);
        $informatica->administradores()->attach($carAdmin->id, ['role' => 'admin']);
    }
}

