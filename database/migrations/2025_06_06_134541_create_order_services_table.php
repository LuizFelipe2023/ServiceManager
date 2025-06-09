<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('service_type');
            $table->text('description');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'emergency'])->default('medium');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->decimal('actual_hours', 8, 2)->nullable();
            $table->decimal('cost_estimate', 10, 2)->nullable();
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->string('location')->nullable();
            $table->text('equipment_needed')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_service_technician', function (Blueprint $table) {
            $table->foreignId('order_service_id')->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->constrained()->onDelete('cascade');
            $table->decimal('hours_worked', 8, 2)->default(0);
            $table->string('role')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->primary(['order_service_id', 'technician_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_service_technician');
        Schema::dropIfExists('order_services');
    }
};