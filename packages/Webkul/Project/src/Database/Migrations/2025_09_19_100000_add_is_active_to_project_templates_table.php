<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('project_templates') && ! Schema::hasColumn('project_templates', 'is_active')) {
            Schema::table('project_templates', function (Blueprint $table) {
                $table->boolean('is_active')->default(true)->after('description');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('project_templates') && Schema::hasColumn('project_templates', 'is_active')) {
            Schema::table('project_templates', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }
    }
};