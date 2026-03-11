
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seller_documents', function (Blueprint $table) {
            $table->id();

            // Relationship to sellers table
            $table->unsignedBigInteger('seller_id');

            // Document info
            $table->string('type');
            $table->string('file_path');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('admin_comment')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_documents');
    }
};

