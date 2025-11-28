<?php
    session_start();
    require_once("connection.php");

    if (isset($_SESSION['erro'])) {
        $mensagem = $_SESSION['erro'];
        unset($_SESSION['erro']);
    }

    if($_POST['senha'] != $_POST['senha_confirmada']){
        $_SESSION['erro'] = 'As duas senhas não são iguais!';
        header('Location: cadastro.php');
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        $nome = $_POST['nome'];
	    $email = $_POST['email'];
	    $senha = $_POST['senha'];
    
        if(strlen($nome) < 5){
            $_SESSION['erro'] = 'O nome deve ter pelo menos 5 caracteres!';
           header('Location: cadastro.php');
            exit();
        }
        if(strlen($senha) < 5){
            $_SESSION['erro'] = 'A senha deve ter pelo menos 5 caracteres!';
            header('Location: cadastro.php');
            exit();
        }
        try{
            $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
            $res = $pdo->prepare("INSERT INTO user (nome, email, senha) VALUES (:n, :e, :s)");
	        $res->bindValue(':n', $nome);
            $res->bindValue(':e', $email);
	        $res->bindValue(':s', $hash_senha);
	        $res->execute();
            $novoId = $pdo->lastInsertId();

            $_SESSION['usuario_id'] = $novoId;
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_email'] = $email;

            header('Location: sistema.php');
        } catch(PDOException $e) {
            if($e->getCode() == 23000) {
                $mensagem = 'Usuário já existe!';
            } else {
                $mensagem = 'Erro no cadastro.';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <main>
        <div class="cadastro-box">
            <div class="text-box">
                <h1>Criar conta</h1>
                <p> <?php echo $mensagem ?></p>
                <p>Preencha os campos para criar sua conta</p>
            </div>
            <form method="POST">
                <label>Nome</label>
                <div class="icone">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <input type="text" name="nome" id="nome" placeholder="Seu nome" required>
                </div>
                <label>Email</label>
                <div class="icone">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    <input type="email" name="email" id="email" placeholder="Seu@email.com" required>
                </div>
                <label>Senha</label>
                <div class="icone">
                    <i class="fa fa-key" aria-hidden="true"></i>
                    <input type="password" name="senha" id="password" placeholder="**********" required>
                    <i class="fa fa-eye-slash" aria-hidden="true" id="olho"></i>
                </div>
                <label>Confirmar senha</label>
                <div class="icone">
                    <i class="fa fa-key" aria-hidden="true"></i>
                    <input type="password" name="senha_confirmada" id="password_confirm" placeholder="**********" required>
                </div>
                <div class="rodape">
                    <button type="submit">Enviar</button>
                    <p>Já tem uma conta? <a href="login.php">Fazer login</a></p>
                </div>
            </form>
        </div>
    </main>

    <script src="js/cadastroScript.js"></script>
</body>
</html>