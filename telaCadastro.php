<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = ($_POST["email"]);
    $cpf = $_POST["cpf"];
    $senha = $_POST["senha"];

    require_once("configA.php");
    $consulta = $mysqli->prepare("INSERT INTO aluno (nome, email, cpf, senha) VALUES (?, ?, ?, ?)");
    $consulta->bind_param("ssss",$_POST['nome'], $_POST['email'], $_POST['cpf'], $_POST['senha'] );
    $consulta->execute();
    $consulta->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastro</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .aviso{
            font-size: 12px;
            color:gray;
        }

    .container {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 5px;
      color: #555;
    }

    input,
    select {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      padding: 10px;
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>

  <div class="container">
    <h1>Cadastro</h1>

    <div class="container">
    <form action="telaCadastro.php" method="POST">
        <label for="nome">Insira seu nome:</label>
        <input type="text" id="nome" name="nome">
        <small class="aviso">Não obrigatório</small><br>

        <label for="email">Insira seu Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="cpf">Insira seu cpf:</label>
        <input type="text" id="cpf" name="cpf" required>
        <small class="aviso">Sem "-" e "." (Ex:12345678901)</small><br>

        <label for="senha">Crie uma senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        

        <button type="submit">Cadastrar</button>
    </form>
</div>
  </div>
</body>

</html>