<?php


namespace App\Service;


use App\Model\User\UserInterface;
use App\Repository\User\UserRepositoryInterface;

class DeleteUserService
{
    private UserRepositoryInterface $repository;

    /**
     * DeleteUserService constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserInterface $user
     */
    public function execute(UserInterface $user): void {
        $this->repository->delete($user);;
    }
}
