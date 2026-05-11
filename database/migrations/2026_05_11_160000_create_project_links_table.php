<?php

use App\Models\Project;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('url');
            $table->string('type');
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Project::query()->each(function (Project $project): void {
            $sortOrder = 0;

            if ($project->url_repo) {
                $project->links()->create([
                    'url' => $project->url_repo,
                    'type' => 'github',
                    'visibility' => 'public',
                    'sort_order' => $sortOrder++,
                ]);
            }

            if ($project->url_demo) {
                $type = match ($project->demo_cta_label) {
                    'Visitar' => 'visit',
                    'Ver app' => 'app',
                    default => 'demo',
                };

                $project->links()->create([
                    'url' => $project->url_demo,
                    'type' => $type,
                    'visibility' => 'public',
                    'sort_order' => $sortOrder++,
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_links');
    }
};
