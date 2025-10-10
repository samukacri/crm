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
        Schema::create('property_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('in_stock')->default(0);
            $table->integer('allocated')->default(0);

            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');

            $table->integer('warehouse_id')->unsigned()->nullable();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');

            $table->integer('warehouse_location_id')->unsigned()->nullable();
            $table->foreign('warehouse_location_id')->references('id')->on('warehouse_locations')->onDelete('SET NULL');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_inventories');
    }
};