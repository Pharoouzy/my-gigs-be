<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gig extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'id';

    public $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'role', 'company_name', 'country_id', 'state_id', 'address', 'min_salary', 'max_salary'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }
}
