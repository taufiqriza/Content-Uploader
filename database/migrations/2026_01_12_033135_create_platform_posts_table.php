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
        Schema::create('platform_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('social_account_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending', 'processing', 'published', 'failed', 'cancelled'])->default('pending');
            $table->string('external_post_id')->nullable(); // ID dari platform (yt video id, ig media id)
            $table->string('external_url')->nullable(); // URL publik post
            $table->text('error_message')->nullable();
            $table->unsignedTinyInteger('attempt_count')->default(0);
            $table->timestamp('last_attempt_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('idempotency_key')->unique()->nullable(); // Mencegah double post
            $table->timestamps();

            $table->index(['content_item_id', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_posts');
    }
};
