<?php
include("configA.php");

if(isset($_POST['email']) || isset($_POST['senha'])) {

    if(strlen($_POST['email']) == 0) {
      echo "Preencha seu e-mail";
    } else if(strlen($_POST['senha']) == 0) {
      echo "Preencha sua senha";
    } else {

      $email = $_POST['email'];
      $senha = $_POST['senha'];


      $sql_code = "SELECT * FROM aluno WHERE email = '$email'";
      $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

      $quantidade = $sql_query->num_rows;

      if($quantidade == 1) {

        $aluno = $sql_query->fetch_assoc();
        if (password_verify($senha, $aluno['senha'])) {
          if(!isset($_SESSION)) {
            session_start();
          }
      
        $_SESSION['email'] = $aluno['email'];
        $_SESSION['senha'] = $aluno['senha'];
        header("Location: index.html");
        } else {
          echo "<script>alert('Senha inválida');</script>";
        } 
    } else {
      echo "<script>alert('Usuário não encontrado');</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf8mb4" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .aviso {
      font-size: 12px;
      color: #777;
      margin-top: 5px;
      text-align: left;
      display: block;
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
    <h1>Login</h1>

    <div class="container">
    <form action="telaEntrar.php" method="POST">
        <label for="email">Insira seu Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Insira sua senha:</label>
        <input type="password" id="senha" name="senha" required><br>

        

        <button type="submit">Entrar</button>
    </form>

    <p class="aviso">Deseja retornar? <a href="index.html">Voltar para a tela principal</a>.</p>
</div>
  </div>
</body>

</html>