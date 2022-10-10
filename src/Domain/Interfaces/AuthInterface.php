<?php
namespace App\Domain\Interfaces;

use Psr\Http\Message\ServerRequestInterface as Request;

interface AuthInterface {

    public function getToken(Request $request);

}