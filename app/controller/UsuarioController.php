<?php

namespace App\controller;
use App\model\Usuario; 

class UsuarioControl extends Control{
        
        function inserir($request, $response){
            $usuario = $request->getParsedBody();

            $u = new Usuario($this->db);
            $u->setNome($usuario['nome']);
            $u->setEmail($usuario['email']);
            $u->setSenha($usuario['senha']);
    
            try{
    
                $u->inserir($u);
    
                $this->logger->addInfo('Cliente adicionado. IP: '.$_SERVER['REMOTE_ADDR']);
                $response->withHeader( 'Content-type', 'text/html' );
                return $response->withStatus(201)->write("Usuário inserido com sucesso!");
    
            }catch(\Exception $e){
    
                $this->logger->addError("Erro na inserção do usuário, ERRO: ".$e->getMessage());
                $response->withHeader('Content-type', 'text/html');
                return $response->withStatus(500)->write("Não foi possível inserir o usuário, ERRO: ".$e->getMessage());
    
            }
        }
    }
