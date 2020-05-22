<?php
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('template');
$twig = new \Twig\Environment($loader, [
    'cache' => 'cache',
]);

$twig = new Twig_Environment($loader, array('auto_reload' => true));

$filter = new \Twig\TwigFilter('rot13', function ($string) {
    return $string[0];
});

$function = new \Twig\TwigFunction('function_name', function () {
    return rand();
});

$twig->addFunction($function);

$twig->addFilter($filter);
$template = $twig->load('template.html.twig');

echo $template->render();


