<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css.css">
</head>

<body>

    <div class="l1"><h1>Lista de postagem</h1></div>

    <div class="postagens">
        <?php
        require_once "../conexao.php";

        $sql = "SELECT postagem.idpostagem, postagem.texto, postagem.data_hora, postagem.idusuario, usuario.username, usuario.nome, usuario.foto
            FROM postagem, usuario
            WHERE postagem.idusuario = usuario.idusuario;";

        $postagens = mysqli_query($conexao, $sql);

        while ($postagem = mysqli_fetch_array($postagens)) {
            $idpostagem = $postagem['idpostagem'];
            $texto = $postagem['texto'];
            $data_hora = $postagem['data_hora'];
            $idusuario = $postagem['idusuario'];
            $nome_usuario = $postagem['nome'];
            $username = $postagem['username'];
            $foto_usuario = $postagem['foto'];

            echo "<div class='postagem'>";
            echo "<img src='fotos_usuario/$foto_usuario'>";
            echo "$nome_usuario ($username)";
            echo "<br>";
            echo "<br>";
            echo $texto;
            echo "<br>";
            echo $data_hora;

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
                    echo "<img src='fotos_usuario/$comentario_foto_usuario'>";
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