<?php
namespace App\Domain\Interfaces;
use Psr\Http\Message\ServerRequestInterface as Request;

interface UserInterface {
    public function getUsersList(Request $data);
    public function registerUser(Request $data);
    public function findUserByID($id);
    public function updateUserByID($id,Request $data);
}