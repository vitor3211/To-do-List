<?php
    session_start();
    require_once("connection.php");
    if($_SERVER["REQUEST_METHOD"] == 'POST'){
        try{
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $res = $pdo->prepare('SELECT * FROM user WHERE email = :e');
            $res->bindValue(':e', $email);
            $res->execute();
            $usuario = $res->fetch();

            if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            header("Location: sistema.php");
            exit;
            } else{
                $mensagem = "Login invalido!";
            }
        } catch(Exception $e){
            error_log($e->getMessage());
            header('Location: login.php');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/login-register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

    <main>
        <div class="login-box">
            <div class="texto">
                <h1>Login</h1>
                <p><?php echo $mensagem;?></p>
                <p>Coloque seus dados para logar na sua conta</p>
            </div>
            <form method="POST">
                <label>Email</label><br>
                <div class="icone">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <input type="email" id="email" name="email" placeholder="Seu@email.com" required>
                </div>
                <label>Senha</label><br>
                <div class="icone">
                    <i class="fa fa-key" aria-hidden="true"></i>
                    <input type="password" id="senha" name="senha" placeholder="**********" required>
                    <i class="fa fa-eye-slash" aria-hidden="true" id="olho"></i>
                </div>
                <div class="rodape">
                    <button type="submit">Logar</button>
                    <a href="senha.html">Esqueceu sua senha?</a>
                </div>
            </form>
            <p id="ir_cadastro">Ainda não tem uma conta?<br><a href="cadastro.php">Cadastrar</a></p>
        </div>
    </main>

    <script src="js/loginScript.js"></script>
</body>
</html>