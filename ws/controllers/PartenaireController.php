<?php
require_once __DIR__ . '/../models/Partenaire.php';
require_once __DIR__ . '/../helpers/Utils.php';

class PartenaireController {
    public static function getAll() {
        $model = new Partenaire();
        $items = $model->findAllLoaded();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new Partenaire();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new Partenaire();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new Partenaire();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Partenaire modifié']);
    }

    public static function delete($id) {
        $model = new Partenaire();
        $model->delete($id);
        Flight::json(['message' => 'Partenaire supprimé']);
    }
}
