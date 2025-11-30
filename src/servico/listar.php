<?php
session_start();
require_once("../connection.php");
require_once("../criptografia/crypto.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
    try {
        $id = $_SESSION['usuario_id'];
        $chave = "jnFE12ji1Fejif110fCZnnvjxAnif"; 
        $crypto = new Crypto($chave);

        $res = $pdo->prepare("SELECT id, titulo, data FROM task WHERE user_id = :i");
        $res->bindValue(':i', $id);
        $res->execute();
        
        $lista = $res->fetchAll(PDO::FETCH_ASSOC);
        $tarefas = [];
        
        foreach ($lista as $t) {
            $tarefas[] = [
            "id" => $t['id'], 
            "titulo" => $crypto->decrypt($t['titulo']), 
            "data"   => $t['data']
        ];  
        }
        
        header('Content-Type: application/json');
        echo json_encode($tarefas);
        exit;
        
    } catch(Exception $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        echo json_encode(['erro' => 'Erro interno']);
    }
}
?>
