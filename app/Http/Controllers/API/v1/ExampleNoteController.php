<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ExampleNote;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class ExampleNoteController extends Controller implements HasMiddleware
{
    private ExampleNote $exampleNote;

    public function __construct(ExampleNote $exampleNote)
    {
        $this->exampleNote = $exampleNote;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('role:user', only: ['getAll']),
        ];
    }

    public function getAll()
    {
        return $this->ok(
            $this->exampleNote->getAll()
        );
    }

    public function getById(int $id)
    {
        return $this->ok(
            $this->exampleNote->get($id)
        );
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'text' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $note = $this->exampleNote->create($data);
            DB::commit();

            return $this->ok($note, 'Note created successfully');
        } catch (\Exception $e) {
            return $this->rollBack($e, 'Failed to create note');
        }
    }
}
