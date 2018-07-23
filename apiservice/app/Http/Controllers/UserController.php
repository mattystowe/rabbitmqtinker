<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\User\User;
use App\Application\User\Service\UserApplicationService;

class UserController extends Controller
{


    protected $userService;


    public function __construct(UserApplicationService $userService)
    {
      $this->userService = $userService;
    }


    public function getUser($id)
    {
      $user = $this->userService->find($id);
      return $user;

    }

}
