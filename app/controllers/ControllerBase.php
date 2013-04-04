<?php
use Phalcon\Tag;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    protected function forward($uri)
    {
        $uriParts = explode('/', $uri);
        return $this->dispatcher->forward(
            array(
                'controller' => $uriParts[0],
                'action' => $uriParts[1]
            )
        );
    }
    
}