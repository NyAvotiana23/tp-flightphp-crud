<?php
require_once __DIR__ . '/../models/TypeFond.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypeFondController {
    public static function getAll() {
        $model = new TypeFond();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new TypeFond();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new TypeFond();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new TypeFond();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Type de fond modifié']);
    }

    public static function delete($id) {
        $model = new TypeFond();
        $model->delete($id);
        Flight::json(['message' => 'Type de fond supprimé']);
    }
}
