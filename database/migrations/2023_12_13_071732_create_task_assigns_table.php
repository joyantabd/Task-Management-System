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
        Schema::create('task_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('member_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('task_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('dead_line')->useCurrent();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('priority')->default(0);
            $table->string('description')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_assigns');
    }
};
