<?php

namespace App\Traits;

use Str;

trait UseSearchModel
{
    /**
     * Search model by fields.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                $fields
     * @param string                               $value
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrWhereAll($query, $fields, $value)
    {
        $query->where(function ($query) use ($fields, $value) {
            foreach ($fields as $field) {
                $query->orWhere($field, 'like', "%{$value}%");
            }
        });

        return $query;
    }

    /**
     * Sort model by field.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                               $sort
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort($query, $sort)
    {
        if (Str::startsWith($sort, '-')) {
            return $query->orderBy(substr($sort, 1), 'asc');
        }

        return $query->orderBy($sort, 'desc');
    }

    /**
     * Sort model by fields.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                $sorts
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSorts($query, $sorts)
    {
        foreach ($sorts as $sort) {
            if (Str::startsWith($sort, '-')) {
                $query->orderBy(substr($sort, 1), 'asc');
            } else {
                $query->orderBy($sort, 'desc');
            }
        }

        return $query;
    }
}
