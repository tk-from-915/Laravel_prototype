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
        'post_title', 'file_path','post_content',
    ];

    //belongsTo設定
    public function users()
    {
        return $this->belongsTo('App\User');
    }

    //hasMany設定
    public function attachments()
    {
        return $this->hasMany('App\Attachment', 'parent_id', 'id');
    }
    //hasMany設定
    public function comments()
    {
        return $this->hasMany('App\Comment', 'menu_id', 'id');
    }
}
