<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documentation_client_notes', function (Blueprint $table) {
            $table->id();
            $table->string('documentation_slug', 191);
            $table->text('body');
            $table->timestamps();

            $table->index('documentation_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documentation_client_notes');
    }
};
