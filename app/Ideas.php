<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ideas extends Model
{
  protected $table = 'ideas';
    protected $fillable = ['title', 'content'];
    protected $primaryKey = 'IDIdea';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function votes()
    {
      return $this->hasMany('App\Votes', 'IDIdea');
    }
    public function element()
    {
      return $this->belongsTo(IdeasElements::class, 'IDElements', 'id');
    }
}
