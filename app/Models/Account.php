<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'token', 'secret',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subAccounts()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
