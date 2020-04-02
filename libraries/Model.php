<?php

abstract class Model
{
    public static function select($champ, $table, $order, $limite, $where, $valueWhere)
    {
        require "pdo.php";
        $rq = $pdo->prepare("SELECT $champ FROM $table $order $limite $where");
        if ($valueWhere === '') {
            $rq->execute();
        } else {
            $rq->execute($valueWhere);
        }

        return $rq;
    }
    public static function insert($champ, $table, $prepValues, $values)
    {
        require "pdo.php";
        $rq = $pdo->prepare("INSERT INTO $table($champ) VALUES($prepValues)");
        $rq->execute($values);
    }
}
