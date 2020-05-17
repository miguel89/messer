<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    // Using soft delete does not actually removes the record from the database.
    // Instead, it will create a deleted_at column indicating when it was deleted
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date', 'expiration_date'
    ];

    /**
     * Get the user that owns the message.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
