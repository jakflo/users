<?php

namespace App;

use Nette;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
                $router[] = new Route('Logged', 'Logged:default');
                $router[] = new Route('Logged/display_list', 'Logged:display_list');
		$router[] = new Route('<presenter>/<action>', 'Homepage:default');
		return $router;
	}
}
