<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vehicle
 * @package App
 */
class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'brand',
        'year',
        'description',
        'has_sold'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'year'     => 'integer',
        'has_sold' => 'boolean'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * Search for $lookingFor
     *
     * @param string $lookingFor
     * @return Collection
     */
    public function search(string $lookingFor)
    {
        $data = $this->where('name', 'like', \DB::raw("'%{$lookingFor}%'"))
                     ->orWhere('brand', 'like', \DB::raw("'%{$lookingFor}%'"))
                     ->orWhere('description', 'like', \DB::raw("'%{$lookingFor}%'"))
                     ->orWhere('has_sold', 'like', \DB::raw("'%{$lookingFor}%'"))
                     ->orWhere('year', 'like', \DB::raw("'%{$lookingFor}%'"))
                     ->get();

        return $data;
    }
}
