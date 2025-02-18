<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); 
            $table->string('email'); 
            $table->text('address');
            $table->string('payment_method')->default('cod'); 
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('final_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamps();
        });
        DB::statement('UPDATE orders SET final_price = total_price');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
