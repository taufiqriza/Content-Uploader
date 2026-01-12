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
        Schema::create('content_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('media_asset_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Creator
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->enum('content_type', ['post', 'reel', 'story', 'youtube_video', 'short']);
            $table->enum('status', ['draft', 'pending_approval', 'approved', 'scheduling', 'publishing', 'done', 'partial_fail', 'failed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->json('target_platforms')->nullable(); // ['youtube', 'instagram']
            $table->timestamps();

            $table->index(['organization_id', 'status']);
            $table->index('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_items');
    }
};
