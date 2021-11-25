<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 24/01/2019
 * Time: 21:16
 */

namespace blindtest\controle;

use blindtest\vue\VuePartage as vue;
use blindtest\modele\Partie;

class ControlePartage
{

    function partagerPartie($id){
        $v = new vue([]);
        $v->render(1);
    }

    function send($id){
        $p=Partie::where('token',$id)->first();
        if($p==null){
            $v = new vue([]);
            $v->render(3);
        } else {
            $v = new vue($p);
            $v->render(2);
        }

    }

}