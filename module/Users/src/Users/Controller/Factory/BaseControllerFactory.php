<?php

namespace Users\Controller\Factory;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,  
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
    Users\Controller\BaseController;

class BaseControllerFactory implements FactoryInterface
{
     public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();

        try {
            $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        } catch (ServiceNotCreatedException $e) {
            $entityManager = null;
        }
        $controller = new BaseController($entityManager);
        return $controller;
    }
}