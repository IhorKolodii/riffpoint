<?php

namespace Users\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class BaseController extends AbstractActionController
{
    protected $entityManager;
    
    public function __construct(\Doctrine\ORM\EntityManager $entityManager = null)
    {
        $this->setEntityManager($entityManager);
    }
    
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function getEntityManager()
    {
        return $this->entityManager;
    }
    
}
