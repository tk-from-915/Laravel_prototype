<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * 一括割り当て可能な属性。
     *
     * @var array
     */
    protected $fillable = [
        'post_title', 'post_content',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    //belongsTo設定
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    // リレーションシップ
    public function attachments()
    {
        return $this->hasMany('App\Attachment', 'parent_id', 'id');
    }
}
