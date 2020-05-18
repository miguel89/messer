<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    // Using soft delete does not actually removes the record from the database.
    // Instead, it will create a deleted_at column indicating when it was deleted
    use SoftDeletes;

    // mass fillable attributes
    protected $fillable = [
        'subject',
        'content',
        'start_date',
        'expiration_date',
        'user_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_date', 'expiration_date'
    ];

    /**
     * @var mixed
     */
    private $subject;
    private $content;
    private $start_date;
    private $expiration_date;

    /**
     * Get the user that owns the message.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
