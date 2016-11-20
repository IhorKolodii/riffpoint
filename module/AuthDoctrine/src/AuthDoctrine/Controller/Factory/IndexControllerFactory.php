<?php

namespace AuthDoctrine\Controller\Factory;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,  
    Zend\ServiceManager\Exception\ServiceNotCreatedException,
    Users\Controller\BaseController as BaseController,
    AuthDoctrine\Controller\IndexController as IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();

        try {
            $entityManager = $sm->get('Doctrine\ORM\EntityManager');
            $authService = $sm->get('Zend\Authentication\AuthenticationService');
        } catch (ServiceNotCreatedException $e) {
            $entityManager = null;
        } 
        try {
            $authService = $sm->get('Zend\Authentication\AuthenticationService');
        } catch (ServiceNotCreatedException $e) {
            $authService = null;
        } 
        try {
            $apiService = $sm->get('\Admin\Service\IsExistValidator');
        } catch (ServiceNotCreatedException $e) {
            $apiService = null;
        } 
        try {
            $mailTransport = $sm->get('mail.transport');
        } catch (ServiceNotCreatedException $e) {
            $mailTransport = null;
        } 

        $controller = new IndexController($authService, $entityManager, $apiService, $mailTransport);
        return $controller;
    }
}