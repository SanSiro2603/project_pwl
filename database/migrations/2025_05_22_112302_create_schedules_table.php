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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->foreignId('studio_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        $table->boolean('is_available')->default(true);
        $table->timestamps();
        
        $table->unique(['studio_id', 'date', 'start_time']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
