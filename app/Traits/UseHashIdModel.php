<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Vinkla\Hashids\Facades\Hashids;

trait UseHashIdModel
{
    use UseHashId;

    public function toArray()
    {
        $array = parent::toArray();
        $array = ['hash_id' => Hashids::encode($this->attributes['id'])] + $array;

        return $array;
    }

    /**
     * Get Hash Attribute.
     *
     * @return string|null
     */
    public function getHashIdAttribute()
    {
        return Hashids::encode($this->attributes['id']);
    }

    /**
     * Get Model by hashed key.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $hash
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByHash(Builder $query, string $hash): Builder
    {
        return  $query->where($this->getQualifiedKeyName(), $this->hashToId($hash));
    }

    /**
     * Get model by hash or fail.
     *
     * @param $hash
     *
     * @return self
     *
     * @throw \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function byHashOrFail($hash): self
    {
        return self::query()->byHash($hash)->firstOrFail();
    }
}
