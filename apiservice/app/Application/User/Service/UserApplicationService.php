<?php

namespace App\Application\User\Service;

use App\Application\User\Factory\UserFactory;
use App\Application\User\Repository\UserRepository;
use App\Domain\User\User;


class UserApplicationService {


  public $userFactory;
  public $userRepo;

  /**
   * @param UserFactory $userFactory
   * @param UserDataService $userDataService
   */
  public function __construct(UserFactory $userFactory, UserRepository $userRepo)
  {
    $this->userFactory = $userFactory;
    $this->userRepo = $userRepo;
  }


  /**
   * Find the user by its id
   * @param  ?int $id
   * @return User
   */
  public function find(?int $id): User {

    $data = $this->userRepo->find($id);
    return $this->userFactory->create($data);

  }


}
