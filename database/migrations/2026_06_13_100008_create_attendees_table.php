<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('ticket_code')->unique();
            $table->string('qr_code')->nullable();
            $table->enum('status', ['unused', 'used', 'expired'])->default('unused');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
