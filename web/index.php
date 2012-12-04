<?php

define('CYE_ROOT_PATH', __DIR__ . '/../');

$loader = require_once CYE_ROOT_PATH . 'vendor/autoload.php';
//$loader->add('Goutte\Story', __DIR__.'/src');

use Silex\Application;
use Symfony\Component\Finder\Finder;
use dflydev\markdown\MarkdownParser;

// Utils (some monkey coding)

function is_localhost () {
    return (in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1','::1',)));
}

// App

$app = new Application();
$app['debug'] = is_localhost();


// Twig

$twig_loader = new Twig_Loader_Filesystem(array(
    CYE_ROOT_PATH . 'view',
));
$twig = new Twig_Environment($twig_loader, array(
    'cache' => CYE_ROOT_PATH . 'cache',
    'debug' => $app['debug'],
));


// Route Aliases

$app->get('/', function(Application $app) use ($twig) {
    $page = $twig->render('question_form.html.twig', array());
    return $page;
});

$app->get('/answer.json', function(Application $app) use ($twig) {
    $question = !empty($_GET['question']) ? $_GET['question'] : null;
    if (empty($question)) $app->abort(404, "Missing the question.");

    $answer = !empty($_GET['key']) ? $_GET['key'] : null;
    if (empty($answer)) {
        $answer = "I do not understand, please reformulate your question."; // fixme : L18N
    } else {
        $answer = base64_decode($answer);
    }

    $json = array(
        '_get' => $_GET,
        'answer' => $answer,
    );

    return $app->json($json);
});



$app->run();
