<?php

namespace Launcher\Mercurius\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'mercurius_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['seen_at'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deleted_by_sender'   => 'boolean',
        'deleted_by_receiver' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(config('mercurius.models.user'), 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(config('mercurius.models.user'), 'receiver_id');
    }
}
