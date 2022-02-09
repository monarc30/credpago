<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'status_code_first', 'status_code_last', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
