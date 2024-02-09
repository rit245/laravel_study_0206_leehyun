<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model

{
    use HasFactory;

    /*  */
    protected $fillable = ['body', 'user_id'];

    //protected $guarded = ['id'];
    public static function count ()
    {
    }
}
