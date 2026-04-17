<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            
// Fixed: Use 'rejected' consistent with controller/validation/form
            $table->enum('status', ['pending', 'pinjam', 'rejected', 'kembali'])->default('pending');
            
            // PERBAIKAN 2: Tambahkan kolom yang ada di Model Loan.php tapi belum ada di migration
            $table->date('expected_return_date')->nullable();
            $table->time('expected_return_time')->nullable();
            
            $table->timestamp('borrowed_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};