<?php
/**
 * Created by PhpStorm.
 * User: legit
 * Date: 30/03/2019
 * Time: 17:23
 */

namespace blindtest\controle;

use blindtest\modele\Classement;
use blindtest\vue\VueLogin;
use blindtest\modele\Joueur;

class ControleLogin
{
    public function login(){
        $v = new VueLogin();
        if(isset($_COOKIE['pseudo'])){
            if((strpos($_COOKIE['pseudo'], 'Joueur') === false)){
                $v->render(3);
            }
        }else{
            $v->render(1);
        }

    }

    public function register(){
        $v = new VueLogin();
        $v->render(2);
    }

    public function checkLogin(){
        $pseudo = filter_var($_POST['pseudo'],FILTER_SANITIZE_STRING);
        $mdp = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
        $app = \Slim\Slim::getInstance();
        $joueur = Joueur::where('pseudonyme','=',$pseudo)->get();

        if($joueur->count() == 1 && password_verify($mdp,$joueur[0]['motdepasse'])){
            unset($_COOKIE['pseudo']);
            setcookie('pseudo', null, -1, '/');
            if(isset($_POST['checkbox'])){
                //On veut rester connecté => le cookie reste 1 mois
                setcookie('pseudo',$pseudo,time() +60*60*24*30,'/');
                $_COOKIE['pseudo'] = $pseudo;
            }else{
                //On ne veut pas rester connecté
                setcookie('pseudo',$pseudo,0,'/');
                $_COOKIE['pseudo'] = $pseudo;
            }
            $vue = new VueLogin();
            $vue->render(3);
        }else{
            $app->redirect($app->urlFor('login'));
        }
    }

    public function checkRegister(){
        $pseudo = filter_var($_POST['pseudo'],FILTER_SANITIZE_STRING);
        $mdp = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

        $app = \Slim\Slim::getInstance();

        $checkJoueur = Joueur::where('pseudonyme','=',$pseudo)->get();
        if($checkJoueur->count() == 1) {
            $app = \Slim\Slim::getInstance();
            $app->response->redirect($app->urlFor('register'));
        }else{
                $joueur = new Joueur();
                $joueur->pseudonyme = $pseudo;

                $hash = password_hash($mdp,PASSWORD_DEFAULT,['cost' => 12]);
                $joueur->motdepasse = $hash;
                $joueur->save();

                $app->redirect($app->urlFor('login'));
        }
    }

    public function disconnect(){
        unset($_COOKIE['pseudo']);
        setcookie('pseudo', null, -1, '/');

        if(!isset($_SESSION['pseudo']))
            session_start();


        unset($_SESSION['pseudo']);
        $_SESSION['deco'] = "true";

        $app = \Slim\Slim::getInstance();
        $app->response->redirect($app->urlFor('login'));
    }

    public function forgot(){
        $vue = new VueLogin();
        $vue->render(4);
    }

    public function delete(){
        if(isset($_COOKIE['pseudo'])){
            $pseudo = $_COOKIE['pseudo'];
        }else if(isset($_SESSION['pseudo'])){
            $pseudo = $_SESSION['pseudo'];
        }else{
            echo "Erreur, impossible de supprimer votre compte !";
            exit;
        }
        $joueur = Joueur::where('pseudonyme','=',$pseudo)->first();

        Joueur::where('pseudonyme','=',$pseudo)->delete();
        Classement::where('idJoueur','=',$joueur['idJoueur'])->delete();

        $this->disconnect();

        $app = \Slim\Slim::getInstance();
        $app->response->redirect($app->urlFor('register'));
    }
}