<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * 更新する項目
     * @var array
     */
    protected $fillable = [
        'uri', 'title','content',
    ];

    //belongsTo設定
    public function users()
    {
        return $this->belongsTo('App\User');
    }
}
