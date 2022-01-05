<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Subject;
use App\Models\Subscription;
use App\Models\University;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function all()
    {
        $subscriptions = Subscription::join('users', 'subscriptions.teacher_id', 'users.id')->select('subscriptions.*', 'users.name')->orderBy('subscriptions.id', 'desc')->get();
        return view('subscription.all', compact('subscriptions'));
    }

    public function index()
    {
        $subscriptions = Subscription::join('users', 'subscriptions.teacher_id', 'users.id')->select('subscriptions.*', 'users.name')->orderBy('subscriptions.id', 'asc')
            ->where('subscriptions.accepted', false)->where('subscriptions.rejected', false)
            ->get();

        return view('subscription.index', compact('subscriptions'));
    }

    public function show(Subscription $subscription)
    {
        return view('subscription.show', compact('subscription'));
    }

    public function accept(Subscription $subscription, Request $request)
    {
        $last_pay = Subscription::find(Subscription::where('teacher_id', $subscription->teacher_id)
            ->where('accepted', true)->max('id'));

        $extra_days = 0;
        if (!is_null($last_pay)) {
            $fechaApertura = $last_pay->created_at;
            $fechaVencimiento = now();
            $interval = $fechaApertura->diff($fechaVencimiento)->format("%a");

            $extra_days = ($last_pay->days + $last_pay->extra_days) - $interval;
            if ($extra_days < 0) {
                $extra_days = 0;
            }
        }

        //añadiendo dias de suscripcion al usuario
        $days_to_add = $extra_days + $subscription->days;
        $end_date=Carbon::now()->addDays($days_to_add);

        $subscription->update([
            'accepted' => true,
            'extra_days' => $extra_days,
            'end_date' => $end_date,
        ]);


        $teacher = User::find($subscription->teacher_id);
        $teacher->update([ 'end_subscription' => $end_date ]);


        return redirect()->route('subscription.index');
    }

    public function reject(Subscription $subscription, Request $request)
    {
        $subscription->update(['rejected' => true]);
        return redirect()->route('subscription.index');
    }

    public function showTeacher(User $teacher)
    {
        $university = University::where('id', $teacher->university_id)->get()->first();
        $subjects = Subject::join('teaches', 'teaches.subject_id', 'subjects.id')
            ->where('teaches.teacher_id', $teacher->id)->select('subjects.*', 'teaches.level')->get();

        $schools = School::join('studies', 'studies.school_id', 'schools.id')
            ->where('studies.teacher_id', $teacher->id)->select('schools.*')->get();

        return view('subscription.teacher', compact('teacher', 'subjects'), compact('university', 'schools'));
    }
}
