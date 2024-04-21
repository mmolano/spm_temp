<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    public $primaryKey = 'id';
    protected $fillable = [
        'parent_id',
        'post_id',
        'user_id',
        'content',
    ];


    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, $this->post_id);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, $this->user_id);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')->withMany('replies');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
