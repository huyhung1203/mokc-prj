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
        //
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->nullable();
            $table->string('full_name',50)->nullable(false);
            $table->string('email',255)->unique()->nullable();
            $table->string('phone_number',20)->nullable(false);
            $table->string('address',255)->nullable();
            $table->date('dob')->nullable(false);
            $table->boolean('gender')->nullable(false);
            $table->boolean('is_gues')->nullable(false)->default(0);
            $table->timestamps();
            $table->date('ended_date')->nullable(false);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('members');
    }
};
