<?php

namespace App\model;

class Usuario{
    
    private $db;
    private $id;
    private $nome;
    private $email;
    private $senha;

    function __construct($db){   
        $this->db = $db;
    }

    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getSenha(){
        return $this->senha;
    }
    public function setSenha($senha){
        $this->senha = $senha;
    }

    function inserir($usuario){
        $sql = $this->db->prepare("INSERT INTO usuario SET nome = :nome, email = :email, senha = :senha");
       
        $sql->bindValue(":nome", $usuario->getNome());
        $sql->bindValue(":email", $usuario->getEmail());
        $sql->bindValue(":senha", sha1( $usuario->getSenha()));

        $sql->execute();
    }
}