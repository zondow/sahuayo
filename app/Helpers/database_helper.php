<?php

defined('WRITEPATH') or exit('No direct script access allowed');
function update($table, $set, $where = null)
{
    $builder = db()->table($table);
    if ($where) $builder->update($set, $where);
    else $builder->update($set);
    return db()->affectedRows();
}

function insert($table, $data)
{
    db()->table($table)->insert($data);
    return db()->insertID();
}

function delete($table, $where = null){
    $builder = db()->table($table);
    if ($where) $builder->delete($where);
    else $builder->delete();
    return db()->affectedRows();
}

function insert_batch($table,$data){
    return db()->table($table)->insertBatch($data);
}

function consultar_dato($table,$dato_a_consultar,$where){
    return db()->query("SELECT $dato_a_consultar FROM $table WHERE $where Limit 1")->getRowArray();
}

function consultar_datos($table,$datos_a_consultar,$where){
    return db()->query("SELECT $datos_a_consultar FROM $table WHERE $where")->getResultArray();
}