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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_warehouse_id');
            $table->unsignedBigInteger('destination_warehouse_id');
            $table->unsignedBigInteger('user_id');
            $table->date('sentDate');
            $table->date('receivedDate')->nullable();
            $table->enum('status', ['iniciado', 'enviado', 'recibido', 'cancelado'])->default('iniciado');
            $table->timestamps();

            $table->foreign('source_warehouse_id')->references('id')
                ->on('warehouses')->onDelete('cascade');

            $table->foreign('destination_warehouse_id')->references('id')
                ->on('warehouses')->onDelete('cascade');

            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
