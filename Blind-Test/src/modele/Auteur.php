<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:20
 */

namespace blindtest\modele;


class Auteur extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Auteur' ;
    protected $primaryKey = 'idAuteur' ;
    public $timestamps = false ;

    public function compose() {
        return $this->hasMany('\blindtest\modele\Compose', 'idAuteur');
    }

}