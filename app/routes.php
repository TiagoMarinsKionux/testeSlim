<?php

$app->post('/usuarios', "App\controller\UsuarioControl:inserir");
$app->get('/usuarios', "App\controller\UsuarioControl:listarTodos");
$app->put('/usuarios', "App\controller\UsuarioControl:editar");
$app->delete('/usuarios', "App\controller\UsuarioControl:deletar");