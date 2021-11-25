<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 24/01/2019
 * Time: 21:16
 */

namespace blindtest\controle;

use blindtest\modele\Auteur;
use blindtest\modele\Categorie;
use blindtest\modele\Genre;
use blindtest\modele\Compose;
use blindtest\modele\Musique;
use blindtest\modele\Partie;
use blindtest\vue\VueJeu as vue;
use blindtest\modele\Historique;

class ControlePartie
{

    function lancerPartie($id){
        /* RECUPERATION DES CHOIX */
        if(isset($_COOKIE["choix"])){
            $choix = $_COOKIE["choix"];
        }else{
            $choix = null;
        }

        $v = new vue($this->recupererMusiques($choix));
        $v->render(1);
    }

    //Récupère les musiques en fonction des choix
    function recupererMusiques($choix){
        $itt = 0;
        $res = [];
        //Si aucun choix, on prend tout
        if($choix == null){
            $reqMusique = Musique::all();

            //On converti l'objet en array pour pouvoir shuffle
            $musiquesArray = $reqMusique->toArray();
            //On mélange la liste
            shuffle($musiquesArray);

            if($itt === 0){
                for($i=0; $i<=9;$i++){
                    $comp = Compose::where('idMusique','=',$musiquesArray[$i]['idMusique'])->first();
                    $aut = Auteur::where('idAuteur','=',$comp['idAuteur'])->first();
                    $auteur = $aut['nomArtiste'];

                    //ajout de chaque musique dans un tableau
                    $title = $auteur ." - " .$musiquesArray[$i]['titre'];

                    //Condition pour les duplications
                    if(!in_array($title,$res)){
                        array_push($res,$title);
                    }
                }
                $itt = 1;
            }
        }else{
            $choix = explode(",",$choix);
            foreach($choix as $c) {
                if (strpos($c, 'AN') !== false) {
                    //Alors $c est un choix de type annee
                    $annee = str_replace("AN","",$c);
                    $idCateg = Categorie::where("nomCateg","=",$annee)->get();

                    $reqMusique = Musique::where('idCateg', '=', $idCateg[0]['idCateg'])->get();
                }else if (strpos($c, 'GE') !== false) {
                    //Alors $c est un choix de type genre
                    $genre = str_replace("GE","",$c);
                    $idGenre = Genre::where("nomGenre","=",$genre)->get();

                    $reqMusique = Musique::where('idGenre', '=', $idGenre[0]['idGenre'])->get();
                }else if (strpos($c, 'AU') !== false) {
                    //Alors $c est un choix de type auteur
                    $auteur = str_replace("AU","",$c);
                    $idAuteur = Auteur::where("nomArtiste","=",$auteur)->get();

                    $compo = Compose::where("idAuteur","=",$idAuteur[0]['idAuteur'])->get();
                    $reqMusique = [];
                    for($i=0; $i<10;$i++) {
                        $req = Musique::where('idMusique', '=', $compo[$i]['idMusique'])->first();
                        $comp = Compose::where('idMusique','=',$req['idMusique'])->first();
                        $aut = Auteur::where('idAuteur','=',$comp['idAuteur'])->first();
                        $auteur = $aut['nomArtiste'];

                        //ajout de chaque musique dans un tableau
                        $title = $auteur ." - " .$req['titre'];
                        if(!in_array($title,$res)){
                            array_push($res, $title);
                        }
                    }
                    shuffle($res);
                    $itt=1;
                }


                if($itt === 0){
                    $musiquesArray = $reqMusique->toArray();
                    //On mélange la liste
                    shuffle($musiquesArray);
                    for($i=0; $i<=9;$i++){
                        $comp = Compose::where('idMusique','=',$musiquesArray[$i]['idMusique'])->first();
                        $aut = Auteur::where('idAuteur','=',$comp['idAuteur'])->first();
                        $auteur = $aut['nomArtiste'];

                        //ajout de chaque musique dans un tableau
                        $title = $auteur ." - " .$musiquesArray[$i]['titre'];

                        //Condition pour les duplications
                        if(!in_array($title,$res)){
                            array_push($res,$title);
                        }
                    }
                    $itt = 1;
                }
            }
        }
        //$this->afficherListe($res);
        return $res;
    }

    function rejouerPartie($id){
        //Reset du tableau de musiques
        setcookie('tabSongs',null,0,'/');
        $_COOKIE['tabSongs'] = null;

        $_SESSION['idPartie'] = $id;

        $res = [];
        $partie = Partie::where('token','=',$id)->first();
        if($partie['partage'] !== null){
            $historiqueCount=Historique::where("token","=",$id)->count();
            $historique = Historique::whereBetween("idHistorique",[$historiqueCount-10,$historiqueCount])->get();
            foreach ($historique as $h){
                $musique = Musique::where('idMusique','=',$h['idMusique'])->get();


                $compo = Compose::where('idMusique','=',$h['idMusique'])->first();
                $auteur = Auteur::where('idAuteur','=',$compo['idAuteur'])->first();
                $title = $auteur['nomArtiste'] . " - " . $musique[0]['titre'];

                array_push($res,$title);
            }

            setcookie('tabSongs',implode("','",$res),0,"/");
            $_COOKIE['tabSongs'] = implode("','",$res);
            $v=new vue($res);
            $v->render(2);
        }
    }

    function afficherListe($array){
        for($i=0;$i<sizeof($array);$i++){
            echo $array[$i] . ", ";
        }
        echo "<br><br>";
    }

}