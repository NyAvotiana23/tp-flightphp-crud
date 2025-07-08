<?php

require_once __DIR__ . '/../models/StatusContrat.php';
require_once __DIR__ . '/../helpers/Utils.php';

class StatusContratController {
    public static function getAll()
    {
        $model = new StatusContrat();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id)
    {
        $model = new StatusContrat();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create()
    {
        $model = new StatusContrat();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id)
    {
        $model = new StatusContrat();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Status de contrat modifié']);
    }

    public static function delete($id)
    {
        $model = new StatusContrat();
        $model->delete($id);
        Flight::json(['message' => 'Status de contrat supprimé']);
    }
}
