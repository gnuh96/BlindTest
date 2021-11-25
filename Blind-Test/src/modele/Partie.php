<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:22
 */

namespace blindtest\modele;


class Partie extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Partie' ;
    protected $primaryKey = 'token' ;
    public $timestamps = false ;

    public function classement() {
        return $this->hasMany('\blindtest\modele\Classement', 'token');
    }

    public function jouer() {
        return $this->hasMany('\blindtest\modele\Jouer', 'token');
    }

}