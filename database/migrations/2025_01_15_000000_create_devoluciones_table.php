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
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // Código de devolución (0000001, 0000002, etc.)
            $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2); // Monto total de la devolución
            $table->text('reason')->nullable(); // Motivo de la devolución
            $table->foreignId('user_register')->constrained('users')->onDelete('cascade'); // Usuario que registró
            $table->timestamps();
            
            // Índices para mejorar el rendimiento
            $table->index(['sale_id']);
            $table->index(['user_register']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
