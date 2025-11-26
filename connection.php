<?php

	try{
		$pdo = new PDO('mysql:host=localhost;dbname=web;charset=utf8','root','');
		var_dump($pdo);
		echo "pepetinha do xdog";
	}
	catch(Exception $e){
		echo $e->getMessage();
	}

	try{
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];

    $res = $pdo->prepare("INSERT INTO user (nome, email, senha) VALUES (:n, :e, :s)");
	$res->bindValue(':n', $nome);
    $res->bindValue(':e', $email);
	$res->bindValue(':s', $senha);
	$res->execute();
	} catch(Exception $e){
		echo $nome;
		echo $email;
		echo $senha;
		echo $e->getMessage();
	}
?>
