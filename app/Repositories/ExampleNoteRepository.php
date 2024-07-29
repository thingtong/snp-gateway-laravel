<?php

namespace App\Repositories;

use App\Models\ExampleNote as ModelsExampleNote;
use App\Repositories\Interfaces\ExampleNote;

class ExampleNoteRepository implements ExampleNote
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAll()
    {
        return ModelsExampleNote::all();
    }

    public function get(int $id)
    {
        return ModelsExampleNote::find($id);
    }

    public function create(array $data)
    {
        return ModelsExampleNote::forceCreate($data);
    }
}
