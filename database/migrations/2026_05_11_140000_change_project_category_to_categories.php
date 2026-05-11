<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('categories')->nullable()->after('visibility');
        });

        DB::table('projects')
            ->whereNotNull('category')
            ->orderBy('id')
            ->chunkById(100, function ($projects) {
                foreach ($projects as $project) {
                    DB::table('projects')
                        ->where('id', $project->id)
                        ->update(['categories' => json_encode([$project->category])]);
                }
            });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('category', 20)->nullable()->after('visibility');
        });

        DB::table('projects')
            ->whereNotNull('categories')
            ->orderBy('id')
            ->chunkById(100, function ($projects) {
                foreach ($projects as $project) {
                    $categories = json_decode($project->categories, true);

                    DB::table('projects')
                        ->where('id', $project->id)
                        ->update(['category' => is_array($categories) ? ($categories[0] ?? null) : null]);
                }
            });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('categories');
        });
    }
};
