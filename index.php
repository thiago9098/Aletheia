<?php
include("configA.php");

// ERROR CORREÇÃO
// Adicionando pré carregamento para trazer a listagem dos comentarios no banco;
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['email'])) {
   
  // consulta todos os comentarios da table em ordem decrescente
  $sql = "SELECT * FROM comentario ORDER BY id DESC";
  $query = $mysqli->query($sql) or die("Falha na execução do código SQL: " . $mysqli->error);

  $comentarios = $query->fetch_all(MYSQLI_ASSOC);
}else {
  $comentarios = [];
}

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Aletheia</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet" />
        <!-- Incluindo jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container px-5">
                <a class="navbar-brand" href="#page-top">Aletheia</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a id="link1" class="nav-link" href="telaCadastro.php">Cadastrar-se</a></li>
                        <li class="nav-item"><a id="link2" class="nav-link" href="telaEntrar.php">Entrar</a></li>
                        <li class="nav-item"><a id="link3" style="display: none;" class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="masthead text-center text-white">
            <div class="masthead-content">
                <div class="container px-5">
                    <h1 class="masthead-heading mb-0">Onde a verdade</h1>
                    <h2 class="masthead-subheading mb-0">Encontra a voz</h2>
                    <a class="btn btn-primary btn-xl rounded-pill mt-5" onclick="verificarSessao()">Fazer comentário</a> <!-- FAZER VERIFICAÇÃO SE O USUÁRIO JA EXISTE NO BD. SE NÃO EXISTIR ELE VAI PRA TELA DE SE CADASTRAR. SE EXISTIR ELE PODE COMENTAR-->
                </div>
            </div>
        </header>
        
        <section>
            <div class="container px-5">
                <section style="background-color: white;">
                    <div class="container my-5 py-5">
                      <div class="row d-flex justify-content-center">
                        <div id="listaComentario" class="col-md-12 col-lg-10">
                          <ul>
                            <!-- ERROR CORREÇÃO -->
                            <!-- LISTANDO NA TELA TODOS OS COMENTARIOS -->
                            <?php
                              foreach ($comentarios as $key => $value) {
                                # code...
                                $autor = $value["aluno_email"];
                                $texto = $value["texto"];
                                $data = $value["data"];
                                $titulo = $value["titulo"];

                                echo "
                                  <li>
                                    <h4>$autor -> $titulo:</h4>
                                    
                                    <p>
                                      $texto
                                      <small>$data</small>
                                    
                                    </p>
                                    </li>
                                    ";
                                  }
                                  ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </section>
            </div>
        </section>
        
        <!-- Footer-->
        <footer class="py-5 bg-black">
            <div class="container px-5"><p class="m-0 text-center text-white small">Copyright &copy; ALETHEIA 2024</p></div>
        </footer>
        <div class="modal" id="commentModal">
          <div class="modal-content">
            <h4>Adicionar Comentário</h4>
            <div class="comment-area">
              <textarea id="commentTitle" class="form-control" placeholder="Título do comentário" rows="1"></textarea><br>
              <textarea id="commentText" class="form-control" placeholder="Faça seu comentário aqui" rows="4"></textarea>
            </div>
            <div class="comment-btns">
              <button class="btn btn-danger" onclick="closeModal()">Cancelar</button>
              <button onclick="addComment()" class="btn btn-success">Enviar</button>
            </div>
          </div>
        </div>
        
        <!-- SCRIPT (JS)-->
        <script>
            function verificarSessao() {
            fetch('verificarSessao.php')
                .then(response => response.json())
                .then(data => {
                    if (data.logado) {
                        openModal();
                    } else {
                        alert("Você precisa entrar ou criar uma conta para comentar!");
                        document.getElementById("commentModal").style.display = "none";
                    }
                })}

                
                function verificarSessao2() {
                  fetch('verificarSessao.php')
                  .then(response => response.json())
                  .then(data => {
                      if (data.logado) {
                        document.getElementById("link1").style.display = "none";
                        document.getElementById("link2").style.display = "none";
                        document.getElementById("link3").style.display = "inline";
                      } else {
                        document.getElementById("link1").style.display = "inline";
                        document.getElementById("link2").style.display = "inline";
                        document.getElementById("link3").style.display = "none";
                      }
                  })
                }
                verificarSessao2();

             function openModal() {
              document.getElementById("commentModal").style.display = "flex";
            } 
        
            function closeModal() {
              document.getElementById("commentModal").style.display = "none";
              document.getElementById("commentTitle").value = "";
              document.getElementById("commentText").value = "";
            }

            function addComment() {
              console.log("Iniciando envio de comentário...");  

              var titulo = $('#commentTitle').val();
              var texto = $('#commentText').val();

              //Enviando o texto e o titulo digitado pelo usuario
              var commentData = {
                title: titulo,
                text: texto
              };

              console.log(titulo);  
              console.log(texto);
              
              if (titulo.trim() === "" || texto.trim() === "") {
                alert("Título e comentário não podem estar vazios.");
                return;
              }

              // Usando $.ajax para enviar os dados ao servidor
              $.ajax({
                url: "salvarcomentario.php",
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify(commentData),
                success: function(response) {
                  console.log("Resposta do servidor:", response);
                    try {
                     // Tente analisar como JSON
                      console.log(response);
                      if(response.status == "success"){location.reload()}
                    } catch (e) {
                      console.error("Erro ao analisar JSON:", e);
                    }
                  },
                  error: function(xhr, status, error) {
                    console.log()
                    console.log("Erro AJAX:", error);
                  }
              });
              
            }
          </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script> 
    </body>
</html>
