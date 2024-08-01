<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SQLite3;

class Parametr extends Model
{
    public static $iconTypeList = [
        1 => 'icon',
        2 => 'icon_gray'
    ];

    public static function getFilter() {
        $filter = [];

        if (isset($_GET['search'])) {
            $filter[] = '(' . implode(' or ', [
                'id like \'%' . (int)$_GET['search'] . '%\'',
                'title like \'%' . self::escape($_GET['search']) . '%\''
            ]) . ')';
        }

        if (isset($_GET['type'])) {
            $filter[] = 'type = ' . (int)$_GET['type'];
        }

        if (isset($_GET['id'])) {
            $filter[] = 'id = ' . (int)$_GET['id'];
        }

        $filterString = implode(' and ', $filter);

        return $filterString;
    }

    public static function getList() {
        $filter = self::getFilter();

        $query = 'SELECT * FROM parameters';

        if ($filter) {
            $query = $query . ' where ' . $filter;
        }

        $rows = DB::select($query);

        foreach ($rows as &$row) {
            foreach (self::$iconTypeList as $iconType) {
                if ($row->$iconType) {
                    $row->{$iconType . '_path'} = $row->id . '_' . $iconType;

                    $row->{$iconType . '_path'} = self::setExtension($row->{$iconType . '_path'}, $row->$iconType);
                }
            }
        }

        return $rows;
    }

    public static function upload() {
        if (isset($_FILES['icon']['name']) && $_FILES['icon']['name'] != '') {
            $id = (int)$_GET['id'];
            $type = (int)$_POST['type'];

            $root = $_SERVER['DOCUMENT_ROOT'] . '/images';

            if (!is_dir($root)) {
                mkdir($root, 0777, true);
            }

            //chmod($root, 0777);

            $path = $root . '/' . $id . '_' . self::$iconTypeList[$type];

            $path = self::setExtension($path, $_FILES['icon']['name']);

            if (move_uploaded_file($_FILES['icon']['tmp_name'], $path)) {
                $iconColumn = self::$iconTypeList[$type];

                DB::select('
                    update parameters
                    set
                        ' . $iconColumn . ' = \'' . self::escape($_FILES['icon']['name']) . '\'
                    where
                        id = ' . $id
                );
            }
        }
    }

    public static function deleteIcon() {
        $id = (int)$_GET['id'];
        $type = (int)$_GET['type'];

        $iconColumn = self::$iconTypeList[$type];

        DB::select('
            update parameters
            set
                ' . $iconColumn . ' = null
            where
                id = ' . $id
        );
    }

    public static function setExtension($file, $name) {
        $explodeResult = explode('.', $name);

        if (count($explodeResult) > 1) {
            return $file . '.' . end($explodeResult);
        }

        return $file;
    }

    private static function escape($string) {
        $string = SQLite3::escapeString($string);
        
        return $string;
    }
}
