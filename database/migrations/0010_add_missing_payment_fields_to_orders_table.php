<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'metodo_pago')) {
                $table->string('metodo_pago')->nullable();
            }

            if (!Schema::hasColumn('orders', 'estado_pago')) {
                $table->string('estado_pago')->nullable();
            }

            if (!Schema::hasColumn('orders', 'fecha_pago')) {
                $table->timestamp('fecha_pago')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'fecha_pago')) {
                $table->dropColumn('fecha_pago');
            }

            if (Schema::hasColumn('orders', 'estado_pago')) {
                $table->dropColumn('estado_pago');
            }

            if (Schema::hasColumn('orders', 'metodo_pago')) {
                $table->dropColumn('metodo_pago');
            }
        });
    }
};
