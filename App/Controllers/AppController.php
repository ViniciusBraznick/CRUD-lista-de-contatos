<?php

namespace App\Controllers;

//recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action{

  public function home() {
    $this->validaSessao();

    $this->motraTodosContatos();

    $this->render('home', 'layout2');
  }

  public function addContato(){
    $this->validaSessao();

    $this->render('addContato', 'layout2');
  }

  public function deletaContato(){
    $this->validaSessao();

    $app = Container::getModel("App");

    $app->__set('id_contato', $_GET['id']);
    
   if ( $app->deletaContato()) {
     \header('Location: /home');
   }   

  }

  public function motraTodosContatos(){
    $this->validaSessao();

    $usuario = Container::getModel("Usuario");
    $usuario->__set('id', $_SESSION['id']);

    $contatos =  $usuario->getAll();

    $this->view->contato = $contatos;
  }

  public function validaSessao(){
    \session_start();

    if (!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
      \header('Location: /?login=erro');
    } 
  }

  public function getInfo(){
    $this->validaSessao();

    $app = Container::getModel("App");

    $app->__set('id_usuario', $_SESSION['id']);
    $app->__set('id_contato', $_GET['id']);

    if (count($app->getDetails() > 0)) {
      $contato = $app->getDetails();

      $this->view->detalhes_contato = $contato;
      $this->home();
    }
  }

  public function adicionaNovoContato() {
    $this->validaSessao();

    $app = Container::getModel("App");

    foreach ( $_POST as $chave => $valor ) {
			$string_sem_espacos = \str_replace(' ', '', $valor);
			
			if ( empty ( $string_sem_espacos )) {
        $this->mostraMEnsagemErro("Preencha todos os campos para continuar");
			}
		}

    if ($this->validaEmail($_POST['email'])) {
      $this->mostraMEnsagemErro('E-mail inválido');
    } 

    $app->__set('id_usuario', $_SESSION['id']);
    $app->__set('nome', $_POST['nome']);
    $app->__set('email', $_POST['email']);
    $app->__set('descricao', $_POST['descricao']);
    $app->__set('telefone', $_POST['telefone']);
    $app->__set('celular', $_POST['celular']); 

    if ($app->adicionaContato()) {
      header('Location: /adicionarContato?register=success');
    }
  }

  public function editaContato(){
    $this->validaSessao();

    $app = Container::getModel("App");

    if (empty($_POST)) {
      header("Location: /home/details?id=$id_contato");
    } 

    $app->__set("id_contato",$_GET['id_contato']);
    $app->__set("id_usuario", $_SESSION['id']);
    $app->__set("email", $_POST['email']);
    $app->__set("telefone", $_POST['telefone']);
    $app->__set("celular", $_POST['celular']);

    $id_contato = $app->__get('id_contato');

    if ($this->validaEmail(\str_replace(' ', '', $_POST['email']))) {
      header("Location: /home/details?id=$id_contato&erro=email");
      die();
    }
    
    if ($app->editaContato()) {
      header("Location: /home/details?id=$id_contato");
    } else{
      header("Location: /home");
    }

  }

  public function mostraMEnsagemErro($mensagem_erro){
    $this->view->contato = [
			'nome' => $_POST['nome'],
			'email' => $_POST['email'],
			'descricao' => $_POST['descricao'],
			'telefone' => $_POST['telefone'],
			'celular' => $_POST['celular']
		];


    $this->view->erro =  ['MensagemErro' =>  $mensagem_erro, 'status' => true];
    $this->render('addContato', 'layout2');

    die();
  }


  public function validaEmail($email){
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
	}

  
}
?>