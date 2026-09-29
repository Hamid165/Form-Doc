<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * SI-BASTIK: Expand form_bastiks for approval workflow.
     *
     * New status values: 'submitted', 'rejected' (added to existing draft/final/signed/void).
     * SQLite stores enum as TEXT, so new values are compatible without column type change.
     */
    public function up(): void
    {
        Schema::table('form_bastiks', function (Blueprint $table) {
            $table->text('rejection_note')->nullable()->after('status');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('rejection_note');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_bastiks', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['rejection_note', 'approved_by', 'approved_at']);
        });
    }
};
