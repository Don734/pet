<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter
{
    protected $columnsWhere = [];
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract public function apply(Builder $query);

    protected function applyFilter(Builder $query, $column)
    {
        $value = $this->request->input($column);
        $query->where($column, 'LIKE', "%{$value}%");
    }

    protected function getColumnsWhere()
    {
        return $this->columnsWhere;
    }
}
