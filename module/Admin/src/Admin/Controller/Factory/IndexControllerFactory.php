<?php

namespace Admin\Controller\Factory;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,  
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
    Admin\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
     public function createService(ServiceLocatorInterface $serviceLocator)
    {
         $sm = $serviceLocator->getServiceLocator();

        try {
            $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        } catch (ServiceNotCreatedException $e) {
            $entityManager = null;
        }
        $controller = new IndexController($entityManager);
        return $controller;
    }
}