<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('property_inventories', function (Blueprint $table) {
            $table->dropForeign(['warehouse_location_id']);

            $table->foreign('warehouse_location_id')->references('id')->on('warehouse_locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('property_inventories', function (Blueprint $table) {
            $table->dropForeign(['warehouse_location_id']);

            $table->foreign('warehouse_location_id')->references('id')->on('warehouse_locations')->onDelete('set null');
        });
    }
};