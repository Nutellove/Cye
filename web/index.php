<?php

define('CYE_ROOT_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR);

$loader = require_once CYE_ROOT_PATH . 'vendor/autoload.php';
//$loader->add('Goutte\Story', __DIR__.'/src');

use Silex\Application;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\Finder\Finder;


// Config //////////////////////////////////////////////////////////////////////

$spinners = array( // from web/css/spinners.css
    'spinner-loader'      , 'throbber-loader', 'refreshing-loader'    ,
    'heartbeat-loader'    , 'gauge-loader'   , 'three-quarters-loader',
    'wobblebar-loader'    , 'atebits-loader' , 'whirly-loader'        ,
    'flower-loader'       , 'dots-loader'    , 'circles-loader'       ,
    'plus-loader'         , 'ball-loader'    , 'hexdots-loader'       ,
    'inner-circles-loader', 'pong-loader'    , 'pulse-loader'         ,
    'square-loader'       , 'bread-loader'   , 'dots3-loader'         ,
    'squares-loader'      , // <= I made that one myself \o/
);


// Utils (some monkey coding) //////////////////////////////////////////////////

function is_localhost () {
    return (in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1','::1',)));
}

function get_data_dir ($lang='en') {
    return CYE_ROOT_PATH . 'data/' . $lang . '/';
}

function random_culture_line ($lang='en') {
    $f = file(get_data_dir($lang) . 'culture');
    return trim($f[array_rand($f)]);
}

function random_refuse_line ($lang='en') {
    $f = file(get_data_dir($lang) . 'refuse');
    return trim($f[array_rand($f)]);
}

function get_premade_answer ($keyword, $lang='en') {
    $answer = false;
    $files = Finder::create()->files()->name($keyword.".md")->in(get_data_dir($lang));
    if ($files->count() > 0) {
        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            $answer = file_get_contents($file->getRealpath());
            break; // only $files[0] is of interest to us
        }
    }
    return $answer;
}


// App /////////////////////////////////////////////////////////////////////////

$app = new Application();
$app['debug'] = is_localhost();


// Twig ////////////////////////////////////////////////////////////////////////

$twig_loader = new Twig_Loader_Filesystem(array(
    CYE_ROOT_PATH . 'view',
));
$twig = new Twig_Environment($twig_loader, array(
    'cache' => CYE_ROOT_PATH . 'cache',
    'debug' => $app['debug'],
));


// Markdown ////////////////////////////////////////////////////////////////////

$pd = new Parsedown();
$pd->setUrlsLinked(true);
$pd->setSafeMode(false);


// Route Aliases ///////////////////////////////////////////////////////////////

$app->get('/', function(Application $app) use ($twig, $spinners) {
    $page = $twig->render('question_form.html.twig', array(
        'culture' => random_culture_line(),
        'spinner' => $spinners[array_rand($spinners)],
    ));
    return $page;
});

$app->get('/answer.json', function(Application $app) use ($twig, $pd) {
    $meditation_duration = 4; // in seconds

    $question = !empty($_GET['question']) ? $_GET['question'] : null;
    if (empty($question)) $app->abort(404, "Missing the question.");

    $answer = !empty($_GET['key']) ? $_GET['key'] : null;
    if (empty($answer)) {
        $answer = $pd->line(random_refuse_line());
    } else {
        $answer = base64_decode($answer);
    }

    $premade = get_premade_answer($answer);
    if (false !== $premade) {
        $answer = $pd->text($premade);
        $meditation_duration += 8;
    }

    $json = array(
        '_get' => $_GET,
        'answer' => $answer,
    );

    sleep($meditation_duration); // sweet dreams ar made of this !

    return $app->json($json);
});


// Set error handling in dev env
if (getenv('APP_ENV') !== 'prod') {
    ini_set('display_errors', 1);
    error_reporting(-1);

    ErrorHandler::register();

    if ('cli' !== php_sapi_name()) {
        ExceptionHandler::register();
    }

    $app['debug'] = true;
}

$app->run();

