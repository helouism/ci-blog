<?php

namespace App\Models;

use CodeIgniter\Model;

class EmailChangeRequestModel extends Model
{
    protected $table = 'email_change_requests';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'object';

    protected $allowedFields = [
        'user_id',
        'new_email',
        'token_hash',
        'expires_at',
        'created_at',
        'used_at',
        'ip_address',
        'user_agent',
    ];

    // No CI timestamps because we use custom columns (created_at, used_at)
    protected $useTimestamps = false;

    /**
     * Create or replace a pending email-change request for a user.
     * This enforces: one active request per user.
     */
    public function upsertRequest(
        int $userId,
        string $newEmail,
        string $tokenHash,
        string $expiresAt,
        ?string $ipAddress = null,
        ?string $userAgent = null
    ): bool {
        $now = date('Y-m-d H:i:s');

        // If exists, update; else insert.
        $existing = $this->where('user_id', $userId)->first();

        $data = [
            'user_id' => $userId,
            'new_email' => $newEmail,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt,
            'created_at' => $now,
            'used_at' => null,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ];

        if ($existing) {
            return (bool) $this->update($existing->id, $data);
        }

        return (bool) $this->insert($data);
    }

    /**
     * Find a request that is:
     * - owned by userId
     * - token hash matches
     * - not used
     * - not expired
     */
    public function findValidByUserIdAndTokenHash(int $userId, string $tokenHash)
    {
        $now = date('Y-m-d H:i:s');

        return $this->where('user_id', $userId)
            ->where('token_hash', $tokenHash)
            ->where('used_at', null)
            ->where('expires_at >=', $now)
            ->first();
    }

    public function markUsed(int $id): bool
    {
        return (bool) $this->update($id, [
            'used_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function deleteByUserId(int $userId): bool
    {
        return (bool) $this->where('user_id', $userId)->delete();
    }

    public function cleanupExpired(): int
    {
        $now = date('Y-m-d H:i:s');

        // delete expired OR used long ago if you want; here: only expired + unused
        return $this->where('used_at', null)
            ->where('expires_at <', $now)
            ->delete();
    }
}
