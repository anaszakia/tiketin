<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('attendees')->onDelete('cascade');
            $table->foreignId('officer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('checkin_at')->nullable();
            $table->string('location')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
