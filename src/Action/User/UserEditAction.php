<?php

namespace App\Action\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Repositories\User\UserRepository;
use App\Response\CustomResponse;

final class UserEditAction
{
    public function __construct(
    protected UserRepository $repository,
    protected CustomResponse $customResponse,)
    {}

    public function index($id,Response $response): Response
    {
        return $this->customResponse->is200Response($response,$this->repository->findUserByID($id));
    }
}