<?php

require_once 'BaseModel.php';

class RetraitFond extends BaseModel {
    public function __construct() {
        parent::__construct('EF_retraits_fonds');
    }
}