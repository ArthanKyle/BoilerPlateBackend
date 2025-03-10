<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('collection_name');
            $table->string('name');
            $table->text('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->text('conversions_disk')->nullable();
            $table->text('manipulations')->nullable();
            $table->text('custom_properties')->nullable();
            $table->text('generated_conversions')->nullable();
            $table->text('responsive_images')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->unsignedBigInteger('size')->nullable(); // ✅ Added missing 'size' column
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
