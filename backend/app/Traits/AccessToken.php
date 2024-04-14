<?php

namespace App\Traits;

trait AccessToken {
    /**
     * @param string $key
     * @return string
     */
    public function tokenKey(string $key): string
    {
        return $key . '-AuthToken';
    }
}
