<?php
require_once __DIR__ . '/../models/RetraitFond.php';
require_once __DIR__ . '/../helpers/Utils.php';

class RetraitFondController {
    public static function getAll() {
        $model = new RetraitFond();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new RetraitFond();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new RetraitFond();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new RetraitFond();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Retrait de fond modifié']);
    }

    public static function delete($id) {
        $model = new RetraitFond();
        $model->delete($id);
        Flight::json(['message' => 'Retrait de fond supprimé']);
    }
}
