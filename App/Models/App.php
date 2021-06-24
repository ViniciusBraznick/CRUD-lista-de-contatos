<?php

namespace App\Models;

use MF\Model\Model;

class App extends Model{
  private $id_contato;
  private $id_usuario;

  private $nome;
  private $email;
  private $descricao;
  private $telefone;
  private $celular;

  public function __get($atributo){
    return $this->$atributo;
  }

  public function __set($atributo, $valor){
    $this->$atributo = $valor;
  }

  // CREATE
  public function adicionaContato(){ 
    $query = '
    insert into contatos 
      (id_usuario, nome, email, tipo, telefone, celular) 
    values 
      (:id_usuario, :nome, :email, :tipo, :telefone, :celular )';

    $stmt = $this->db->prepare($query);

    $stmt->bindValue(':id_usuario',$this->__get('id_usuario') );
    $stmt->bindValue(':nome',$this->__get('nome') );
    $stmt->bindValue(':email',$this->__get('email') );
    $stmt->bindValue(':tipo',$this->__get('descricao') );
    $stmt->bindValue(':telefone',$this->__get('telefone') );
    $stmt->bindValue(':celular',$this->__get('celular') );
    $stmt->execute();

    return true;
  }

  // READ
  public function getDetails (){
    $query = "select id, nome, email, tipo, telefone, celular from contatos where id_usuario = :id_usuario and id = :id_contato";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_usuario',$this->__get('id_usuario') );
    $stmt->bindValue(':id_contato',$this->__get('id_contato') );
    $stmt->execute();

    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  // UPDATE
  public function editaContato(){
    $query = 'UPDATE contatos SET email = :email, telefone = :telefone, celular = :celular WHERE id = :id_contato AND id_usuario = :id_usuario';
    
    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':email', $this->__get('email'));
    $stmt->bindValue(':telefone', $this->__get('telefone'));
    $stmt->bindValue(':celular', $this->__get('celular'));
    $stmt->bindValue(':id_contato', $this->__get('id_contato'));
    $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));

    return $stmt->execute();


  }

  // DELETE
  public function deletaContato(){
    $query = "delete from contatos WHERE id = :id_contato";

    $stmt = $this->db->prepare($query);
    $stmt->bindValue(':id_contato', $this->__get('id_contato') );
    $stmt->execute();
    
    return true;

  }
}
?>