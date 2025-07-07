<?php 

require_once 'BaseModel.php';

class TypeContratActivite extends BaseModel {
    public function __construct() {
        parent::__construct('types_contrats_activite');
    }
}