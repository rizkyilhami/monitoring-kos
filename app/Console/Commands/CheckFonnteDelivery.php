<?php

namespace App\Console\Commands;

use App\Models\WhatsappMessage;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class CheckFonnteDelivery extends Command
{
    protected $signature = 'fonnte:check-delivery {--limit=50 : Max messages to check}';

    protected $description = 'Check delivery status from Fonnte for recent whatsapp_messages with sent status';

    public function handle(): int
    {
        $limit = (int) $this->option('limit');

        $messages = WhatsappMessage::where('status', 'sent')
            ->whereNotNull('fonnte_response')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();

        if ($messages->isEmpty()) {
            $this->info('No sent messages with fonnte_response found.');
            return self::SUCCESS;
        }

        $statusUrl = env('FONNTE_STATUS_URL', '');
        if (empty($statusUrl)) {
            $this->warn('FONNTE_STATUS_URL not configured in .env — command will only dump requestids from DB.');
        }

        $client = new Client(['timeout' => 10]);

        foreach ($messages as $m) {
            $resp = $m->fonnte_response ?? null;
            $requestid = null;
            if (is_array($resp) && isset($resp['requestid'])) {
                $requestid = $resp['requestid'];
            } elseif (is_array($resp) && isset($resp[0]) && isset($resp[0]['requestid'])) {
                $requestid = $resp[0]['requestid'];
            }

            $this->line("Checking message id={$m->id} phone={$m->phone_number} requestid=" . ($requestid ?? 'n/a'));

            if ($requestid && ! empty($statusUrl)) {
                try {
                    $res = $client->get($statusUrl, ['query' => ['requestid' => $requestid]]);
                    $body = json_decode((string) $res->getBody(), true);
                    $this->line(' -> status: ' . json_encode($body));

                    // If provider reports delivered, update record
                    if (is_array($body) && ! empty($body['delivered']) && $body['delivered'] === true) {
                        $m->update(['status' => 'delivered', 'delivered_at' => now()]);
                        $this->info("Message {$m->id} marked delivered");
                    }
                } catch (\Throwable $e) {
                    $this->error(' -> error: ' . $e->getMessage());
                }
            }
        }

        return self::SUCCESS;
    }
}
