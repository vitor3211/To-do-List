<?php
session_start();
require_once("../connection.php");
require_once("../criptografia/crypto.php");

if($_SERVER["REQUEST_METHOD"] == 'POST'){
    try {
    $data = date('Y-m-d');
    $task = $_POST['task'];
    $id = $_SESSION['usuario_id'];
    $key = "jnFE12ji1Fejif110fCZnnvjxAnif";

    $crypto = new Crypto($key);
    $textoCriptografado = $crypto->encrypt($task);
    $stmt = $pdo->prepare("INSERT INTO task (titulo, user_id, data) VALUES (:t, :i, :d)");
    $stmt->execute([
        ':t' => $textoCriptografado,
        ':i' => $id,
        ':d' => $data
    ]);
    $novoId = $pdo->lastInsertId();
    echo json_encode([
        "id"     => $novoId,
        "titulo" => $crypto->encrypt($textoCriptografado),
        "data"   => $data
    ]);
    exit;
    
} catch(PDOException $e) {
    echo "Erro ao salvar tarefa!";
} catch(Exception $e) {
    echo "Erro na criptografia!";
}

}
?>
