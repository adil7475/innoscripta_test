<?php

namespace App\Enums;

use App\Traits\EnumsHelpers;

enum NewsOrgAPIEnum
{
    use EnumsHelpers;

    const API_KEY = 'apiKey';
    const DEFAULT_PER_PAGE = 100;

}
