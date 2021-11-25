<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:11
 */

namespace blindtest\modele;


class Joueur extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Joueur' ;
    protected $primaryKey = 'idJoueur' ;
    public $timestamps = false ;

    public function jouer() {
        return $this->hasMany('\blindtest\modele\Jouer', 'idJoueur');
    }

    public function classement() {
        return $this->hasMany('\blindtest\modele\Classement', 'idJoueur');
    }

}