<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Book extends Model
{
    use Searchable;

    protected $guarded = [];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return ['name' => $array['name'], 'author' => $array['author'], 'description' => $array['description']];
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
