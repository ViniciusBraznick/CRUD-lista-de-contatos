<?php
namespace App\Models;

use MF\Model\Model;

class Usuario extends Model{
  private $id;
  private $nome;
  private $email;
  private $senha;


  public function __get($atributo){
    return $this->$atributo;
  }

  public function __set($atributo, $valor){
    $this->$atributo = $valor;
  }

  public function criarConta(){
    $query = "insert into usuarios (nome, email, senha) values (:nome, :email, :senha)";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':nome', $this->__get('nome'));
    $stmt->bindValue(':email', $this->__get('email'));
    $stmt->bindValue(':senha', $this->__get('senha'));
    $stmt->execute();
    
    header('Location: /?register=success');
    return $this;

  }

  public function validaLogin(){
    $query = "select id, nome, email from usuarios where email = :email and senha = :senha";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':email', $this->__get('email'));
    $stmt->bindValue(':senha', $this->__get('senha'));
    $stmt->execute();

    $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
   
    if ($usuario['id'] != '' && $usuario['nome'] != '') {
      $this->__set('id', $usuario['id']);
      $this->__set('nome', $usuario['nome']);
    }

    return $this;
  }

  public function validaEmailDoCadastro(){
    $query = "select nome, email from usuarios where email = :email";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':email', $this->__get('email'));
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getAll(){
    $query = "select id, nome, tipo from contatos where id_usuario = :id_usuario order by nome";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_usuario',$this->__get('id') );
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
}
?>