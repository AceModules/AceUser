<?php

namespace AceUser\Service;

use AceUser\Entity\User;
use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Crypt\Password\Bcrypt;

class UserService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager = null) // TODO make entityManager param required
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param array $userData
     * @return User
     */
    public function registerNewUser(array $userData)
    {
        $hydrator = new DoctrineHydrator($this->getEntityManager());

        $user = new User();
        $hydrator->hydrate($userData, $user);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // TODO email verification

        return $user;
    }

    /**
     * @return string
     */
    public function generatePassword()
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@!'), 0, 12);
    }

    /**
     * @param User $user
     */
    public function resetPassword(User $user)
    {
        $this->changePassword($user, $this->generatePassword());

        // TODO email reset instructions
    }

    /**
     * @param User $user
     * @param string $newPassword
     */
    public function changePassword(User $user, $newPassword)
    {
        $user->setPassword($newPassword);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }

    /**
     * @param $password
     * @return string
     */
    public function makeHashedPassword($password)
    {
        $bcrypt = new Bcrypt();
        $bcrypt->setCost(4); // TODO Increase cost on production server
        return $bcrypt->create($password);
    }

    /**
     * @param User $user
     * @param string $passwordGiven
     * @return bool
     */
    public function verifyHashedPassword(User $user, $passwordGiven)
    {
        // TODO return false for banned users

        $bcrypt = new Bcrypt();
        return $bcrypt->verify($passwordGiven, $user->getPassword());
    }
}