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
