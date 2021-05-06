<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Books extends Model
{
	use SoftDeletes;
    protected $table = 'books';
    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'author', 'book_name', 'published_date', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
