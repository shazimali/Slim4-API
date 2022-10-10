<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\App;

return function (App $app)
{
    //Token
    $app->post('/auth/token', \App\Action\Auth\AuthAction::class . ':token');

    //User
    $app->get('/user', \App\Action\User\UserListAction::class);
    $app->post('/user/register', \App\Action\User\UserRegisterAction::class . ':index');
    $app->get('/user/{id}', \App\Action\User\UserEditAction::class . ':index');
    $app->put('/user/{id}', \App\Action\User\UserUpdateAction::class . ':index');

    //Transactions
    $app->get('/transactions', \App\Action\Transaction\TransactionListAction::class);
    $app->post('/transactions', \App\Action\Transaction\TransactionFactoryAction::class);

};