<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title','start','end','status','allDay','user_id', 'service_id'
    ];

    public function setAttr($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function user()
    {
        return $this->hasOne(UserEvent::class, 'id','user_id');
    }

    public function service()
    {
        return $this->hasOne(Service::class, 'id','service_id');
    }

    public function getStartAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d');
    }
}
