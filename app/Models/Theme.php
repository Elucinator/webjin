<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Business;

class Theme extends Model {

    protected $fillable = ['name', 'label', 'preview_image', 'is_active'];

    public function businesses() {
        return $this->hasMany(Business::class);
    }

}
