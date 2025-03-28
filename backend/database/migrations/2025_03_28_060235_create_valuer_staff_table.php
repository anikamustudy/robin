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
        Schema::create('valuer_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('valuer_id')->constrained('valuers');
            $table->foreignId('user_id')->unique()->constrained('users');
            $table->string('designation');
            $table->string('staff_name');
            $table->string('staff_address');
            $table->string('staff_contact_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valuer_staff');
    }
};
