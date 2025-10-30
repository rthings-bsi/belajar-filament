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
        Schema::create('laporan_packings', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->default(now()->toDateString());
            $table->integer('shift')->default(1);
            $table->string('no_pro');
            $table->string('work_center');
            $table->string('qty_gi')->default('0');
            $table->string('qty_gr')->default('0');
            $table->string('qty_reject')->default('0');
            $table->string('keterangan')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_packings');
    }
};
