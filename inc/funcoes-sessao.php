<?php
/* Aqui programaremos futuramente
os recursos de login/logout e verificação
de permissão de acesso dos usuários */

// VERIFICANDO SE NÃO MEXISTE UMA SESSÃO EM FUNCIOAMENTO
if(!isset($_SESSION)){
    session_start();
}

function verificaAcesso(){
    // verifica se NÃO EXISTE uma variável de sessão relacionada ao id do usuário logado
    if(!isset($_SESSION['id'])){
        // então significa que ele não está logado, então apague qualquer resquício de sessão e force o usuário a para o login.php
        session_destroy();
        header('location:../login.php');
        die();
    }
}

// usado na página de login.php
function login(int $id, string $nome, string $email, string $tipo){
    // variáveis de sessão
    $_SESSION['id'] = $id;
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['tipo'] = $tipo;
}

// usado nas páginas administrativas quando clicamos em sair
function logout(){
    session_start();
    session_destroy();
    header('location:../login.php');
    die(); // ou exit;
}