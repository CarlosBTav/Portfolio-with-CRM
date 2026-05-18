<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documentation_client_notes', function (Blueprint $table) {
            $table->unsignedSmallInteger('pending_item_index')->nullable()->after('body');
            $table->index(['documentation_slug', 'pending_item_index'], 'doc_notes_slug_pending_idx');
        });
    }

    public function down(): void
    {
        Schema::table('documentation_client_notes', function (Blueprint $table) {
            $table->dropIndex('doc_notes_slug_pending_idx');
            $table->dropColumn('pending_item_index');
        });
    }
};
