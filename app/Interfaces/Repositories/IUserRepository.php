<?php


namespace App\Interfaces\Repositories;


use App\Entities\User;
use Doctrine\Common\Collections\Collection;

interface IUserRepository
{
    public function getAllUsers(): Collection;

    public function getUserById($id): ?User;

    public function save(User $user): User;

    public function delete(User $user): User;
}
