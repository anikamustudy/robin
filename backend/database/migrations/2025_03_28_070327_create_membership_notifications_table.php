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
        Schema::create('membership_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_request_id')->constrained('membership_requests');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->enum('type', ['approval', 'rejection', 'blacklist']);
            $table->text('message');
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_notifications');
    }
};
