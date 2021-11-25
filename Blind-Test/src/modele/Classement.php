<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:32
 */

namespace blindtest\modele;


class Classement extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'Classement' ;
    protected $primaryKey = 'idClassement' ;
    public $timestamps = false ;

    public function partie() {
        return $this->belongsTo('\blindtest\modele\Partie', 'token');
    }

    public function joueur() {
        return $this->belongsTo('\blindtest\modele\Joueur', 'idJoueur');
    }

}