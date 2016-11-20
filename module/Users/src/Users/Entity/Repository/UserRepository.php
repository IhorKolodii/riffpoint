<?php

namespace Users\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function login(\Users\Entity\User $user, $authService)
    {
        $adapter = $authService->getAdapter();
        $adapter->setIdentity($user->getUsrName());
        $adapter->setCredential($user->getUsrPassword());
        $authResult = $authService->authenticate();
        $identity = null;
        
        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
        }
        
        return $authResult;
    }
}