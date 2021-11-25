<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 18/03/2019
 * Time: 13:35
 */

namespace blindtest\vue;
use blindtest\modele\Partie;

class VuePartage
{
    private $tab;

    function __construct($array)
    {
        if(!isset($_SESSION['idPartage'])){
            session_start();
        }
        $this->tab = $array;
    }

    private function partage(){
        $app =\Slim\Slim::getInstance() ;
        $itemUrl = $app->urlFor('partage') ;
        $u =  $itemUrl ;

        $t = explode("partager",$u);
        $u=$t[0];

        $u.="partage-Jouer/";
        $id=$_SESSION['idPartie'];
        $u.=$id;

        Partie::where('token', $id)->update([
            'partage' => $u
        ]);

        $p = Partie::where("token",$id)->first();

        $URL = $_SERVER['HTTP_HOST'] . $u;
        $fullURL = "partage-Jouer/$id";

        $url = "<center> Voici votre token de partage : <br><br>";
        $url = $url . "<a class=\"shareLink\" href=\"../$fullURL\" target=\"_blank\"> <strong>" . $URL . "</strong> </a> </center>";

        return $url;
    }

    private function redirection(){
        $txt = "<p> <center> <strong>Votre partie a été trouvée, voulez-vous la rejouer ?</strong> </center> </p><br>";
        $id=$_SESSION['idPartage'];
        $txt = $txt . "<center><a href='./../rejouer/$id' class='btn btn-dark' id='oui'>Oui</a></center>";
        return $txt;
    }

    private function inexistant(){
        $txt = "<p> <center> <strong>La partie n'existe pas, veuillez retourner à l'accueil</strong> </center> </p><br>";
        return $txt;
    }

    public function render($num){
        switch ($num) {
            case 1 :
                {
                    $content = $this->partage();
                    break;
                }
            case 2 :
                {
                    $content = $this->redirection();
                    break;
                }
            case 3 :
                {
                    $content = $this->inexistant();
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
                  <a href="./../login" class="btn btn-outline-light">$bouton6</a>
                </span>

END;

            }
        }else{
            $contentButton = <<<END
            <a class="navbar-brand animated jackInTheBox delay-1s" href="" style="margin-left: 5%;"> Le Grand Blind Test </a>
            <span class="navbar-text white-text" style="margin-left: auto;">
              <a href="./../login/register" class="btn btn-outline-light">$bouton4</a>
              <a href="./../login" class="btn btn-outline-light">$bouton2</a>
            </span>
END;

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

        <section class="mainPartage">   
    
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