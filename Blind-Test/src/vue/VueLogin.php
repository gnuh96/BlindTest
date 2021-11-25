<?php
/**
 * Created by PhpStorm.
 * User: legit
 * Date: 30/03/2019
 * Time: 17:07
 */

namespace blindtest\vue;

use blindtest\modele\Classement;
use blindtest\modele\Joueur;

class VueLogin
{

    public function render($num){
        $app = \Slim\Slim::getInstance();
        $urlAccueil = $app->urlFor('/');
        $urlRegle = $app->urlFor('regle');
        $urlLogin = $app->urlFor('login');
        $urlReg = $app->urlFor('register');

        switch ($num) {
            case 1 :
                {
                    $content = $this->login();
                    break;
                }
            case 2 :
                {
                    $content = $this->register();
                    break;
                }
            case 3 :
                {
                    $content = $this->afficherLogin();
                    break;
                }
            case 4 :
                {
                    $content = $this->forgotLogin();
                    break;
                }
        }

        $bouton1="Règles";
        $bouton2="Connexion";
        $bouton3="Accueil";
        $bouton4="Inscription";

        //Détermine l'affichage des boutons de login
        if(isset($_COOKIE['pseudo'])){
            if((strpos($_COOKIE['pseudo'], 'Joueur') !== true)){
                $bouton6 = "Votre compte";
                $contentButton = <<<END
                <a class="navbar-brand animated jackInTheBox delay-1s" href=""> Le Grand Blind Test </a>
                <span class="navbar-text white-text" style="margin-left: auto;">
                  <a href="$urlLogin" class="btn btn-outline-light">$bouton6</a>
                </span>

END;

            }
        }else{
            $contentButton = <<<END
            <a class="navbar-brand animated jackInTheBox delay-1s" href="" style="margin-left: 5%;"> Le Grand Blind Test </a>
            <span class="navbar-text white-text" style="margin-left: auto;">
              <a href="$urlReg" class="btn btn-outline-light">$bouton4</a>
              <a href="$urlLogin" class="btn btn-outline-light">$bouton2</a>
            </span>
END;

        }



        $html= <<<END
<!DOCTYPE html>
<html>
<head>        
    <title>LeGrandBlindTest</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
</head>
        
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active" style="margin-left: auto;">
            <a href="$urlAccueil" class="btn btn-outline-light">$bouton3</a>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="$urlRegle" class="btn btn-outline-light">$bouton1</a>
          </li>
        </ul>
        $contentButton
      </div>
    </nav>
        
        
    <div class="container-fluid">
    
        $content
        
    </div>   
</body>
<div id="footer2">
<footer class="bg-dark">
    <p><strong> Copyright © 2019 Tom Aubert_Antonio Vallera_Robin Prugne_Tuan Hung Ngyuen - IUT Nancy-Charlemagne - DUT Informatique  </strong></p>
</footer>
</div>
</html>
END;

        echo $html;

    }



    private function login(){

        $app = \Slim\Slim::getInstance() ;
        $url = $app->request->getRootUri();

        $html= <<<END
        <link rel="stylesheet" href="./css/Style.css">
        <script src='./script/scriptLogin.js'> </script>
        <div class="container">
        <div class="alert alert-danger" id="alertInscDangerLog" role="alert" style="width: 80%; text-align: center; margin: auto;">
                  <center><h4> Erreur !</h4> </center>
                  <p style="display: inline-block; margin-right: 5px;"> Il semblerait que vos identifiants ne soient pas reconnus ! </p>
                </div>
	    <div class="d-flex justify-content-center h-100">
		<div class="card" id="cardLogin">
			<div class="card-header">
				<h3>Connexion</h3>
			</div>
			<div class="card-body">
				<form method="POST" action="$url/login/check">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input name="pseudo" type="text" class="form-control" placeholder="username">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input name="password" type="password" class="form-control" placeholder="password">
					</div>
					<div class="row align-items-center remember">
						<input name="checkbox" type="checkbox"> Rester connecté
					</div>
					<div class="form-group">
						<input type="submit" value="Connexion" class="btn float-right login_btn">
					</div>
				</form>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center">
					<a href="$url/login/forgot" style="color:white"> <i> Mot de passe oublié ? </i></a>
				</div>
			</div>
		</div>
	</div>
</div>
END;

        return $html;

    }

    private function register(){
        $app = \Slim\Slim::getInstance() ;
        $url = $app->request->getRootUri();


        $html = <<<END
        <link rel="stylesheet" href="./../css/Style.css">
        <script src='./../script/scriptLogin.js'> </script>
        <div class="container">
                <div class="alert alert-success" id="alertInsc" role="alert" style="width: 80%; text-align: center; margin: auto;">
                  <center><h4> Merci !</h4> </center>
                  <p style="display: inline-block; margin-right: 5px;">Nous vous remercions pour votre inscription sur </p><p style="font-family: 'Gloria Hallelujah', cursive; display: inline-block;"> Le Grand Blind Test </p>
                  <p >Vous allez être redirigé sur la page de connexion <p class="saving"><span>.</span><span>.</span><span>.</span></p></p>
                </div>
                
                <div class="alert alert-danger" id="alertInscDanger" role="alert" style="width: 80%; text-align: center; margin: auto;">
                  <center><h4> Erreur !</h4> </center>
                  <p style="display: inline-block; margin-right: 5px;"> Il semblerait que votre mot de passe ne soit pas valide ! </p>
                  <p >Veuillez réessayer <p class="saving"><span>.</span><span>.</span><span>.</span></p></p>
                </div>
                
            <div class="d-flex justify-content-center h-100">
            <div class="card" id="cardLogin">
                <div class="card-header">
                    <h3>Inscription</h3>
                </div>
                <div class="card-body">
                    <form method="POST" id="formRegister" action="$url/login/register/check">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input name="pseudo" type="text" class="form-control" placeholder="username">
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input name="password" id="password" type="password" class="form-control" placeholder="password">
                        </div>
                        
                        <div class="form-group">
                            <input type="button" value="Inscription" class="btn float-right login_btn" id="btnInscription">
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>

END;
        return $html;

    }

    private function afficherLogin(){
        $app = \Slim\Slim::getInstance() ;
        $url = $app->request->getRootUri();

        if(isset($_COOKIE['pseudo'])){
            $pseudo = $_COOKIE['pseudo'];

            //Prend le meilleur score
            $joueur = Joueur::where('pseudonyme','=',$pseudo)->get();
            $classement = Classement::where('idJoueur','=',$joueur[0]['idJoueur'])->get();

            $bestScore = 0;
            foreach ($classement as $c){
                if($c['score'] > $bestScore){
                    $bestScore = $c['score'] . " points";
                }
            }

            //Etabli le classement du joueur
            $classementTotal = Classement::orderBy('score','DESC')->get();
            $itt = 1;
            $stop = false;
            $classementJoueur = null;
            foreach($classementTotal as $c){
                if($c['idJoueur'] == $joueur[0]['idJoueur'] && !$stop){
                    $classementJoueur = $itt;
                    $stop = true;
                }
                $itt++;
            }

            if($classementJoueur == 1){
                $classementJoueur = $classementJoueur . "er";
            }else{
                $classementJoueur = $classementJoueur . "ème";
            }

            //Si le joueur n'a pas encore joué
            if($classement->count() == 0){
                $bestScore = "N/A";
                $classementJoueur = "N/A";
            }

            if($_SERVER["REQUEST_URI"] == "/S3/s3c_s07_aubert_nguyen_prugne_vallera/blindtest/Blind-Test/login/check" || $_SERVER["REQUEST_URI"] == "/www/prugne2u/s3c_s07_aubert_nguyen_prugne_vallera/blindtest/Blind-Test/login/check"){
                $style = "<link rel='stylesheet' href='./../css/Style.css'>";
            }else{
                $style = "<link rel='stylesheet' href='./css/Style.css'>";
            }

            $html = <<<END
            $style
            <section class="mainJeu">
        <center> <h2 class="animated infinite pulse delay-1s bonjour"> <i> Bonjour $pseudo ! </i></h2> </center>
        <br>
        <div class="inforamtionsCompte">
            <div class="card text-white bg-dark mb-3" style="width: 95%;height:20%;">
              <div class="card-header"> <h5> Informations sur votre compte </h5> </div>
              <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text"> <li> Pseudonyme : <b> $pseudo</b></li></p>
                <p class="card-text"> <li> Meilleur score : <b> $bestScore </b></li></p>
                <p class="card-text"> <li> Position dans le classement : <b> $classementJoueur</b></li></p>
              </div>
              <a href="$url/login/disconnect" class="deco"> Se déconnecter </a>
              <a href="$url/login/delete" class="deco"> Supprimer mon compte </a>
            </div>
        </div>
        </section>
END;
            return $html;
        }else{
            return null;
        }
    }

    private function forgotLogin(){
        $html = <<<END
        <center> <h2 class="bonjour"> Cette fonctionnalité n'est pas encore disponible</h2> </center>
        <center> <img src="https://upload.wikimedia.org/wikipedia/commons/8/80/Comingsoon.png" alt="en construction" style="margin-top: -110px;"> </center>
END;

        return $html;

    }
}