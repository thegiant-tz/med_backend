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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->string('destination');
            $table->enum('status', ['Pending', 'Busy', 'Cancelled', 'Completed'])->default('Pending');
            $table->date('expires_at');
            $table->foreignId('recruiter_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('driver_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
