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
        // Create the github_accounts table
        Schema::create('github_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the github_accounts table
        Schema::dropIfExists('github_accounts');
    }
};
