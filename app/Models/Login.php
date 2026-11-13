<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;

/**
 * Login Model (SEQ-001).
 * Memeriksa kredensial ke tabel users.
 */
class Login
{
    /**
     * cekDatabase(username, password) => statusData()
     * Mengembalikan User jika kredensial cocok, atau null jika tidak.
     */
    public static function cekDatabase(string $username, string $password): ?User
    {
        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return null;
    }
}
