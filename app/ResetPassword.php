<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_resets';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'email', 'created_at'
    ];


    /**
     * No updated_at is needed
     * created_at is set on the SetCreatedAt observer
     */
    public $timestamps = false;
}
