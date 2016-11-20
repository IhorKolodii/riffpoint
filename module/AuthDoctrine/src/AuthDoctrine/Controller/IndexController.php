<?php

namespace AuthDoctrine\Controller;

use Users\Controller\BaseController as BaseController;

use Users\Entity\User;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\Mail\Message;

class IndexController extends BaseController
{
    protected $authService;
    protected $apiService;
    protected $mailTransport;


    public function __construct(
            \Zend\Authentication\AuthenticationService $authService = null, 
            \Doctrine\ORM\EntityManager $entityManager = null, 
            \Admin\Service\IsExistValidator $apiService = null,
            $mailTransport = null
            )
    {
        $this->authService = $authService;
        $this->apiService = $apiService;
        $this->mailTransport = $mailTransport;
        parent::__construct($entityManager);
    }


    public function indexAction()
    {
        $em = $this->getEntityManager();
        $users = $em->getRepository('Users\Entity\User')->findAll();
        
        return array('users' => $users);
    }
    
    public function loginAction()
    {
        $em = $this->getEntityManager();
        $user = new User();
        $form = $this->getLoginForm($user);
        
        $messages = null;
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $user = $form->getData();
                $repo = $em->getRepository('Users\Entity\User');

                $authResult = $repo->login($user, $this->authService);
                
                if ($authResult->getCode() != \Zend\Authentication\Result::SUCCESS) {
                    foreach ($authResult->getMessages() as $message) {
                        $messages .= $message . "\n";
                    }
                } else {
                    return array();
                }
            }
        }
        
        return array(
            'form' => $form,
            'messages' => $messages
        );
    }
    
    public function logoutAction()
    {
        if ($this->authService->hasIdentity()) {
            $identity = $this->authService->getIdentity();
        }
        $this->authService->clearIdentity();
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
        return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
    }
    
    public function registerAction()
    {
        $em = $this->getEntityManager();
        $user = new User;
        
        $form = $this->getRegForm($user);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);
            
            if ($form->isValid()) {
                if ($this->apiService->exists($user->getUsrName(), array("usrName"))) {
                    $this->flashMessenger()->addErrorMessage("User with same name already exists - " . $user->getUsrName());
                    return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'register'));
                }
                $this->prepareData($user);
                $this->sendConfirmationEmail($user);
                $em->persist($user);
                $em->flush();
                return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'registration-success'));
            }
        }
        return array('form' => $form);
    }
    
    public function registrationSuccessAction()
    {
        
    }


    protected function getUserForm(User $user)
    {
        $builder = new AnnotationBuilder($this->getEntityManager());
        $form = $builder->createForm('\Users\Entity\User');
        $form->setHydrator(new DoctrineHydrator($this->getEntityManager(), '\User'));
        $form->bind($user);
        
        return $form;
    }
    
    protected function getLoginForm(User $user)
    {
        $form = $this->getUserForm($user);
        $form->setAttribute('action', '/public/auth-doctrine/index/login/');
        $form->setValidationGroup('usrName', 'usrPassword');
        
        return $form;
    }
    
    protected function getRegForm(User $user)
    {
        $form = $this->getUserForm($user);
        $form->setAttribute('action', '/public/auth-doctrine/index/register/');
        $form->get('submit')->setAttribute('value', "Register");
        $form->get('usrEmail')->setAttribute('type', "email");
        
        return $form;
    }
    
    protected function prepareData($user)
    {
        $user->setUsrPasswordSalt(md5(time().'setUsrPasswordSalt'));
        $user->setUsrPassword(md5('staticSalt' . $user->getUsrPassword() . $user->getUsrPasswordSalt()));
        return $user;
    }
    
    protected function sendConfirmationEmail($user)
    {
        $message = new Message();
        $message->setEncoding('UTF-8');
        $message->addTo($user->getUsrEmail())
                ->addFrom('s.dice.service@gmail.com')
                ->setSubject('Register on dating portal')
                ->setBody("Your registration on dating portal is successful. Please confirm your registration: http://localhost/users/");
        $this->mailTransport->send($message);
    }
}
