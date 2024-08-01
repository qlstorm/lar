<?php
 
namespace App\Http\Controllers;

use App\Models\Parametr;

class ParametersController
{
    public function list()
    {
        if (!isset($_GET['search'])) {
            $_GET['search'] = '';
        }

        return view('list', ['data' => Parametr::getList()]);
    }

    public function show($id)
    {
        $_GET['id'] = (int)$id;

        if (isset($_GET['delete_icon'])) {
            Parametr::deleteIcon();

            header('location: ' . $_SERVER['PATH_INFO']);

            exit;
        }

        Parametr::upload();

        return view('item', ['row' => Parametr::getList()[0], 'iconTypeList' => Parametr::$iconTypeList]);
    }

    public function json()
    {
        echo json_encode(Parametr::getList());
    }
}
