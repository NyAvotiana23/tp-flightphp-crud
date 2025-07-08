<?php
require_once __DIR__ . '/../models/TypeMouvementEtablissement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypeMouvementEtablissementController {
    public static function getAll() {
        $model = new TypeMouvementEtablissement();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new TypeMouvementEtablissement();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new TypeMouvementEtablissement();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new TypeMouvementEtablissement();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Type de mouvement établissement modifié']);
    }

    public static function delete($id) {
        $model = new TypeMouvementEtablissement();
        $model->delete($id);
        Flight::json(['message' => 'Type de mouvement établissement supprimé']);
    }
}