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
        Schema::table('service_bookings', function (Blueprint $table) {
            DB::statement("ALTER TABLE service_bookings DROP CONSTRAINT IF EXISTS service_bookings_status_check");

            // Add the new CHECK constraint including 'completed'
            DB::statement("ALTER TABLE service_bookings ADD CONSTRAINT service_bookings_status_check CHECK (status IN ('pending', 'approved', 'cancelled', 'completed'))");
    
            // Set the new default to 'pending'
            DB::statement("ALTER TABLE service_bookings ALTER COLUMN status SET DEFAULT 'pending'");
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            //
        });
    }
};
