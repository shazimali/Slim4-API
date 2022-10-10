<?php

namespace App\Domain\Repositories\User;

use App\Domain\Interfaces\UserInterface;
use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Requests\CustomRequestHandler;

class UserRepository implements UserInterface
{

    public function getUsersList(Request $request)
    {

      return User::paginate(CustomRequestHandler::getParam($request,"itemPerPage"));
    }

    public function registerUser(Request $request)
    {   
      $user = new User();
      $user->name = CustomRequestHandler::getParam($request,"name");
      $user->email = CustomRequestHandler::getParam($request,"email");
      $user->password = password_hash(CustomRequestHandler::getParam($request,"password"), PASSWORD_DEFAULT) ;
      $user->save();  
      return $user;
    }

    public function findUserByID($id)
    {
      return User::where('id',$id)->first();
        
    }

    public function updateUserByID($id,Request $request)
    {
      $user = User::where('id',$id)->first();
      $user->name = CustomRequestHandler::getParam($request,"name");
      
      if(CustomRequestHandler::getParam($request,"password")){
        $user->password = password_hash(CustomRequestHandler::getParam($request,"password"), PASSWORD_DEFAULT) ;
      }
      $user->save();  
      
      return $user;
        
    }

}