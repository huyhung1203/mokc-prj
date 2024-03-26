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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name',50)->nullable(false);
            $table->string('email',255)->unique()->nullable(false);
            $table->string('phone_number',20)->nullable(false);
            $table->string('password',255)->nullable(false);
            $table->date('dob')->nullable(false);
            $table->boolean('level')->comment('0:admin,1:staff')->nullable(false);
            $table->boolean('force_password_change')->nullable(false)->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
