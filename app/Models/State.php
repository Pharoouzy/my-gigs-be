<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 * @package App\Models
 */
class State extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['country_id', 'name'];

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(){
        return $this->belongsTo(Country::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states(){
        return $this->hasMany(State::class);
    }
}
