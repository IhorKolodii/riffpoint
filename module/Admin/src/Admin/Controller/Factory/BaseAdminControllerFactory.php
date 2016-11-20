<?php

namespace Admin\Controller\Factory;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,  
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
    Admin\Controller\BaseAdminController;

class BaseAdminControllerFactory implements FactoryInterface
{
     public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $sm = $serviceLocator->getServiceLocator();

        try {
            $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        } catch (ServiceNotCreatedException $e) {
            $entityManager = null;
        }
        $controller = new BaseAdminController($entityManager);
        return $controller;
    }
}