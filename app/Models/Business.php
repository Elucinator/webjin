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
        'photo_url',
        'lat',
        'lng',
        'theme_id',
        'raw_json'
    ];

    public function theme() {
        return $this->belongsTo(Theme::class);
    }

}
