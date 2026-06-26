<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CountryContactAddress extends Model
{
    protected $fillable = ['country_contact_id', 'locale', 'address'];

    public function countryContact(): BelongsTo
    {
        return $this->belongsTo(CountryContact::class);
    }
}
