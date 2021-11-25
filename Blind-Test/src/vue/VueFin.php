<?php
/**
 * Created by PhpStorm.
 * User: legit
 * Date: 27/03/2019
 * Time: 13:10
 */

namespace blindtest\vue;

use blindtest\modele\Partie;

class VueFin
{

    public function finJeu(){

        $bouton1="Règles";
        $bouton2="Connexion";
        $bouton3="Accueil";
        $bouton4="Inscription";

        $boutonFin="Partager";

        if(!isset($_SESSION['idPartie'])){
            session_start();
        }

        $id = $_SESSION['idPartie'];
        //verifie si la partie est deja enregistrer dans la base sinon l'enregistre
        $partie = Partie::where("token","=",$id)->first();
        if($partie==null){
            $p=new Partie();
            $p['token']=$id;
            $p['nbJoueurs']=1;
            $p->save();
        }else{
            $i = (int) $partie['nbJoueurs'];
            Partie::where("token",$id)->update(['nbJoueurs' => $i+1]);
        }

        //Détermine l'affichage des boutons de login
        if(isset($_COOKIE['pseudo'])){
            if((strpos($_COOKIE['pseudo'], 'Joueur') !== true)){
                $bouton6 = "Votre compte";
                $contentButton = <<<END
                <a class="navbar-brand animated jackInTheBox delay-1s" href="" > Le Grand Blind Test </a>
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
            <h2> <center> Fin de la partie ! </center> </h2>
            
            <div class="container-fluid">
                <nav class="grpBtn">
                    <a href="./../partager/$id" class="btn btn-dark" id="partage" type="submit">$boutonFin</a>
                </nav>    
            </div> 
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