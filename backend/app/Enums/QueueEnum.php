<?php

namespace App\Enums;

use App\Traits\EnumsHelpers;

enum QueueEnum
{
    use EnumsHelpers;

    const SYNC_INTEGRATIONS = 'SYNC_INTEGRATIONS';
    const SAVE_NEWS = 'SAVE_NEWS';
}
