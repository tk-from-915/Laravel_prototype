<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /**
     * 一括割り当て可能な属性。
     *
     * @var array
     */
    protected $fillable = [
        'original_file_name', 'file_path',
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
    public function posts()
    {
        return $this->belongsTo('App\Post');
    }
}
