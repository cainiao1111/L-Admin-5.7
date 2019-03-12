<?php
namespace App\Routing;

use Illuminate\Routing\ResourceRegistrar as OriginalRegistrar;
class ResourceRegistrar extends OriginalRegistrar
{
    /**
     * Add the edit method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceEdit($name, $base, $controller, $options)
    {   
        $uri = $this->getResourceUri($name).'_'.static::$verbs['edit'].'_{'.$base.'}.html';

        $action = $this->getResourceAction($name, $controller, 'edit', $options);

        return $this->router->get($uri, $action);
    }
    



 
}