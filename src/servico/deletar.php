<?php
session_start();
require_once("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    try {
        $userId = $_SESSION['usuario_id'];
        $taskId = $_POST['id'];

        $stmt = $pdo->prepare("DELETE FROM task WHERE id_task = :id AND user_id = :uid");
        $stmt->execute([
            ':id' => $taskId,
            ':uid' => $userId
        ]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "ok", "mensagem" => "Tarefa excluída com sucesso"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Tarefa não encontrada ou não pertence ao usuário"]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["status" => "erro", "mensagem" => "Erro interno"]);
    }
}
?>
