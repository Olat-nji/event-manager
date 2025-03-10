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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('event_date_time');
            $table->text('description')->nullable();
            $table->integer('duration')->comment('Duration in minutes');
            $table->string('location');
            $table->unsignedInteger('capacity')->default(0);
            $table->unsignedInteger('waitlist_capacity')->default(0);
            $table->enum('status', ['live', 'draft'])->default('draft');
            $table->softDeletes();
            $table->index(['event_date_time', 'status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
