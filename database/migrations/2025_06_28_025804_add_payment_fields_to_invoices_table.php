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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('payment_percentage', 5, 2)->default(100.00)->after('notes');
            $table->integer('payment_sequence')->default(1)->after('payment_percentage');
            $table->string('currency', 3)->default('IDR')->after('payment_sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['payment_percentage', 'payment_sequence', 'currency']);
        });
    }
};
