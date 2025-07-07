<?php

require_once 'BaseModel.php';

class Etudiant extends BaseModel {
    public function __construct() {
        parent::__construct('etudiant');
    }
}