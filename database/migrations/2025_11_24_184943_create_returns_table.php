<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending', 'reviewed', 'rejected', 'approved', 'shipped', 'received', 'rejected_by_admin'])
                  ->default('pending');
            $table->text('reason')->nullable(); 
            $table->string('item_proof')->nullable(); 
            $table->string('shipment_proof')->nullable(); 
            $table->string('refund_proof')->nullable(); 
            $table->text('review_reason')->nullable(); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
