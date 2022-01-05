<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'total',
        'quantity',
        'end_date',
        'extra_days',
        'days',
        'teacher_id',
        'accepted',
        'rejected',

    ];

    public static function subscriptionDays($user_id)
    {

        $last_subscription = Subscription::find(Subscription::where('teacher_id', $user_id)
            ->where('accepted', true)->max('id'));

        $system = System::all()->first();

        $days = 0;

        if (!is_null($last_subscription)) {
            $fechaApertura = $last_subscription->created_at;
            $fechaVencimiento = now();
            $interval = $fechaApertura->diff($fechaVencimiento)->format("%a");

            $days = ($last_subscription->days + $last_subscription->extra_days) - $interval;
        } else {
            $fechaApertura = now();
            $fechaVencimiento = $system->free_date;
            if ($fechaApertura > $fechaVencimiento) {
                $days = -1;
            } else {
                $fechaApertura = now();
                $fechaVencimiento = $system->free_date;
                $interval = $fechaApertura->diff($fechaVencimiento)->format("%a");

                $days = $interval;
            }
        }

        if ($days < 0) {
            $days = 0;
        }

        return $days;
    }
}
