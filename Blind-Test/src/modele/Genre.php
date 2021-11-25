<?php
/**
 * Created by PhpStorm.
 * User: vallera4u, aubert117u, prugne2u, nguyen187u
 * Date: 14/12/2018
 * Time: 11:00
 */

namespace blindtest\modele;


class Genre extends \Illuminate\Database\Eloquent\Model {

    protected $table = 'Genre' ;
    protected $primaryKey = 'idGenre' ;
    public $timestamps = false ;

    public function musique() {
        return $this->hasMany('\blindtest\modele\Musique', 'idMusique');
    }

}