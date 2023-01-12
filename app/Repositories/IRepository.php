<?php

namespace App\Repositories;

interface IRepository {

    public function get(int $id);

    public function getAll();

    public function getBy(string $colunm, string $param);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
    
}