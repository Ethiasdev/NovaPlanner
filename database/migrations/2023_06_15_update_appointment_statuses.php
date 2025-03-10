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
        // Update existing statuses to the new values
        DB::table('appointments')
            ->where('status', 'pending')
            ->update(['status' => 'nieuw']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original statuses
        DB::table('appointments')
            ->where('status', 'nieuw')
            ->update(['status' => 'pending']);
    }
}; 