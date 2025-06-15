<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'place_id',
        'name',
        'address',
        'phone',
        'website',
        'raw_json',
        'photo_url',
        'lat',
        'lng',
    ];

}
