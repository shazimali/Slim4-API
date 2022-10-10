<?php

namespace App\Domain\Repositories\Transaction;

use App\Domain\Interfaces\TransactionInterface;
use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use App\Models\Transaction;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Requests\CustomRequestHandler;
use App\Factories\TransactionFactory;

class TransactionRepository implements TransactionInterface
{

    public function getTransactionsList(Request $request)
    {   
        $date = CustomRequestHandler::getParam($request,'date');
        $country = CustomRequestHandler::getParam($request,'country');
        $user = CustomRequestHandler::getParam($request,'user');
        $paginate = CustomRequestHandler::getParam($request,'itemPerPage');

        if($user){
            $user_arr = explode('-',$user);
            $user = $user_arr[1];
        }
        if($country){
            $country_arr = explode('-',$country);
            $country = $country_arr[1];
        }
        
        $query = Transaction::with('user','country');

        $query->when($date, function ($q) use($date) {
            return $q->whereDate('created_at',$date);
        });
        $query->when($country, function ($q) use($country) {
            return $q->where('country_id',$country);
        });

        $query->when($user, function ($q) use($user) {
            return $q->where('user_id',$user);
        });

        return $query->paginate($paginate);
    }

    public function insertBulkTransactions()
    {
        $factory = new TransactionFactory();
        for ($x = 0; $x <= 50000; $x++) {
            Transaction::create($factory->createTransaction());
        }
    }

}