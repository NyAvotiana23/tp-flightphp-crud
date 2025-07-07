<?php
require_once 'BaseModel.php';

class TypeMouvementEtablissement extends BaseModel {
    public function __construct() {
        parent::__construct('types_mouvements_etablissements');
    }
}