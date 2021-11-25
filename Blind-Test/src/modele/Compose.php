<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:27
 */

namespace blindtest\modele;


class Compose extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Compose' ;
    protected $primaryKey = 'idCompose' ;
    public $timestamps = false ;

    public function musique() {
        return $this->belongsTo('\blindtest\modele\Musique', 'idMusique');
    }
    public function auteur() {
        return $this->belongsTo('\blindtest\modele\Auteur', 'idAuteur');
    }

}