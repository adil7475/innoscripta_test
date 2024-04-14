<?php

namespace App\Adapter\Baseline;

interface NewsAdapterInterface
{
    public function formatRequest(int $page): array;

    public function formatResponse(array $data): array;
}
