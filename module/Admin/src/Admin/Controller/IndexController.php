<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Controller\BaseAdminController;

class IndexController extends BaseAdminController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
