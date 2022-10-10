<?php

namespace App\Domain\Repositories\Auth;

use App\Domain\Interfaces\AuthInterface;
use Illuminate\Pagination;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Pagination\Paginator;
use App\Requests\CustomRequestHandler;
use App\Models\User;
use Firebase\JWT\JWT;

class AuthRepository implements AuthInterface
{

    public function getToken(Request $request)
    {
      
        $now = time();
        $future = strtotime('+12 hour',$now);
        $secretKey = $_ENV['JWT_SECRET_KEY'];
        $payload = [
         "jti"=>CustomRequestHandler::getParam($request,"email"),
         "iat"=>$now,
         "exp"=>$future
        ];
        return  JWT::encode($payload,$secretKey,"HS256");
    }

}