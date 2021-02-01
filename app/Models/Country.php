<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package App\Models
 */
class Country extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'name'];

    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gigs(){
        return $this->hasMany(Gig::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states(){
        return $this->hasMany(State::class);
    }
}
