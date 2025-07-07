<?php
require_once __DIR__ . '/../models/PretClient.php';
require_once __DIR__ . '/../helpers/Utils.php';

class PretClientController {
    public static function getAll() {
        $model = new PretClient();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new PretClient();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new PretClient();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new PretClient();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Prêt client modifié']);
    }

    public static function delete($id) {
        $model = new PretClient();
        $model->delete($id);
        Flight::json(['message' => 'Prêt client supprimé']);
    }
}