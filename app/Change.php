<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Change
 *
 * Represents a change made to a Message object.
 * @package App
 */
class Change extends Model
{
    // mass fillable attributes
    protected $fillable = [
        'description',
        'message_id',
        'user_id'
    ];

    /**
     * Get the user that made the change.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the message that originated the change.
     */
    public function message()
    {
        return $this->belongsTo('App\Message');
    }
}
