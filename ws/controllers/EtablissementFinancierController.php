<?php
require_once __DIR__ . '/../models/EtablissementFinancier.php';
require_once __DIR__ . '/../helpers/Utils.php';

class EtablissementFinancierController {
    public static function getAll() {
        $model = new EtablissementFinancier();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id) {
        $model = new EtablissementFinancier();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function getFirst() {
        $model = new EtablissementFinancier();
        $item = $model->getFirst(); 
        Flight::json($item);
    }

    public static function create() {
        $model = new EtablissementFinancier();
        $data = Flight::request()->data->getData();
        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id) {
        $model = new EtablissementFinancier();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Établissement financier modifié']);
    }

    public static function delete($id) {
        $model = new EtablissementFinancier();
        $model->delete($id);
        Flight::json(['message' => 'Établissement financier supprimé']);
    }
}