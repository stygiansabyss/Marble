<?php

namespace App\Http\Controllers;

use App\Apis\OpenDota\Players;
use Syntax\SteamApi\Facades\SteamApi;

class HomeController extends BaseController
{
    public function index()
    {
        $openDota = app(Players::class);
        dd($openDota->getPlayer(76561198049801103));
        return $this->view();
    }
}
