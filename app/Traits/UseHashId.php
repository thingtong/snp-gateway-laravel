<?php

namespace App\Traits;

use Hashids;

trait UseHashId
{
    public function hashToId(string | array $hashid)
    {
        if (is_array($hashid)) {
            return array_map(function ($id) {
                return Hashids::decode($id)[0] ?? null;
            }, $hashid);
        } else {
            return Hashids::decode($hashid)[0] ?? null;
        }
    }

    public function idToHash(string | array $id)
    {
        if (is_array($id)) {
            return array_map(function ($item) {
                return Hashids::encode($item);
            }, $id);
        } else {
            return Hashids::encode($id);
        }
    }
}
