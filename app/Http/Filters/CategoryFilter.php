<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends QueryFilter
{
    /**
     * @param string $name
     */
    public function name(string $name)
    {
        $words = array_filter(explode(' ', $name));

        $this->builder->where(function (Builder $query) use ($words) {
            foreach ($words as $word) {
                $query->where('name', 'like', "%{$word}%");
            }
        });
    }

    public function id(int $id)
    {
        $this->builder->find($id);
    }
}
