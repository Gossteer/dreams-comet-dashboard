<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ExcursionUserData extends Pivot
{
    public function getPaidAttribute($paid)
    {
        return $paid ? 'Оплачено' : 'Не оплачено';
    }
}
