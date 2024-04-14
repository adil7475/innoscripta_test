<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Integrations\NewsOrgService;
use App\Services\Integrations\NYTimesService;

class TestController extends Controller
{
    public function newsAPI()
    {
        $user = User::with('setting')->where('id', 1)->first();
        dd($user->setting->sources);
    }
}
