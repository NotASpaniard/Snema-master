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
            $table->integer("total_price");
            $table->integer("discount_price");
            $table->integer("final_price");
            $table->integer("status");
            $table->foreignId("payment_id")->constrained("payment_options");
            $table->foreignId("promotion_id")->constrained("promotions");
            $table->foreignId("showtime_id")->constrained("showtimes");
            $table->foreignId("booking_snacks_id")->constrained("booking_snacks");
            $table->foreignId("admin_id")->constrained("admins");
            $table->foreignId("customer_id")->constrained("customers");
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
