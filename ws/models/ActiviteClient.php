<?php 

require_once 'BaseModel.php';

class ActiviteClient extends BaseModel {
    public function __construct() {
        parent::__construct('EF_activites_clients');
    }
}