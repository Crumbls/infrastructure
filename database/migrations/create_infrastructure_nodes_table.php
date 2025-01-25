<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('infrastructure_nodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('status')->default('operational');
            $table->json('metadata')->nullable();
            $table->nestedSet();
            $table->timestamps();
        });

        Schema::create('infrastructure_node_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('infrastructure_nodes')->onDelete('cascade');
            $table->foreignId('child_id')->constrained('infrastructure_nodes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('infrastructure_node_relations');
        Schema::dropIfExists('infrastructure_nodes');
    }
};
