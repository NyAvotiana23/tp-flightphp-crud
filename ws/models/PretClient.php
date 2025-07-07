<?php

require_once 'BaseModel.php';

class PretClient extends BaseModel {
    public function __construct() {
        parent::__construct('prets_clients');
    }
}
