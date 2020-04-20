<?php


namespace App\Repository\User;


use App\Model\User\UserInterface;

interface UserRepositoryInterface
{
    public function find(int $id): UserInterface;
    public function delete(UserInterface $user): void;
    public function save(UserInterface $user): void;
}