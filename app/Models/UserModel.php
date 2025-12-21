<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected function initialize(): void
    {
        parent::initialize();

        $this->allowedFields = [
            ...$this->allowedFields,

            'bio',
        ];
    }

    public function getBioByUsername(string $username): ?string
    {
        $user = $this->where('username', $username)->first();
        return $user ? $user->bio : null;
    }
}
