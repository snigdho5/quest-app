<?php

namespace App\Models\AdminModels;

use Illuminate\Database\Eloquent\Model;

class TriviaContest extends Model
{
    protected $table = 'trivia_contest';
    protected $fillable = ['user_id', 'questions', 'answers', 'score', 'winner'];
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
