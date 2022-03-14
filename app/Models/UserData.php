<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class UserData extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'phone';
    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'phone' => $this->phone,
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
        ];
    }

    protected $guarded = [];

    protected static $sex = [
        1 => 'Не указан',
        2 => 'Мужской',
        3 => 'Женский'
    ];

    protected static $type = [
        1 => 'Не указан',
        2 => 'Пенсионер',
        3 => 'Ребёнок',
        4 => 'Взрослый'
    ];

    // public function getCreatedAtAttribute($created_at): string
    // {
    //     return date('d.m.Y H:i:s', strtotime($created_at));
    // }

    // public function getCountExcursionsAttribute()
    // {
    //     return $this->excursionsPaidCount();
    // }

    public static function getSex(): array
    {
        return self::$sex;
    }

    // public function getSexAttribute(): string
    // {
    //     return self::$sex[$this->sex];
    // }

    public static function getType(): array
    {
        return self::$type;
    }

    // public function getTypeAttribute(): string
    // {
    //     return self::$type[$this->type];
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function excursions()
    {
        return $this->belongsToMany(Excursion::class);
    }

    public function excursionsPaidCount()
    {
        return $this->belongsToMany(Excursion::class)
            ->wherePivot('paid', true);
    }
}
