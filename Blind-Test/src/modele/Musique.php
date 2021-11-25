<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:25
 */

namespace blindtest\modele;


class Musique extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Musique' ;
    protected $primaryKey = 'idMusique' ;
    public $timestamps = false ;

    public function compose() {
        return $this->hasMany('\blindtest\modele\Compose', 'idMusique');
    }

    public function genre() {
        return $this->belongsTo('\blindtest\modele\Genre', 'idGenre');
    }
    public function categorie() {
        return $this->belongsTo('\blindtest\modele\Categorie', 'idCateg');
    }


}