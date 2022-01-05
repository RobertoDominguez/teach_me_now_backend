<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use PDOException;


class SubscriptionAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $responseArr['status'] = true;
        $responseArr['data'] = Subscription::where('teacher_id', auth()->user()->id)->orderBy('id', 'desc')->get();
        $responseArr['message'] = 'subscriptions';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'image' => ['required','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'total' => ['required', 'max:4'],
            'quantity' => ['required', 'max:1'],
        ]);

        if ($validator->fails()) {
            $responseArr['status'] = false;
            $responseArr['data'] = [];
            $responseArr['message'] = $validator->messages()->first();
            $responseArr['is_valid'] = 0;
            $responseArr['token'] = '';
            return response()->json($responseArr, Response::HTTP_BAD_REQUEST);
        }

        $data = [
            'image' => '',
            'total' => $request->total,
            'quantity' => $request->quantity,
            'end_date' => Carbon::now(),
            'extra_days' => 0,
            'days' => 30 * $request->quantity,
            'teacher_id' => auth()->user()->id,
            'accepted' => false,
            'rejected' => false,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = Storage::disk('public')->put('subscriptions', $request->image);
        }

        try {
            $subscription = Subscription::create($data);
        } catch (PDOException $e) {
            Storage::disk('public')->delete($data['image']);

            $responseArr['status'] = false;
            $responseArr['data'] = [];
            $responseArr['message'] = $e->getMessage();
            $responseArr['is_valid'] = 0;
            $responseArr['token'] = '';
            return response()->json($responseArr, Response::HTTP_BAD_REQUEST);
        }


        $responseArr = array();

        $responseArr['status'] = true;
        $responseArr['data'] = $subscription;
        $responseArr['message'] = 'El comprobante se ha creado correctamente!';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }

    public function days(){
        $responseArr['status'] = true;
        $responseArr['data'] = Subscription::subscriptionDays(auth()->user()->id);
        $responseArr['message'] = 'dias de suscripcion';
        $responseArr['is_valid'] = 1;
        $responseArr['token'] = '';
        return response()->json($responseArr, Response::HTTP_OK);
    }
}
