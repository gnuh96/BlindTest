<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 10:55
 */

namespace blindtest\vue;

use blindtest\modele\Historique;
use blindtest\modele\Joueur;
use blindtest\modele\Musique;
use blindtest\modele\Classement;

class vueJeu
{
    private $tab;
    private $score;

    function __construct($array)
    {

        $this->tab = $array;
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_COOKIE['tabSongs'])){
            setcookie("tabSongs",implode("','",$this->tab));
            $_COOKIE['tabSongs'] = implode("','",$this->tab);
        }else{
            //var_dump($_COOKIE['tabSongs']);
        }
        $this->score = 0;
    }

    private function resetPartiel(){
        //Suppression de la partie
        setCookie("tabSongs",null);
        $_COOKIE['tabSongs'] = null;
        setCookie("idSong",0);
        $_COOKIE['idSong'] = 0;
        setCookie("score",0);
    }

    private function resetAll(){
        //Ajout dans le classement
        $classementPrev = Classement::where('token','=',$_SESSION['idPartie'])->get();
        $joueurPrev = Joueur::where('pseudonyme','=',$_COOKIE['pseudo'])->get();
        if(($classementPrev->count() == 1) && ($classementPrev[0]['score'] < $_COOKIE['score']) && $classementPrev[0]['idJoueur'] == $joueurPrev[0]['idJoueur']){
            Classement::where('token','=',$_SESSION['idPartie'])->update(['score' => $_COOKIE['score']]);
        }else{
            $classement = new Classement();
            $classement->score = $_COOKIE['score'];
            $classement->token = $_SESSION['idPartie'];

            $joueur = Joueur::where("pseudonyme","=",$_COOKIE['pseudo'])->get();

            $classement->idJoueur = $joueur[0]['idJoueur'];
            $classement->save();
        }

        //Ajout dans l'historique
        $tabSongs = explode("','",$_COOKIE['tabSongs']);
        foreach($tabSongs as $song){
            $titre=explode(" - ",$song);
            $p=Musique::where("titre",$titre[1])->first();
            //ajout dans la table d'historique des musiques jouées
            $h = new Historique();
            $h['idMusique']=$p['idMusique'];
            $h['token']=$_SESSION['idPartie'];
            $h->save();
        }

        //Sauvegarde dans la variable de session du tableau de musiques pour le partage
        if(!isset($_SESSION)){
            session_start();
        }

        //reset des cookies
        $this->resetPartiel();

        //Redirection vers la page de partage
        $app = \Slim\Slim::getInstance();
        $app->response->redirect($app->urlFor('finish'));
    }

    private function jouer(){
        if(isset($_SESSION['deco'])){
            if($_SESSION['deco'] === "true"){
                unset($_COOKIE['pseudo']);
                setcookie('pseudo', null, -1, '/');
                $_SESSION['deco'] = "false";
            }
        }

        if(!isset($_COOKIE['pseudo'])){
            //Création du cookie pour le pseudo du joueur
            $id="Joueur".rand(5,100);
            setcookie('pseudo',$id);
            $_COOKIE['pseudo'] = $id;
        }else{
            if(isset($_SESSION['pseudo'])) {
                //Retransfert de session a cookie
                setcookie('pseudo', $_SESSION['pseudo']);
                $_COOKIE['pseudo'] = $_SESSION['pseudo'];
            }
        }

        //Ajout dans la base du joueur
        $joueurPresent = Joueur::where('pseudonyme','=',$_COOKIE['pseudo'])->get();
        if($joueurPresent->count() == 0){
            $joueur = new Joueur();
            $joueur->pseudonyme = $_COOKIE['pseudo'];
            $joueur->save();
        }

        $nom = $_COOKIE['pseudo'];
        $id = $_SESSION['idPartie'];
        setCookie("idSong","0");

        //Initialisation et récuperation du score
        if(isset($_COOKIE['score'])){
            $this->score = $_COOKIE['score'];
        }else{
            setcookie("score",0);
        }

        //Initialisation et récupération du numéro de la musique
        if(isset($_COOKIE['idSong'])){
            $idSong = (int) $_COOKIE['idSong'];
            if($idSong == 9){
                //Fin de la partie
                $this->resetAll();
            }
            if($idSong >= (sizeof($this->tab)-1)){
                $idSong = 0;
            }else{
                $idSong++;
            }
            setcookie("idSong",$idSong);
        }else{
            setCookie("idSong","0");
        }

        $app =\Slim\Slim::getInstance() ;
        $itemUrl = $app->urlFor('jouer') ;
        $url =  $itemUrl;
        $url = str_replace(":id",$id,$url);

        $str=<<<END
<script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.1.1/howler.core.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="./../script/timer.js"></script>
<script type="text/javascript" src="./../script/musique.js"></script>
<script type="text/javascript" src="./../script/verifierReponse.js"></script>      
<h2>Joueur : $nom</h2>
        
<h3>Score : <span id="score"> $this->score </span> points </h3>
    
<h3>Chrono :  <span id="time">30</span> secondes</h3>
    
<form id="formSub" method="post" action="$url">
    <div class="col">
        <input type="text" class="form-control" id="reponse" placeholder="Votre reponse" name="reponse" required>
    </div>
    
    <center>
    <div class="alert alert-danger" role="alert">
         <center><strong>Mauvaise réponse !</strong> Retentez votre chance ! </center>
    </div>
    </center>
    
    <center>
    <div class="alert alert-success" role="alert">
         <center><strong>Bonne réponse !</strong> </center> 
    </div>
    </center>
        
    <div class="container-fluid">
        <nav class="grpBtn">
            <input class="btn btn-success" id="valider" type="button" value="Valider">
        </nav>    
    </div>     
    
</form>        
END;
        return $str;
    }

    private function jouerPartage(){
        $html="";
        /*
        //Test de la lecture dans la base
        //TODO supprimer et remplacer pour lancer une partie
        $html.="Test de lecture de l'historique <br>";
        $html.="l'id de la cle primaire est : " . $this->tab[0][0]['idhistorique'] . "<br>";
        $html.= "l'id de la 1ere musique est : " . $this->tab[0][0]['idMusique'] . "<br>";
        $html.= "le token de partie est : " . $this->tab[0][0]['Token'] . "<br>";
        $html.= "le tableau de musique est : " .$_SESSION['tabMusiques'];

        //setcookie('tabSongs',$_SESSION['tabMusiques'],0,'/');
        */
        $app = \Slim\Slim::getInstance();
        $url = $app->urlFor('jouer');

        $url = str_replace(":id",$_SESSION['idPartie'],$url);
        $app->response->redirect($url);

        return $html;
    }

    private function pageErreur()
    {
        $this->titre="Erreur";
        return "<center><p>Lien Erroné</p><center>";
    }

    public function render($num){
        switch ($num) {
            case -1 :
                {
                    $content = $this->pageErreur();
                    break;
                }
            case 1 :
                {
                    $content = $this->jouer();
                    break;
                }
            case 2 :
                {
                    $content = $this->jouerPartage();
                    break;
                }
        }

        $bouton1="Règles";
        $bouton2="Connexion";
        $bouton3="Accueil";
        $bouton4="Inscription";

        $contentButton = <<<END
            <a class="navbar-brand animated jackInTheBox delay-1s" href="" style="margin-left: 5%;"> Le Grand Blind Test </a>
            <span class="navbar-text white-text" style="margin-left: auto;">
              <a href="./../login/register" class="btn btn-outline-light">$bouton4</a>
              <a href="./../login" class="btn btn-outline-light">$bouton2</a>
            </span>
END;

        //Détermine l'affichage des boutons de login
        if(isset($_COOKIE['pseudo'])){
            if((strpos($_COOKIE['pseudo'], 'Joueur') === false)){
                $bouton6 = "Votre compte";
                $contentButton = <<<END
                <a class="navbar-brand animated jackInTheBox delay-1s" href=""> Le Grand Blind Test </a>
                <span class="navbar-text white-text" style="margin-left: auto;">
                  <a href="./../login" class="btn btn-outline-light">$bouton6</a>
                </span>

END;
            }
        }

        $html= <<<END
<!DOCTYPE html>
<html>
<head>        
    <title>LeGrandBlindTest</title>
    
<!--    <video autoplay loop>
        <source src="./../image/Animation.mp4" type="video/mp4"/>
    </video> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="./../css/Style.css">
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
</head>
        
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-top:-10px;">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active" style="margin-left: auto;">
            <a href="./../" class="btn btn-outline-light">$bouton3</a>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="./../regle" class="btn btn-outline-light">$bouton1</a>
          </li>
        </ul>
        
        $contentButton
      </div>
    </nav>
    
    <div class="container-fluid">
    
        <section class="mainJeu">   
    
        <div>
            $content
        </div>
    
        </section>

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
}