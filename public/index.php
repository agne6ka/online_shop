<?php

require_once '../app/utils/connect.php';
require_once '../vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(array('../src/views/'));
$twig = new Twig_Environment($loader);

//echo $twig->render('index.twig', array('the' => 'variables', 'go' => 'here'));
echo $twig->render('register.twig', array('the' => 'variables', 'go' => 'here'));