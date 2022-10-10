<?php
namespace App\Domain\Interfaces;
use Psr\Http\Message\ServerRequestInterface as Request;

interface TransactionInterface {
    public function getTransactionsList(Request $data);
    public function insertBulkTransactions();
}