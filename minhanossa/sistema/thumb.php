<?php
// recebendo a url da imagem
$filename = $_GET['img'];
$aprox = $_GET['largura']; // porcentagem da redução, originalmente era:  $percent = 0.10; troquei pela porcentagem da redução 

// Cabeçalho que ira definir a saida da pagina
header('Content-type: image/jpeg');

// pegando as dimensoes reais da imagem, largura e altura
list($width, $height) = getimagesize($filename);

	$x= $width;
    $y= $height;
      
    // Aqui é feito um cálculo para aproximar o tamanho da imagem ao valor passado em $aprox.
    // Não importa se a foto for grande ou pequena, o thumb de todas elas será mais ou menos do
    // mesmo tamanho.
    if ($x >= $y)
    {
        if ($x > $aprox)
        {      
            $x1= (int)($x * ($aprox/$x));    
            $y1= (int)($y * ($aprox/$x));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else
        {
            $x1= $x;
            $y1= $y;
        }
    }
    else
    {
        if ($y > $aprox)
        {
            $x1= (int)($x * ($aprox/$y));
            $y1= (int)($y * ($aprox/$y));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else
        {
            $x1= $x;
            $y1= $y;
        }
    }
    $x= $x1;
    $y= $y1;

//setando a largura da miniatura
$new_width = $x;
//setando a altura da miniatura
$new_height = $y; // pela proporção deste caso, se quiser um valor fixo só fazer igual no exemplo acima

if($_GET['forcaAltura'] <> '') {
$new_height = $_GET['forcaAltura']; } //// opcional

// antes era $new_height = 161;

//gerando a a miniatura da imagem
$image_p = imagecreatetruecolor($new_width, $new_height);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

//o 3º argumento é a qualidade da imagem de 0 a 100
imagejpeg($image_p, null, 70);
imagedestroy($image_p);
?>