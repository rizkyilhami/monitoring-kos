<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessage extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_messages';

    protected $fillable = [
        'user_id',
        'phone_number',
        'message_type',
        'message_content',
        'status',
        'fonnte_response',
        'fonnte_message_id',
        'error_message',
        'sent_at',
        'delivered_at',
    ];

    protected $casts = [
        'fonnte_response' => 'json',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Relationship ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk messages yang berhasil terkirim
     */
    public function scopeSent($query)
    {
        return $query->whereIn('status', ['sent', 'delivered']);
    }

    /**
     * Scope untuk messages yang gagal
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope untuk messages pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk messages dalam range tanggal
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('sent_at', [$startDate, $endDate]);
    }

    /**
     * Scope untuk message type tertentu
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('message_type', $type);
    }

    /**
     * Scope untuk user tertentu
     */
    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Mark as sent
     */
    public function markAsSent($fonteResponse = null, $messageId = null): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'fonnte_response' => $fonteResponse,
            'fonnte_message_id' => $messageId,
        ]);
    }

    /**
     * Mark as delivered
     */
    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed($errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }
}
