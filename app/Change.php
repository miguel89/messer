<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
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
