<?php

require_once __DIR__ . '/../models/SimulationPret.php';
require_once __DIR__ . '/../helpers/Utils.php';

class SimulationPretController {
    public static function getAll()
    {
        $model = new SimulationPret();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id)
    {
        $model = new SimulationPret();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create()
    {
        $model = new SimulationPret();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id)
    {
        $model = new SimulationPret();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Status de contrat modifié']);
    }

    public static function delete($id)
    {
        $model = new SimulationPret();
        $model->delete($id);
        Flight::json(['message' => 'Status de contrat supprimé']);
    }
}
