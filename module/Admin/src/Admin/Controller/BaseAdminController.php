<?php

namespace Admin\Controller;

use Users\Controller\BaseController;

class BaseAdminController extends BaseController
{
    public function __construct(\Doctrine\ORM\EntityManager $entityManager = null)
    {
        parent::__construct($entityManager);
    }
    
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        if (!$this->identity()) {
            return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
        }
        return parent::onDispatch($e);
    }
    
}
