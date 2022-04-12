<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilter extends QueryFilter
{
    /**
     * @param string $status
     */
    public function publish(string $status)
    {
        $this->builder->where('publish', strtolower($status));
    }

    /**
     * @param string $name
     */
    public function name(string $name)
    {
        $words = array_filter(explode(' ', $name));

        $this->builder->where(function (Builder $query) use ($words) {
            foreach ($words as $word) {
                $query->where('name', 'like', "%$word%");
            }
        });
    }

    /**
     * @param $price
     */
    public function price($price)
    {
        $prices = array_filter(explode(',', $price));

        $this->builder->whereBetween('price', $prices);
    }

    public function categories($value)
    {
        $this->builder->whereHas('categories', function ($q) use ($value) {
            $q->where('categories.id', $value);
            $q->orWhere('categories.name', 'like', "%$value%");
        });
    }

    public function trashed(bool $trashed)
    {
        $trashed ? $this->builder->onlyTrashed() : $this->builder->withoutTrashed();
    }
}
