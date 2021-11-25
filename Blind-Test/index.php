<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 10:46
 */

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as DB;
use blindtest\vue\VueIndex as index;
use blindtest\vue\VueRegle as regle;
use blindtest\controle\ControlePartie as ctrlpartie;
use blindtest\controle\ControlePartage as ctrlPartage;
use blindtest\controle\ControleLogin;
use blindtest\vue\VueFin;

$db = new DB();
$conf=parse_ini_file('src/conf/conf.ini');
$db->addConnection( $conf );

$db->setAsGlobal();
$db->bootEloquent();

$app = new \Slim\Slim();

$app->get('/', function(){
    $i = new index();
    $i->render();
})->name('/');

$app->get('/regle', function(){
   $r = new regle();
   $r->render();
})->name('regle');

$app->get('/login', function(){
    $login = new ControleLogin();
    $login->login();
})->name('login');

$app->get('/login/register', function(){
    $login = new ControleLogin();
    $login->register();
})->name('register');

$app->post('/login/check', function(){
    $login = new ControleLogin();
    $login->checkLogin();
});

$app->get('/login/disconnect', function(){
    $login = new ControleLogin();
    $login->disconnect();
});

$app->get('/login/delete', function(){
    $login = new ControleLogin();
    $login->delete();
})->name('delete');

$app->get('/login/forgot', function(){
    $login = new ControleLogin();
    $login->forgot();
});

$app->post('/login/register/check', function(){
    $login = new ControleLogin();
    $login->checkRegister();
});

$app->get('/jouer/:id', function($id){
    $ctrl = new ctrlpartie();
    $ctrl->lancerPartie($id);
})->name('jouer');

$app->post('/jouer/:id', function($id){
    $ctrl = new ctrlpartie();
    $ctrl->lancerPartie($id);
});

$app->get('/partager/:id', function ($id){
    $ctrl = new ctrlPartage();
    $ctrl->partagerPartie($id);
})->name('partage');

$app->get('/partage-Jouer/:id', function($id){
    $_SESSION['idPartage']=$id;
    $ctrl = new ctrlPartage();
    $ctrl->send($id);
});

$app->get('/rejouer/:id', function($id){
    $ctrl = new ctrlpartie();
    $ctrl->rejouerPartie($id);
})->name('rejouer');

$app->get('/finish/', function(){
    $vue = new VueFin();
    $vue->finJeu();
})->name('finish');

$app->run();
