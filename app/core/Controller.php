<?php
namespace App\core;

use Slim\Container;
use Slim\Views\Twig;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
/**
* 
*/
class Controller
{
	private  $container;
	public  $view;

	public function __construct(Container $container, Twig $view)
	{
		$this->container = $container;
		$this->view = $view;
	}

	public function __get($property)
    {
    	if($this->container->{$property}){
    		return $this->container->{$property};
    	}
    }
    public function getBaseUrl($request){
    	return $basePath = rtrim(str_ireplace('index.php', '', $request->getUri()->getBasePath()), '/');
   }
}