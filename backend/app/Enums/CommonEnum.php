<?php

namespace App\Enums;

use App\Traits\EnumsHelpers;

enum CommonEnum: string
{
    use EnumsHelpers;

    const SUCCESS = 'success';
    const ERROR = 'error';
    const DEFAULT_PAGINATION = 10;
}
