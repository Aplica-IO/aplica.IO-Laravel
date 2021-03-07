<?php

namespace App\Models\Interfaces;

Interface AuthInterface
{
    public function login($data);
    public function register($data);
}

