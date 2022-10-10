<?php

namespace App\Action\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Repositories\User\UserRepository;
use Respect\Validation\Validator as v;
use App\Validation\Validator;
use App\Response\CustomResponse;
use App\Requests\CustomRequestHandler;

final class UserUpdateAction
{

    public function __construct(
        protected UserRepository $repository, 
        protected CustomResponse $customResponse,
        protected Validator $validator)
    {}

    public function index($id,Request $request, Response $response): Response
    {
        $this->validator->validate($request,[
            "name" => v::notEmpty()
        ]);

        if($this->validator->failed())
        {
            $responseMessage = $this->validator->errors;
            return $this->customResponse->is400Response($response,$responseMessage);
        }

        $this->repository->updateUserByID($id,$request);
        $responseMessage ="user updated successfully";
        return $this->customResponse->is200Response($response,$responseMessage);
    }
}