<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model

{
    use HasFactory;

    /*  */
    protected $fillable = ['body', 'user_id'];

    //protected $guarded = ['id'];
    public static function count ()
    {
    }

    /* BelongsTo 타입을 추가하면 좋다 */
    public function user() :BelongsTo{
        /* belongsTo : 1:N 관계라는 의미 */
        /* User::clss : user 모델을 사용하겠다는 의미 */
        return $this->belongsTo(User::class);
    }

    public function  comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

}
