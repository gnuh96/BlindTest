<?php
/**
 * Created by PhpStorm.
 * User: tuanhung
 * Date: 2019-02-28
 * Time: 12:40
 */

namespace blindtest\modele;
require_once 'Choix.php';

class MusiqueMChoix extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'MusiqueMChoix';
    protected $primaryKey = 'idMusique' ;
    public $timestamps = false ;

    /**
     * @param Choix $choix
     * @return string
     */
    public function multichoix(\blindtest\modele\Choix $choix) {
        $s = null;
        $requete = "SELECT * FROM Musique";
        if ($choix->__get('idCateg') == 0 && $choix->__get('idGenre') != 0) {
            $s = "WHERE idGenre = ".$choix->__get('idGenre');
        }
        if ($choix->__get('idCateg') != 0 && $choix->__get('idGenre') == 0) {
            $s = "WHERE idCateg = ".$choix->__get('idCateg');
        }
        if ($choix->__get('idCateg') != 0 && $choix->__get('idGenre') != 0) {
            $s = "WHERE idCateg = ".$choix->__get('idCateg')." AND idGenre = ".$choix->__get('idGenre');
        }
        $aray = array($requete, $s);
        return implode(" ", $aray);
    }
}