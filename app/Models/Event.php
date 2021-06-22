<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','start','end','status','allDay','user_id'
    ];

    public function setAttr($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function user()
    {
        return $this->hasOne(UserEvent::class, 'id','user_id');
    }
}
