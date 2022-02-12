<?php


namespace App\Repositories;


interface AbstractRepositoryInterface
{
    public function list();

    public function store($data);

    public function update($item, $data);

    public function findOneBy($filters);

    public function delete($filters);
}
