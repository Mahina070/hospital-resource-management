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
        Schema::create('resource_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resource_id'); // FK to resources table
            $table->string('resource_name');
            $table->string('resource_type');
            $table->integer('quantity_requested');
            $table->string('requested_by'); // Staff name
            $table->string('requested_position'); // Staff position/role
            $table->string('department')->nullable(); // Department of requester
            $table->text('reason')->nullable(); // Reason for request
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamp('approved_at')->nullable();
            $table->string('approved_by')->nullable(); // Admin who approved/rejected
            $table->timestamps();
            
            $table->foreign('resource_id')->references('id')->on('resources')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_bookings');
    }
};
