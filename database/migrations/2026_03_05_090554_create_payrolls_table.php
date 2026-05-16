<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('month');
            $table->year('year');
            $table->decimal('basic_salary', 10, 2);
            $table->integer('working_days');
            $table->integer('days_attended');
            $table->decimal('net_salary', 10, 2);
            $table->enum('payment_status', ['Paid', 'Unpaid', 'Processing'])->default('Unpaid');
            $table->date('payment_date')->nullable();
            $table->timestamps();

            $table->unique(['employee_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
