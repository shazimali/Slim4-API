<?php

namespace App\Action\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Repositories\Auth\AuthRepository;
use Respect\Validation\Validator as v;
use App\Validation\Validator;
use App\Response\CustomResponse;
use App\Requests\CustomRequestHandler;
use App\Models\User;
final class AuthAction
{
   

    public function __construct(
    protected AuthRepository $repository,
    protected CustomResponse $customResponse,
    protected Validator $validator,
    protected User $user
    )
    {}

    public function token(Request $request, Response $response): Response
    {
        //validate
        $this->validator->validate($request,[
            "email" => v::notEmpty()->email(),
            "password" => v::notEmpty()
        ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        //verify
        $verifyAccount = $this->verifyAccount(
            CustomRequestHandler::getParam($request,"password"),
            CustomRequestHandler::getParam($request,"email"));

        $passwordHash = $this->hashPassword(CustomRequestHandler::getParam($request,'password'));

        if($verifyAccount==false)
        {
            $responseMessage = "invalid username or password";
            return $this->customResponse->is400Response($response,$responseMessage);
        }
      
        //Getting Token
        $responseMessage = [
            'token' => $this->repository->getToken($request),
            'user' => $this->user
        ];
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function verifyAccount($password,$email)
    {
        $count = $this->user->where(["email"=>$email])->count();
        if($count==0)
        {
            return false;
        }
        $user = $this->user->where(["email"=>$email])->first();
        $hashedPassword = $user->password;
        $verify = password_verify($password,$hashedPassword);
        if($verify==false)
        {
            return false;
        }
        $this->user = $user;
        return true;
    }

    public function hashPassword($password)
    {
        return password_hash($password,PASSWORD_DEFAULT);
    }

}