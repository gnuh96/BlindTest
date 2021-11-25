<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 28/01/2019
 * Time: 21:37
 */

namespace blindtest\vue;

session_start();

class VueRegle
{

    public function render()
    {
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
                  <a href="./login" class="btn btn-outline-light">$bouton6</a>
                </span>

END;

            }
        }else{
            $contentButton = <<<END
            <a class="navbar-brand animated jackInTheBox delay-1s" href="" style="margin-left: 5%;"> Le Grand Blind Test </a>
            <span class="navbar-text white-text" style="margin-left: auto;">
              <a href="./login/register" class="btn btn-outline-light">$bouton4</a>
              <a href="./login" class="btn btn-outline-light">$bouton2</a>
            </span>
END;

        }

        $html=<<<END
<!DOCTYPE html>
<head>

    <title>LeGrandBlindTest</title>
<!--    <video autoplay loop>
        <source src="./image/Animation.mp4" type="video/mp4"/>
    </video> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
    <link rel="stylesheet" href="./css/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    </head>

    <body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="margin-top:-10px;">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active" style="margin-left: auto;">
            <a href="./" class="btn btn-outline-light">$bouton3</a>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="./regle" class="btn btn-outline-light">$bouton1</a>
          </li>
        </ul>
        
        $contentButton

      </div>
    </nav>
    
    <div class="container-fluid">
    </div>

    <div class="regle">
        <div class="card text-center text-white bg-primary mb-3" style="width: 99%; margin-top: 50px; height: 50%;">
          <div class="card-header"> <h2> <i>Qu'est-ce que </i></h2> <h2 style="font-family: 'Gloria Hallelujah', cursive;"> " Le Grand Blind Test " </h2></div>
          <div class="card-body">
            <p class="card-text"> Le Grand Blind Test est un quiz musical asynchrone (Joueur seul / La partie n’est pas jouée au même instant chez les participants). <br>
            Le but du jeu étant d’être le joueur ayant accumulé le plus de points au cours de la partie. <br>
            Chaque partie est divisée en 10 extraits. Un chronomètre de 30 secondes est effectif pour chaque extrait.</p>
          </div>
        </div>
        
        <hr style="width: 80%; color: white; height: 1px; background-color:white;"/>
        
        <div class="card text-center text-white bg-primary mb-3" style="width: 99%; margin-top: 30px; height: 50%;">
          <div class="card-header"> <h2> <i>Comment jouer</i> </h2></div>
          <div class="card-body">
            <p class="card-text">C’est très simple ! Il suffit de choisir sa ou ses catégories (si vous le souhaitez) et de lancer une partie.
            <br>
            <strong>ATTENTION : </strong> Pour pouvoir accéder au classement, une inscription/connexion est nécessaire.</p>
          </div>
        </div>
        
        <hr style="width: 80%; color: white; height: 1px; background-color:white;"/>
        
        <div class="card text-center text-white bg-primary mb-3" style="width: 99%; margin-top: 30px; height: 50%;">
          <div class="card-header"> <h2> <i> Comment fonctionne l'interface </i></h2></div>
          <div class="card-body">
            <p class="card-text">
            <strong><u><font color="#8b0000">Champ de saisie :</font></u></strong> Entrez la réponse dans ce champ, puis validez. Inscrire le nom de l’auteur, le titre de la musique ou les deux de manière simultanée.
            <br>
            <strong><u><font color="#8b0000">Progression :</font></u></strong> Indique le nombre <!-- de musiques déjà réalisée, ainsi que les -->de points accumulés. 
            <br>
          </div>
        </div>
        
        <hr style="width: 80%; color: white; height: 1px; background-color:white;"/>
        
        <div class="card text-center text-white bg-primary mb-3" style="width: 99%; margin-top: 30px; height: 50%;">
          <div class="card-header"> <h2> <i> Comment sont comptés les points </i></h2></div>
          <div class="card-body">
            <p class="card-text">
            <strong><u><font color="#8b0000">1 Point :</font></u></strong> Donnez l'auteur <strong><font color="#32cd32">OU</font></strong> le titre de la musique.
            <br>
            <strong><u><font color="#8b0000">3 Points :</font></u></strong> Donnez l’auteur <strong><font color="#32cd32">ET</font></strong> le titre de la musique.
            <br>
          </div>
        </div>
        
        <hr style="width: 80%; color: white; height: 1px; background-color:white;"/>
        
        <div class="card text-center text-white bg-primary mb-3" style="width: 99%; margin-top: 30px; height: 50%;">
          <div class="card-header"> <h2> <i>Comment partager sa partie pour défier ses amis</i></h2></div>
          <div class="card-body">
            <p class="card-text">
            Pour partager la partie, il suffit de donner l'URL généré à vos amis afin de les défier ! Ainsi, la même séquence musicale sera jouée. Vous pourrez finalement comparer vos résultats. 
            <br>
          </div>
        </div>
</div>
</body>
<div id="footer">
<footer class="bg-dark">
    <p><strong> Copyright © 2019 Tom Aubert_Antonio Vallera_Robin Prugne_Tuan Hung Ngyuen - IUT Nancy-Charlemagne - DUT Informatique  </strong></p>
</footer>
</div>
</html>
END;
        echo $html;
    }

}