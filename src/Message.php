<?php

namespace Launcher\Mercurius;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'mercurius_messages';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['seen_at'];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'deleted_by_sender'   => 'boolean',
        'deleted_by_receiver' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(config('mercurius.models.user'), 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(config('mercurius.models.user'), 'receiver_id');
    }
}
