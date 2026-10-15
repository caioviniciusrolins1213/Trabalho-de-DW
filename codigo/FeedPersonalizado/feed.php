<?php 
session_start();


$idusuario =  $_SESSION['idusuario'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css.css">
</head>

<body>

    <div class="l1"><h1>Para Você</h1></div>

    <div class="postagens">
        <?php
        require_once "../conexao.php";

        // $sql = "SELECT postagem.idpostagem, postagem.texto, postagem.data_hora, postagem.idusuario, usuario.username, usuario.nome, usuario.foto
        //     FROM postagem, usuario
        //     WHERE postagem.idusuario = usuario.idusuario;";

        $sql=  "SELECT DISTINCT postagem.*, usuario.nome,usuario.username, usuario.foto FROM postagem INNER JOIN usuario ON postagem.idusuario = usuario.idusuario WHERE postagem.idusuario = $idusuario OR postagem.idusuario IN ( SELECT idseguindo FROM seguir WHERE idseguidor = $idusuario ) ORDER BY postagem.data_hora DESC;";

        $postagens = mysqli_query($conexao, $sql);

        while ($postagem = mysqli_fetch_array($postagens)) {
            $idpostagem = $postagem['idpostagem'];
            $texto = $postagem['texto'];
            $data_hora = $postagem['data_hora'];
            $idusuario = $postagem['idusuario'];
            $nome_usuario = $postagem['nome'];
            $username = $postagem['username'];
            $foto_usuario = $postagem['foto'];
            $fotopadrao = "imagem/fotopadrao.png";
            if ($foto_usuario == NULL) {
            $foto_para_exibir = $fotopadrao;
            } else {
                $foto_para_exibir = "imagem/$foto_usuario";
            }

            echo "<div class='postagem'>";
            echo "<img src='$foto_para_exibir' class='foto_perfil'>"; 
            echo "$nome_usuario ($username)";
            echo "<p class='texto_postagem'>$texto</p>";
            echo "<p class='data_postagem'>$data_hora</p>";
            

            echo "<div>";
            $sql2 = "SELECT comentario.idcomentario, comentario.idusuario, comentario.texto, usuario.username, usuario.nome, usuario.foto
                FROM comentario, usuario
                WHERE idpostagem = $idpostagem
                AND comentario.idusuario = usuario.idusuario ORDER BY comentario.idcomentario;";
            $comentarios = mysqli_query($conexao, $sql2);
            $quantidade_comentario = mysqli_num_rows($comentarios);
            if ($quantidade_comentario == 0) {
                echo "Não tem comentarios";
            } else {
                while ($comentario = mysqli_fetch_array($comentarios)) {
                    $idcomentario = $comentario['idcomentario'];
                    $comentario_idusuario = $comentario['idusuario'];
                    $comentario_texto = $comentario['texto'];
                    $comentario_nome_usuario = $comentario['nome'];
                    $comentario_username_usuario = $comentario['username'];
                    $comentario_foto_usuario = $comentario['foto'];

                    echo "<br>";
                    echo "<img src='imagem/$comentario_foto_usuario' class='foto_perfil'>";
                    echo "$comentario_nome_usuario ($comentario_username_usuario)";
                    echo $comentario_texto;
                }
            }
        ?>
            <br>

        <?php
            echo "</div>";

            echo "</div>";
        }
        ?>
    </div>
</body>

</html>