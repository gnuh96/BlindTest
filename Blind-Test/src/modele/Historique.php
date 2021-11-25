<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 20/03/2019
 * Time: 12:41
 */

namespace blindtest\modele;


class Historique extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Historique' ;
    protected $primaryKey = 'idHistorique' ;
    public $timestamps = false ;

    public function musique() {
    return $this->hasMany('\blindtest\modele\Musique', 'idMusique');
    }

    public function partie() {
    return $this->hasMany('\blindtest\modele\Partie', 'token');
    }

}