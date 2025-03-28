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
        Schema::create('membership_requests', function (Blueprint $table) {
           $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->enum('role', ['bank', 'valuer', 'bank_staff', 'valuer_staff']);
            $table->foreignId('bank_id')->nullable()->constrained('banks');
            $table->foreignId('branch_id')->nullable()->constrained('branches');
            $table->foreignId('valuer_id')->nullable()->constrained('valuers');
            $table->enum('status', ['pending', 'approved', 'rejected', 'blacklisted'])->default('pending');
            $table->text('reason')->nullable();
            $table->string('temp_password')->nullable();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_requests');
    }
};
