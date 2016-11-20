<?php

namespace AuthDoctrine;

return array(
    'router' => array(
        'routes' => array(
            'auth-doctrine' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth-doctrine/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AuthDoctrine\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[:controller/[:action/[:id/]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'AuthDoctrine\Controller\Index'  => 'AuthDoctrine\Controller\Factory\IndexControllerFactory',
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Users\Entity\User',
                'identity_property' => 'usrName',
                'credential_property' => 'usrPassword',
                'credential_callable' => function(\Users\Entity\User $user, $password) {
                    if ($user->getUsrPassword() == md5('staticSalt' . $password . $user->getUsrPasswordSalt())) {
                    //if ($user->getUsrPassword() == $password) {
                        return true;
                    } else {
                        return false;
                    }
                },
            )
        )
    ),
    
);
