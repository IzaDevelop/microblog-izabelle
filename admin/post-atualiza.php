<?php
require "../inc/cabecalho-admin.php";
require "../inc/funcoes-posts.php";

$idPost = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$post = lerUmPost($conexao, $idPost, $_SESSION['id'], $_SESSION['tipo']);

if (isset($_POST['atualizar'])) {
  $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
  $texto = filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_SPECIAL_CHARS);
  $resumo = filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_SPECIAL_CHARS);
  // logicá de atualização da foto

  // se o campo imagem estiver vazio, singnifica que o usuário não quer trocar de imagem, ou seja o sistema irá manter a imagem existente
  if(empty($_FILES['imagem']['name'])){
    $imagem = $_POST['imagem-existente'];
  } else {
    // caso contrário, pegue a referência da nova imagem e faça o processo de upload para o servidor
    $imagem = $_FILES['imagem']['name'];
    upload($_FILES['imagem']);
  }
  // somente depois do processo de upload chamaremos a função de atualizarPost
  atualizarPost($conexao, $idPost, $_SESSION['id'], $_SESSION['tipo'], $titulo, $texto, $resumo, $imagem);
  header('location:posts.php');
}
?>

<div class="row">
  <article class="col-12 bg-white rounded shadow my-1 py-4">
    <h2 class="text-center">Atualizar Post</h2>

    <form enctype="multipart/form-data" class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">

      <div class="form-group">
        <label for="titulo">Título:</label>
        <input class="form-control" type="text" id="titulo" name="titulo" value="<?= $post['titulo'] ?>" required>
      </div>

      <div class="form-group">
        <label for="texto">Texto:</label>
        <textarea class="form-control" name="texto" id="texto" cols="50" rows="10" required><?= $post['texto'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="resumo">Resumo (máximo de 300 caracteres):</label>
        <span id="maximo" class="badge badge-success">0</span>
        <textarea class="form-control" name="resumo" id="resumo" cols="50" rows="3" required maxlength="300"><?= $post['resumo'] ?></textarea>
      </div>

      <div class="form-group">
        <label for="imagem-existente">Imagem do post:</label>
        <!-- campo somente leitura, meramente informativo -->
        <input class="form-control" type="text" id="imagem-existente" name="imagem-existente" readonly value="<?= $post['imagem'] ?>">
      </div>

      <div class="form-group">
        <label for="imagem" class="form-label">Caso queira mudar, selecione outra imagem:</label>
        <input class="form-control" type="file" id="imagem" name="imagem" accept="image/png, image/jpeg, image/gif, image/svg+xml">
      </div>

      <button class="btn btn-primary" name="atualizar">Atualizar post</button>
    </form>

  </article>
</div>

<?php
require "../inc/rodape-admin.php";
?>