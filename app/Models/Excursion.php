<?php

namespace App\Models;

use App\Pivots\ExcursionUserData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Excursion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static $completed = [
        1 => 'Не указан',
        2 => 'Пенсионер',
        3 => 'Ребёнок',
        4 => 'Взрослый'
    ];

    public static function getCompleted(): array
    {
        return self::$completed;
    }

    public function getNumberPeopleAttribute()
    {
        return $this->userDatas->count() + array_sum($this->userDatas->pluck('pivot')->pluck('number_people')->all());
    }

    // public function getCompletedAttribute($completed): string
    // {
    //     return self::$completed[$completed];
    // }

    public function userDatas()
    {
        return $this->belongsToMany(UserData::class)->withPivot(['final_price', 'number_people', 'paid', 'date_recording'])->using(ExcursionUserData::class);
    }
}
