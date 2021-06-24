<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['login'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'login'
		);

		$routes['criarConta'] = array(
			'route' => '/criarConta',
			'controller' => 'indexController',
			'action' => 'criarConta'
		);

		$routes['registrar'] = [
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrarConta'
		];

		$routes['logar'] = [
			'route' => '/logar',
			'controller' => 'indexController',
			'action' => 'logar'
		];

		$routes['home'] = [
			'route' => '/home',
			'controller' => 'AppController',
			'action' => 'home'
		];

		$routes['home/details'] = [
			'route' => '/home/details',
			'controller' => 'AppController',
			'action' => 'getInfo'
		];

		$routes['addContato'] = [
			'route' => '/adicionarContato',
			'controller' => 'AppController',
			'action' => 'addContato'
		];

		$routes['adicionaNovoContato'] = [
			'route' => '/adicionaNovoContato',
			'controller' => 'AppController',
			'action' => 'adicionaNovoContato'
		];

		$routes['deletaContato'] = [
			'route' => '/home/deletaContato',
			'controller' => 'AppController',
			'action' => 'deletaContato'
		];

		$routes['editarContato'] = [
			'route' => '/editarContato',
			'controller' => 'AppController',
			'action' => 'editaContato'
		];

		$routes['sair'] = [
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		];

		$this->setRoutes($routes);
	}

}

?>