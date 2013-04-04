<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->setVar('post', Posts::findFirst());
    }

}

