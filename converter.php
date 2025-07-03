<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formato = $_POST['formato'];
    $imagem = $_FILES['imagem'];

    if (!in_array($formato, ['jpeg', 'png', 'webp', 'bmp'])) {
        die('Formato inválido!');
    }

    if ($imagem['error'] !== 0) {
        die('Erro ao enviar a imagem.');
    }

    $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);
    $nome_temp = $imagem['tmp_name'];

    $img = imagecreatefromstring(file_get_contents($nome_temp));
    if (!$img) {
        die('Erro ao processar a imagem.');
    }

    $nome_final = 'convertidos/imagem_' . time() . '.' . $formato;

    switch ($formato) {
        case 'jpeg':
            imagejpeg($img, $nome_final, 90);
            break;
        case 'png':
            imagepng($img, $nome_final);
            break;
        case 'webp':
            imagewebp($img, $nome_final);
            break;
        case 'bmp':
            imagebmp($img, $nome_final);
            break;
    }

    imagedestroy($img);

    echo "<h2>Imagem convertida com sucesso!</h2>";
    echo "<a href='$nome_final' download>Clique aqui para baixar</a>";
} else {
    echo "Acesso inválido.";
}
