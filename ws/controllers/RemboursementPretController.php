<?php
require_once __DIR__ . '/../models/RemboursementPret.php';
require_once __DIR__ . '/../helpers/Utils.php';

class RemboursementPretController {
    public static function getAll() {
        $model = new RemboursementPret();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new RemboursementPret();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new RemboursementPret();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new RemboursementPret();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Remboursement prêt modifié']);
    }

    public static function delete($id) {
        $model = new RemboursementPret();
        $model->delete($id);
        Flight::json(['message' => 'Remboursement prêt supprimé']);
    }
}
