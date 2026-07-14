<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menyimpan history pengiriman WhatsApp
 * 
 * Uncomment dan jalankan jika ingin tracking pengiriman:
 * php artisan migrate
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Jika belum ada kolom phone_number di users table
        if (! Schema::hasColumn('users', 'phone_number')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone_number')->nullable()->after('email');
                $table->string('phone_number_normalized')->nullable()->after('phone_number');
                $table->boolean('whatsapp_notifications_enabled')->default(true)->after('phone_number_normalized');
            });
        }

        // Buat table untuk history pengiriman
        if (! Schema::hasTable('whatsapp_messages')) {
            Schema::create('whatsapp_messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('phone_number');
                $table->enum('message_type', ['tagihan', 'monitoring', 'alert', 'reminder', 'other'])->default('other');
                $table->text('message_content');
                $table->enum('status', ['pending', 'sent', 'failed', 'delivered'])->default('pending');
                $table->json('fonnte_response')->nullable();
                $table->string('fonnte_message_id')->nullable();
                $table->text('error_message')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->timestamps();

                $table->index('user_id');
                $table->index('status');
                $table->index('message_type');
                $table->index('sent_at');
            });
        }

        // Buat table untuk config WhatsApp user
        if (! Schema::hasTable('user_whatsapp_configs')) {
            Schema::create('user_whatsapp_configs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
                $table->string('phone_number');
                $table->string('phone_number_normalized');
                $table->boolean('notifications_enabled')->default(true);
                $table->enum('notification_frequency', ['daily', 'weekly', 'monthly', 'per-transaction'])->default('monthly');
                $table->time('preferred_send_time')->nullable();
                $table->json('notification_preferences')->nullable();
                $table->timestamp('last_message_sent_at')->nullable();
                $table->timestamps();

                $table->index('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
        Schema::dropIfExists('user_whatsapp_configs');

        if (Schema::hasColumn('users', 'phone_number')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['phone_number', 'phone_number_normalized', 'whatsapp_notifications_enabled']);
            });
        }
    }
};
