<?php

namespace Launcher\Mercurius\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
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

    public function __construct()
    {
        $this->setTable(config('mercurius.table_names.conversations'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(config('mercurius.models.messages'));
    }
}
