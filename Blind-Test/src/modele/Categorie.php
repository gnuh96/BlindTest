<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:09
 */

namespace blindtest\modele;


class Categorie extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Categorie' ;
    protected $primaryKey = 'idCateg' ;
    public $timestamps = false ;

    public function musique() {
        return $this->hasMany('\blindtest\modele\Musique', 'idMusique');
    }

}