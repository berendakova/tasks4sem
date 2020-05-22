<?php

use Twig\TwigFunction;

require_once 'vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    array('auto_reload' => true)
]);


$function = new \Twig\TwigFunction('picture', function () {
    $im = @imagecreate(100, 100)
    or die("Невозможно создать поток изображения");
    $background_color = imagecolorallocate($im, 255, 255, 255);
    $text_color = imagecolorallocate($im, 0, 0, 0);
    $string = rand();
    imagestring($im, 5, 0, 0,  $string, $text_color);
    ob_start();
    $img = imagepng($im);
    return base64_encode(ob_get_clean());

});


$twig->addFunction($function);

$template = $twig->load('p.html.twig');
file_put_contents("file.html",$template->render());
