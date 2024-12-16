<?php
// Adicionando a importação das configurações antes do codigo;
require_once("configA.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $email = ($_POST["email"]);
    $cpf = $_POST["cpf"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    
    // ERROR CORREÇÃO
    // Adicionada verificação, caso não de erro ele redireciona para a pagina inicial;
    try {
      $consulta = $mysqli->prepare("INSERT INTO aluno (nome, email, cpf, senha) VALUES (?, ?, ?, ?)");
      $consulta->bind_param("ssss",$_POST['nome'], $_POST['email'], $_POST['cpf'], $senha );
      $consulta->execute();
      $consulta->close();
      header('Location: /');
    } catch (\Throwable $th) {
      throw $th;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf8mb4" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #e9f0f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    
    .fundo {
      background-color: #f2f2f2;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }

    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
      font-size: 24px;
      font-weight: 600;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 8px;
      font-size: 14px;
      color: #555;
    }

    input,
    select {
      margin-bottom: 0px;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
      transition: border-color 0.3s ease;
    }

    button {
      padding: 12px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #45a049;
    }

    button:active {
      background-color: #388e3c;
    }

    .aviso {
      font-size: 12px;
      color: #777;
      margin-top: 5px;
      text-align: left;
      display: block;
    }
    
  </style>
</head>

<body>

  <div class="fundo">
    <div class="container">
    <h1>Cadastro</h1>
    <form action="telaCadastro.php" method="POST">
        <label for="nome">Insira seu nome:</label>
        <input type="text" id="nome" name="nome">
        <span class="aviso">Não obrigatório</span><br>

        <label for="email">Insira seu Email:</label>
        <input type="email" id="email" name="email" required></br>

        <label for="cpf">Insira seu cpf:</label>
        <input type="text" id="cpf" name="cpf" required>
        <span class="aviso">Sem "-" e "." (Ex:12345678901)</span><br>

        <label for="senha">Crie uma senha:</label>
        <input type="password" id="senha" name="senha" required><br>
       
        <button type="submit">Cadastrar</button>
    </form>

    <p class="aviso">Já tem uma conta? <a href="telaEntrar.php">Faça login aqui</a>.</p>

</div>
  </div>
</body>

</html>