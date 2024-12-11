<?php

namespace Database\Seeders;

use App\Actions\ArrangePositions;
use App\Models\Project;
use App\Models\Proposal;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria 200 usuários fakes.
        User::factory()->count(200)->create();

        // Pega 10 usuários em ordem aleatória
        User::query()->inRandomOrder()->limit(10)->get()
            ->each(function (User $u) { // Para cada um desses 10 usuários
                // Cria um projeto desse usuário
                $project = Project::factory()->create(['created_by' => $u->id]); 
                // Cria de 4 a 45 propostas para esse projeto.
                Proposal::factory()->count(random_int(4,45))->create(['project_id' => $project->id]);

                ArrangePositions::run($project->id);
            }); 
    }
}
