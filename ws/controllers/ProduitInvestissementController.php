<?php
require_once __DIR__ . '/../models/ProduitInvestissement.php';
require_once __DIR__ . '/../helpers/Utils.php';

class ProduitInvestissementController {
    public static function getAll() {
        $model = new ProduitInvestissement();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new ProduitInvestissement();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create() {
        $model = new ProduitInvestissement();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new ProduitInvestissement();
        $data = Flight::request()->data->getData();

        $model->update($id, $data);
        Flight::json(['message' => 'Produit d\'investissement modifié']);
    }

    public static function delete($id) {
        $model = new ProduitInvestissement();
        $model->delete($id);
        Flight::json(['message' => 'Produit d\'investissement supprimé']);
    }
}
