<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Technology;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear mi usuario Admin
        User::factory()->create([
            'name' => 'Carlos Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Crear Tecnologías
        $php = Technology::create(['name' => 'PHP', 'color' => '#777BB4']);
        $laravel = Technology::create(['name' => 'Laravel', 'color' => '#FF2D20']);
        $react = Technology::create(['name' => 'React', 'color' => '#61DAFB']);
        $css = Technology::create(['name' => 'Tailwind CSS', 'color' => '#38B2AC']);

        // 3. Crear un Proyecto de prueba
        $portfolio = Project::create([
            'title' => 'Mi Portfolio Personal',
            'description' => 'Aplicación CMS desarrollada con Laravel y Tailwind para gestión de proyectos.',
            'visibility' => 'public',
            'categories' => ['Portfolio', 'CMS'],
        ]);

        $portfolio->links()->create([
            'url' => 'https://github.com/CarloskHard/pediente',
            'type' => 'github',
            'visibility' => 'public',
            'sort_order' => 0,
        ]);

        // 4. Vincular Tecnologías al Proyecto (La Magia del N:M)
        // Asignamos Laravel, PHP y CSS a este proyecto
        $portfolio->technologies()->attach([$laravel->id, $php->id, $css->id]);

        // Crear otro proyecto dummy
        Project::create([
            'title' => 'E-Commerce Básico',
            'description' => 'Tienda online simple.',
            'visibility' => 'draft',
            'categories' => ['Tienda', 'Web'],
        ]);
    }
}
