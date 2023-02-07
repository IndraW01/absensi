<?php

use App\Models\User;
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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained();
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->time('telat_masuk');
            $table->string('latitude_absen_masuk');
            $table->string('longitude_absen_masuk');
            $table->string('jarak_masuk');
            $table->string('foto_absen_masuk');
            $table->time('jam_pulang')->nullable();
            $table->time('pulang_cepat')->nullable();
            $table->string('latitude_absen_pulang')->nullable();
            $table->string('longitude_absen_pulang')->nullable();
            $table->string('jarak_pulang')->nullable();
            $table->string('foto_absen_pulang')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absens');
    }
};
