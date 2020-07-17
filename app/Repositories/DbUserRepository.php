<?php


namespace App\Repositories;

use App\Entities\User;
use App\Interfaces\Repositories\IUserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DbUserRepository extends EntityRepository implements IUserRepository {
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        parent::__construct($this->entityManager, $this->entityManager->getClassMetadata(User::class));
    }

    public function getAllUsers(): Collection {
        $dql = "SELECT u FROM App\\Entities\\User u ORDER BY u.lastName, u.firstName";

        $users = $this->entityManager->createQuery($dql)->getResult();
        return $users;
    }

    public function getUserById($id): ?User {
        $dql = "SELECT u FROM App\\Entities\\User u WHERE u.id = ?1";

        $user = $this->entityManager->createQuery($dql)
            ->setParameter(1, $id)
            // ->useQueryCache(false)
            // ->useResultCache(false)
            ->getOneOrNullResult();
        return $user;
    }

    public function save(User $user): User {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    public function delete(User $user): User {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $user;
    }
}
