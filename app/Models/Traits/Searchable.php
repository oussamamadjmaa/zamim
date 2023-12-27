<?php

namespace App\Models\Traits;

trait Searchable {
    protected $madjmaaSearchQuery;

    public function scopeSearch($query, $search){
        $columns = (array) $this->searchColumns();
        if($search && count((array) $columns)){
            $search = "%".$search."%";
            $this->madjmaaSearchQuery = $search;

            $query->where(function($q) use($search, $columns){
                foreach ($columns as $i => $column) {
                    $method = is_array($column) ? 'madjmaaWhereHas' : 'madjmaaSearchByColumn';
                    $q = $this->{$method}($q, $i, $column);
                }
            });

            return $query;
        }
        return $query;
    }

    public function searchColumns(){
        return [];
    }

    private function madjmaaSearchByColumn($q, $i, $column){
        $method = $i==0 ? 'where' : 'orWhere';
        $q->{$method}($column, 'LIKE', $this->madjmaaSearchQuery);

        return $q;
    }

    private function madjmaaWhereHas($q, $i, $column){
        $method = $i==0 ? 'whereHas' : 'orWhereHas';

        $q->{$method}($i, function($q2) use($column){
            $q2 = $this->madjmaaSearchOnRelation($q2, $column);
        });

        return $q;
    }

    private function madjmaaSearchOnRelation($q2, $column){
        foreach ($column as $i => $column2) {
            $method = is_array($column2) ? 'madjmaaWhereHas' : 'madjmaaSearchByColumn';

            $q2 = $this->{$method}($q2, $i, $column2, $this->madjmaaSearchQuery);
        }
        return $q2;
    }
}
