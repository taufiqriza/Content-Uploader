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
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->enum('platform', ['youtube', 'tiktok', 'instagram', 'facebook', 'threads']);
            $table->string('platform_user_id')->nullable(); // ID dari platform
            $table->string('name'); // Username/handle
            $table->string('avatar_url')->nullable();
            $table->text('enc_access_token'); // Encrypted
            $table->text('enc_refresh_token')->nullable(); // Encrypted
            $table->timestamp('token_expires_at')->nullable();
            $table->json('scopes')->nullable(); // ['publish_video', 'read_insights']
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['organization_id', 'platform']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
