<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('status')->default('active');
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('organization_id')->nullable()->constrained('organizations')->onDelete('set null');
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};