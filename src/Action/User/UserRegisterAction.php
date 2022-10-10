<?php

namespace App\Action\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Repositories\User\UserRepository;
use Respect\Validation\Validator as v;
use App\Validation\Validator;
use App\Response\CustomResponse;
use App\Requests\CustomRequestHandler;
use App\Models\User;

final class UserRegisterAction
{
   

    public function __construct(
    protected UserRepository $repository,
    protected CustomResponse $customResponse,
    protected Validator $validator)
    {}

    public function index(Request $request, Response $response): Response
    {
        $this->validator->validate($request,[
            "name" => v::notEmpty(),
            "email" => v::notEmpty()->email(),
            "password" => v::notEmpty()->length(8, null)
        ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        if($this->EmailExist(CustomRequestHandler::getParam($request,"email")))
       {
           $responseMessage = "Email already exist";
           return $this->customResponse->is400Response($response,$responseMessage);
       }

        $this->repository->registerUser($request);
        $responseMessage ="User registered successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }

    public function EmailExist($email)
    {
        $user = new User();
        $count = $user->where(['email'=>$email])->count();
        if($count==0)
        {
            return false;
        }
        return true;
    }
}