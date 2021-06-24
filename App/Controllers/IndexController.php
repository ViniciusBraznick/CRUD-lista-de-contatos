<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function login() {

		$this->render('index');
	}

	public function criarConta() {
		$this->render('criarConta');
	}

	public function registrarConta(){

		$usuario = Container::getModel('Usuario');

		foreach ( $_POST as $chave => $valor ) {
			$string_sem_espacos = \str_replace(' ', '', $valor);
			
			if ( empty ( $string_sem_espacos )) {
				$this->mostraMensagemDeErro('Preencha todos os campos para continuar.', 'criarConta');
			}
		}
		
		$this->validaEmail($_POST['email']);

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));

		count($usuario->validaEmailDoCadastro()) == 0 ? $usuario->criarConta() : $this->mostraMensagemDeErro('Este e-mail já está em uso.', 'criarConta');

	}

	public function logar(){
    $usuario = Container::getModel('Usuario');

		foreach ( $_POST as $chave => $valor ) {
			$string_sem_espacos = \str_replace(' ', '', $valor);
			
			if ( empty ( $string_sem_espacos )) {
				$this->mostraMensagemDeErro('Preencha todos os campos para continuar.', 'index');
			}
		}

    $usuario->__set('email', $_POST['email']);
    $usuario->__set('senha', md5($_POST['senha']));

    $usuario->validaLogin();

    if ($usuario->__get('id') != '' && $usuario->__get('nome') != '') {
      \session_start();

      $_SESSION['id'] = $usuario->__get('id');
      $_SESSION['nome'] = $usuario->__get('nome');

      header('Location: /home');
		}

		$this->mostraMensagemDeErro('E-mail ou senha inválidos', 'index');

  }

	public function validaEmail($email){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->mostraMensagemDeErro('E-mail inválido', 'criarConta');
		}
	}

	public function mostraMensagemDeErro($mensagem_erro, $path){
		$this->view->usuario = [
			'nome' => $_POST['nome'],
			'email' => $_POST['email'],
			'senha' => $_POST['senha']
		];

		$this->view->erro =  ['MensagemErro' =>  $mensagem_erro, 'status' => true];
		$this->render($path);
		die();
	}
}

?>