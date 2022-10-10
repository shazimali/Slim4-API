<?php

namespace App\Action\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Repositories\User\UserRepository;
use App\Response\CustomResponse;
final class UserListAction
{

    public function __construct(
    protected UserRepository $repository, 
    protected CustomResponse $customResponse)
    {}

    public function __invoke(Request $request, Response $response): Response
    {
        return $this->customResponse->is200Response($response,$this->repository->getUsersList($request));
    }
}