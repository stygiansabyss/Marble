<?php

namespace App\Services\SignUps\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\SignUps\Models\SignUp;

class Weekly extends BaseController
{
    /**
     * @var \App\Services\SignUps\Models\SignUp
     */
    private $signUps;

    /**
     * @param \App\Services\SignUps\Models\SignUp $signUps
     */
    public function __construct(SignUp $signUps)
    {
        $this->signUps = $signUps;
    }

    public function index()
    {
        return $this->view();
    }

    public function store()
    {
        $this->signUps->newSignUp(request('mmr'));

        return redirect(route('home'))
            ->with('message', 'You have been signed up!');
    }
}
