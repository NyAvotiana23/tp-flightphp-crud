<?php

require_once __DIR__ . '/../models/MouvementStatusContrat.php';
require_once __DIR__ . '/../helpers/Utils.php';

class MouvementStatusContratController
{
    public static function getAll()
    {
        $model = new MouvementStatusContrat();
        $items = $model->getAll();
        Flight::json($items);
    }

    public static function getById($id)
    {
        $model = new MouvementStatusContrat();
        $item = $model->getById($id);
        Flight::json($item);
    }

    public static function create()
    {
        $model = new MouvementStatusContrat();
        $data = Flight::request()->data->getData();

        if (!isset($data['date_mouvement']) || empty($data['date_mouvement'])) {
            $data['date_mouvement'] = date('Y-m-d');
        }

        $saved = $model->create($data);
        Flight::json($saved);
    }

    public static function update($id)
    {
        $model = new MouvementStatusContrat();
        $data = Flight::request()->data;
        $model->update($id, $data);
        Flight::json(['message' => 'Mouvement modifié']);
    }

    public static function delete($id)
    {
        $model = new MouvementStatusContrat();
        $model->delete($id);
        Flight::json(['message' => 'Mouvement supprimé']);
    }
}
