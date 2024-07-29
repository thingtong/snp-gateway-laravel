<?php

namespace App\Repositories\Interfaces;

interface ExampleNote
{
    public function getAll();

    public function get(int $id);

    public function create(array $data);
}
