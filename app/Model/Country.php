<?php

namespace App\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasApiTokens;
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code'
    ];

}
