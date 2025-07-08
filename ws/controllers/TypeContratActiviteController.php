<?php
require_once __DIR__ . '/../models/TypeContratActivite.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypeContratActiviteController {
    public static function getAll() {
        $model = new TypeContratActivite();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new TypeContratActivite();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new TypeContratActivite();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new TypeContratActivite();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Type de contrat d\'activité modifié']);
    }

    public static function delete($id) {
        $model = new TypeContratActivite();
        $model->delete($id);
        Flight::json(['message' => 'Type de contrat d\'activité supprimé']);
    }
}
