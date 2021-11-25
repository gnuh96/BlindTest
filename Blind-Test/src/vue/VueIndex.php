<?php
/**
 * Created by PhpStorm.
 * User: vallera4u
 * Date: 23/01/2019
 * Time: 13:52
 */

namespace blindtest\vue;

use blindtest\modele\Auteur;
use blindtest\modele\Categorie;
use blindtest\modele\Compose;
use blindtest\modele\Genre;
use blindtest\modele\Musique;

class VueIndex
{
    private $tab;

    private function mettreAnnee($tab){
        $str = "";
        foreach ($tab as $cat){
            $i=$cat['nomCateg'];
            $idInput = 'AN' .$i;
            $str.="<span class=\"button-checkbox\">";
            $str.="<input type=\"checkbox\" class=\"hidden\" id=\"$idInput\" style=\"display:none\"/>";
            $str.="<button type=\"button\" class=\"btn\" data-color=\"danger\">$i</button>";
            $str.="</span>";
            //$str.= "<span class='cat'><input type='checkbox' name='$i' id='$idInput'> <label lab='$i'>$i</label> </span>";
        }
        return $str;
    }

    private function reecrireAnnee($tab){
        $str="";
        foreach ($tab as $cat){
            $i=$cat['nomCateg'];
            $t="T".$i;
            $str.="<p id='$t' style='display:none'>- Année $i </p>";
        }
        return $str;
    }

    private function mettreGenre($tab){
        $str = "";
        foreach ($tab as $gen){
            $i=$gen['nomGenre'];
            $idInput = 'GE' .$i;
            $str.="<span class=\"button-checkbox\">";
            $str.="<input type=\"checkbox\" class=\"hidden\" id=\"$idInput\" style=\"display:none\"/>";
            $str.="<button type=\"button\" class=\"btn\" data-color=\"warning\">$i</button>";
            $str.="</span>";
            //$str.= "<span class='cat'><input type='checkbox' name='$i' id='$idInput'> <label lab='$i'>$i</label> </span>";
        }
        return $str;
    }

    private function reecrireGenre($tab){
        $str="";
        foreach ($tab as $gen){
            $i=$gen['nomGenre'];
            $i2=str_replace(" ","",$i);
            $t="T".$i2;
            $str.="<p id='$t' style='display:none'>- $i </p>";
        }
        return $str;
    }

    private function mettreAuteur($tab){
        $str = "";
        foreach ($tab as $aut){
            $i=$aut['nomArtiste'];
            $idInput = 'AU' .$i;
            $str.="<span class=\"button-checkbox\">";
            $str.="<input type=\"checkbox\" class=\"hidden\" id=\"$idInput\" style=\"display:none\"/>";
            $str.="<button type=\"button\" class=\"btn\" data-color=\"success\">$i</button>";
            $str.="</span>";
            //$str.= "<span class='cat'><input type='checkbox' name='$i' id='$idInput'> <label lab='$i'>$i</label> </span>";
        }
        return $str;
    }

    private function reecrireAuteur($tab){
        $str="";
        foreach ($tab as $aut){
            $i=$aut['nomArtiste'];
            $i2=str_replace(" ","",$i);
            $t="T".$i2;
            $str.="<p id='$t' style='display:none'>- $i </p>";
        }
        return $str;
    }

    private function session(){
        session_start();

        $_SESSION['choix']=[];

        $random=random_bytes(4);
        $random=bin2hex($random);
        $id="Partie".$random;
        $_SESSION['idPartie'] = $id;
    }

    public function render()
    {
        $this->session();

        $bouton1="Règles";
        $bouton2="Connexion";
        $bouton3="Accueil";
        $bouton4="Inscription";
        $bouton5="Je veux jouer !";

        //Affichage des années uniquement s'ils ont plus de 10 musiques associées répertoriées dans la base
        $categories = Categorie::all();
        $categoriesDisplay = [];
        foreach($categories as $c){
            $musique = Musique::where('idCateg','=',$c['idCateg'])->get()->count();
            if($musique >= 10){
                array_push($categoriesDisplay,$c);
            }
        }
        $c = $this->mettreAnnee($categoriesDisplay);
        $cr = $this->reecrireAnnee($categoriesDisplay);

        //Affichage des genres uniquement s'ils ont plus de 10 musiques associées répertoriées dans la base
        $genre = Genre::all();
        $genreDisplay = [];
        foreach($genre as $g){
            $musique = Musique::where('idGenre','=',$g['idGenre'])->get()->count();
            if($musique >= 10){
                array_push($genreDisplay,$g);
            }
        }
        $g = $this->mettreGenre($genreDisplay);
        $gr = $this->reecrireGenre($genreDisplay);

        //Affichage des artistes uniquement s'ils ont plus de 10 titres répertoriés dans la base
        $auteur = Auteur::all();
        $auteurDisplay = [];
        foreach($auteur as $aut){
            $compo = Compose::where('idAuteur','=',$aut['idAuteur'])->get()->count();
            if($compo >= 10){
                array_push($auteurDisplay, $aut);
            }
        }
        $a = $this->mettreAuteur($auteurDisplay);
        $ar = $this->reecrireAuteur($auteurDisplay);

        $id=$_SESSION['idPartie'];

        $contentButton = <<<END
            <a class="navbar-brand animated jackInTheBox delay-1s" href="" style="margin-left: 5%;"> Le Grand Blind Test </a>
            <span class="navbar-text white-text" style="margin-left: auto;">
              <a href="./login/register" class="btn btn-outline-light">$bouton4</a>
              <a href="./login" class="btn btn-outline-light">$bouton2</a>
            </span>
END;

        //Détermine l'affichage des boutons de login
        if(isset($_COOKIE['pseudo'])){
            if((strpos($_COOKIE['pseudo'], 'Joueur') === false)){
                $bouton6 = "Votre compte";
                $contentButton = <<<END
                <a class="navbar-brand animated jackInTheBox delay-1s" href=""> Le Grand Blind Test </a>
                <span class="navbar-text white-text" style="margin-left: auto;">
                  <a href="./login" class="btn btn-outline-light">$bouton6</a>
                </span>

END;
                //Transfert de cookie vers session
                $_SESSION['pseudo'] = $_COOKIE['pseudo'];
            }
        }


        $html=<<<END
<!DOCTYPE html>
<html>
<head>
    <title>LeGrandBlindTest</title>
    
    <video autoplay loop>
        <source src="./image/Animation.mp4" type="video/mp4"/>
    </video>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">  
    <link rel="stylesheet" href="./css/Style.css">
    <link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    
    <!-- lien pour test nvl checkbox -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="./script/checkBox.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="./script/scriptIndex.js"></script>
    
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
        
        <section class="main">
         <h2> <center> Faîtes vos choix </center></h2>
         <br/>
         <div class="container" style="text-align: center;">
              <div class="row">
                <div class="col-sm">
                  <h5> Toutes les époques </h5>
                  <p>$c</p>
                </div>
                <div class="vl"></div>
                <div class="col-sm">
                  <h5>Tous les genres </h5>
                  <p>$g</p>
                </div>
                <div class="vl"></div>
                <div class="col-sm">
                  <h5> Tous les artistes </h5>
                  <p>$a</p>
                </div>
              </div>
                           
            <section style="margin-top:5%;">
            
            <center><a href="./jouer/$id" class="btn btn-dark" id='jouer'>$bouton5</a></center>
            
            <!--    <div class="recherche">
                    <div class="row">
                        <nav class="grpBtn">
                            <input id="input" class="form-control" type="text" placeholder="Entrez le token de partage" name="token" style="width:30%"/>
                            <input id="bout" class="btn btn-primary" type="submit" value="Ok" onclick="location.href='./partage-Jouer/'+document.getElementById('input').value;"/>
                        </nav>
                    </div>
                </div>  -->
            
            </section>
        </section>
    </div>
 </div>
</body>
<div id="footer">
<footer class="bg-dark">
    <p><strong> Copyright © 2019 Tom Aubert_Antonio Vallera_Robin Prugne_Tuan Hung Ngyuen - IUT Nancy-Charlemagne - DUT Informatique </strong></p>
</footer>
</div>
</html>
END;
        echo $html;
    }

    public function getTab(){
        return $this->tab;
    }

}