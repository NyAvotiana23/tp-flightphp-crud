<?php
require_once __DIR__ . '/../models/FondInvestiClient.php';
require_once __DIR__ . '/../helpers/Utils.php';

class FondInvestiClientController {
    public static function getAll() {
        $model = new FondInvestiClient();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new FondInvestiClient();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new FondInvestiClient();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new FondInvestiClient();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Fond investi client modifié']);
    }

    public static function delete($id) {
        $model = new FondInvestiClient();
        $model->delete($id);
        Flight::json(['message' => 'Fond investi client supprimé']);
    }
}
