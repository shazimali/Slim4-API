<?php

namespace App\Action\Transaction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Repositories\Transaction\TransactionRepository;
use App\Response\CustomResponse;
use App\Requests\CustomRequestHandler;
use App\Models\User;
use App\Models\Country;

final class TransactionListAction
{
    public function __construct(
        protected TransactionRepository $repository,
        protected CustomResponse $customResponse)
    {
        $this->repository = $repository;
        $this->customResponse = $customResponse;
    }

    public function __invoke(Request $request, Response $response): Response
    {

        //Getting Token
        $responseMessage = [
            'transactions' => $this->repository->getTransactionsList($request),
            'users' => User::all(),
            'countries' => Country::all()
        ];
        return $this->customResponse->is200Response($response,$responseMessage);
    }
}