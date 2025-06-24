<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id', 20)->unique();
            $table->string('employee_name');
            $table->enum('gender', ['Male', 'Female', 'Other', 'Prefer not to say']);
            $table->enum('marital_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            $table->string('phone_no', 20);
            $table->string('email')->unique();
            $table->text('address');
            $table->date('date_of_birth');
            $table->string('nationality', 100);
            $table->date('hire_date');
            $table->string('department');
            $table->string('position');
            $table->decimal('salary', 10, 2)->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['department']);
            $table->index(['hire_date']);
            $table->index(['employee_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};