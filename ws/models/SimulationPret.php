<?php

require_once 'BaseModel.php';

class SimulationPret extends BaseModel {
    public function __construct() {
        parent::__construct('EF_simulation_prets');
    }
}