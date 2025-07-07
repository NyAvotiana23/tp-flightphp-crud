<?php
require_once __DIR__ . '/../models/ContratPret.php';
require_once __DIR__ . '/../helpers/Utils.php';

class ContratPretController {
    public static function getAll() {
        $model = new ContratPret();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new ContratPret();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new ContratPret();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new ContratPret();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Mouvement bancaire client modifié']);
    }

    public static function delete($id) {
        $model = new ContratPret();
        $model->delete($id);
        Flight::json(['message' => 'Mouvement bancaire client supprimé']);
    }
}
