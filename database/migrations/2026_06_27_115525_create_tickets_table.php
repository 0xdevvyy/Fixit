<?php

use App\Models\User;
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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete(); //user_id, reporter(Facilitator, teacher)
            $table->foreignIdFor(User::class, 'assigned_to')->nullable()->constrained()->cascadeOnDelete(); //assigned_to, Maintenance
            $table->string('ticket_number')->unique();
            $table->string('location')->nullable();
            $table->string('category')->default('aircon')->nullable();
            $table->string('description');
            $table->string('priority')->default('medium')->nullable();
            $table->string('status')->default('open')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
