<?php
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../helpers/Utils.php';

class ClientController {
    public static function getAll() {
        $model = new Client();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new Client();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new Client();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new Client();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Client modifié']);
    }

    public static function delete($id) {
        $model = new Client();
        $model->delete($id);
        Flight::json(['message' => 'Client supprimé']);
    }
}