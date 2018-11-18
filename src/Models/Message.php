<?php

namespace Launcher\Mercurius\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = ['seen_at'];

    /**
     * {@inheritdoc}
     */
    // protected $casts = [
    //     'deleted_by_sender'   => 'boolean',
    //     'deleted_by_receiver' => 'boolean',
    // ];

    public function __construct()
    {
        $this->setTable(config('mercurius.table_names.messages'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(config('mercurius.models.conversation'), 'conversation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(config('mercurius.models.user'), 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(config('mercurius.models.user'), 'sender_id');
    }
}
