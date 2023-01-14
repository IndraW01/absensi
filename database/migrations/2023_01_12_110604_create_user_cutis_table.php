<?php

use App\Models\UserDetail;
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
        Schema::create('user_cutis', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserDetail::class)->unique()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('cuti');
            $table->integer('cuti_bersama');
            $table->integer('cuti_menikah');
            $table->integer('cuti_melahirkan');
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
        Schema::dropIfExists('user_cutis');
    }
};
