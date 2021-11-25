<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:35
 */

namespace blindtest\modele;


class Jouer extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Jouer' ;
    protected $primaryKey = 'idJouer' ;
    public $timestamps = false ;

    public function joueur() {
        return $this->hasMany('\blindtest\modele\Joueur', 'idJoueur');
    }

    public function partie() {
        return $this->hasMany('\blindtest\modele\Partie', 'token');
    }

}