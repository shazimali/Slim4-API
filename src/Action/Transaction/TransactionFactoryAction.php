<?php

namespace App\Action\Transaction;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Domain\Repositories\Transaction\TransactionRepository;
use App\Response\CustomResponse;
use App\Models\User;
use App\Models\Country;

final class TransactionFactoryAction
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
        $this->repository->insertBulkTransactions();
        $responseMessage = "Bulk Records are inserted in transactions table";
        return $this->customResponse->is200Response($response,$responseMessage);
    }
}