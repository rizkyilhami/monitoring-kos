<?php

namespace App\Console\Commands;

use App\Services\FirebaseService;
use Illuminate\Console\Command;

class SetupFirebaseData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'firebase:setup {user_id=1 : The user ID to setup}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Setup sample data di Firebase untuk testing';

    /**
     * Execute the console command.
     */
    public function handle(FirebaseService $firebaseService): int
    {
        $userId = $this->argument('user_id');

        $this->info("Setting up Firebase data for user: $userId");

        try {
            // Setup Arus data
            $this->line('Adding arus data...');
            $firebaseService->saveData("users/$userId/arus", [
                'value' => 5.2,
                'timestamp' => now()->timestamp,
                'unit' => 'A',
                'status' => 'normal',
                'lastUpdate' => now()->toDateTimeString(),
            ]);
            $this->info('✓ Arus data saved');

            // Setup Daya data
            $this->line('Adding daya data...');
            $firebaseService->saveData("users/$userId/daya", [
                'value' => 1200,
                'timestamp' => now()->timestamp,
                'unit' => 'W',
                'status' => 'normal',
                'lastUpdate' => now()->toDateTimeString(),
            ]);
            $this->info('✓ Daya data saved');

            // Setup Tagihan data
            $this->line('Adding tagihan data...');
            $firebaseService->saveData("users/$userId/tagihan", [
                'bulan' => now()->format('F Y'),
                'no_meter' => '123456789',
                'penggunaan' => 150,
                'harga_per_kwh' => 1550,
                'total_tagihan' => 232500,
                'status_pembayaran' => 'Belum Dibayar',
                'batas_pembayaran' => now()->addMonth()->format('Y-m-d'),
                'tanggal_pembuatan' => now()->toDateTimeString(),
            ]);
            $this->info('✓ Tagihan data saved');

            $this->newLine();
            $this->info('✅ Firebase data setup completed successfully!');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("❌ Error: {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
