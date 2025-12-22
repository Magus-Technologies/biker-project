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
        Schema::create('ventas_pendientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Usuario que está creando la venta
            $table->enum('tipo', ['create', 'bulk_create'])->default('create'); // Tipo de venta: 1=create, 2=bulk_create
            $table->json('datos'); // Datos de la venta en formato JSON
            $table->timestamp('fecha_guardado')->useCurrent(); // Fecha del último autoguardado
            $table->timestamps();
            
            // Índices
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'tipo']); // Para búsquedas rápidas por usuario y tipo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_pendientes');
    }
};
