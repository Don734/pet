<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class HandbookFilter extends AbstractFilter
{
    protected $columnsWhere = ['title', 'category_id'];

    public function apply(Builder $query)
    {
        foreach ($this->getColumnsWhere() as $column) {
            if ($this->request->has($column)) {
                $this->applyFilter($query, $column);
            }
        }

        return $query;
    }
}
