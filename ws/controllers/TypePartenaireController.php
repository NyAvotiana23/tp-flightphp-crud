<?php
require_once __DIR__ . '/../models/TypePartenaire.php';
require_once __DIR__ . '/../helpers/Utils.php';

class TypePartenaireController {
    public static function getAll() {
        $model = new TypePartenaire();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new TypePartenaire();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new TypePartenaire();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new TypePartenaire();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Mouvement produit modifié']);
    }

    public static function delete($id) {
        $model = new TypePartenaire();
        $model->delete($id);
        Flight::json(['message' => 'Mouvement produit supprimé']);
    }
}
