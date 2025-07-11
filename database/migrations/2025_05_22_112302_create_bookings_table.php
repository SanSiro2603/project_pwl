<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('booking_code')->unique();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('studio_id')->constrained()->onDelete('cascade');
        $table->date('booking_date');
        $table->time('start_time');
        $table->time('end_time');
        $table->integer('duration_hours');
        $table->decimal('total_price', 10, 2);
        $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])
              ->default('pending');
        $table->enum('payment_status', ['unpaid', 'pending', 'paid'])
              ->default('unpaid');
        $table->string('payment_proof')->nullable();
        $table->text('notes')->nullable();
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
