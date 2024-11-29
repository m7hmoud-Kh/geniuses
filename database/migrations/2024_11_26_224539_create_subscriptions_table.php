<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('module_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        DB::statement("
        ALTER TABLE subscriptions
        ADD CONSTRAINT check_subscription_course_or_module
        CHECK ((category_id IS NOT NULL AND module_id IS NULL) OR (category_id IS NULL AND module_id IS NOT NULL))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
        ALTER TABLE subscriptions
        DROP CONSTRAINT check_subscription_course_or_module
        ");
        Schema::dropIfExists('subscriptions');
    }
};
