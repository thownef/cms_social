<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Hash;

trait HasCheckAccess
{
    public function checkCorrectPass(string $pass): bool
    {
        return Hash::check($pass, $this->password);
    }
}
