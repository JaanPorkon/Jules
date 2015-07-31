<?php

class IndexController extends \Jules\Mvc\Controller
{
    public function indexAction($id)
    {
        $p = Products::findOne('id=1');
        $this->view->setVar('name', $p->name);
    }
}