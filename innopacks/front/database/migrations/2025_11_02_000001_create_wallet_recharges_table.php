<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wallet_recharges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->index();
            $table->decimal('amount', 20, 2);
            $table->string('status')->default('pending');
            $table->string('gateway')->default('zarinpal');
            $table->string('authority')->nullable();
            $table->string('ref_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('error')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('wallet_recharges');
    }
};
