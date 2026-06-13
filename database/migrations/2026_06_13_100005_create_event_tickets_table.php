<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('quota')->default(0);
            $table->unsignedInteger('quota_sold')->default(0);
            $table->dateTime('sales_start')->nullable();
            $table->dateTime('sales_end')->nullable();
            $table->enum('status', ['active', 'inactive', 'sold_out'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_tickets');
    }
};
