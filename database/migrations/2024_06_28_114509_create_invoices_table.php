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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->integer('customer_id')->unsigned();
            $table->date('date');
            $table->date('due_date');
            $table->string('reference')->nullable();
            $table->text('terms_and_conditions');
            $table->integer('sub_total');
            $table->integer('discount')->default(0);
            $table->integer('total');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
