<?php

namespace App\Http\Controllers;

use App\Mail\welcomeMail;
use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class User extends Controller
{

    public $json = [];
    public $status = 200;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users'
        ]);

        if ($validator->fails()) 
            return response()->json(['message' => 'Email already taken'], 400);
        
        $store = ModelsUser::create([
            'email' => request('email'),
            'password' => request('password'),
            'remember_token' => Str::random(60),
        ]);

        $this->json = $store ? ['message' => "User successfully registered"] : ['message' => "Invalid credentials"];
        $this->status = $store ? 201 : 400;

        if ($store)
            Mail::to(request('email'))->send(new welcomeMail($store));

        return response()->json($this->json, $this->status);
    }

    public function login(Request $request) {
        $user = ModelsUser::where('email', request('email'))
            ->where('password', request('password'))
            ->first();
        $now = Carbon::now();

        if(!$user) {
            $userEmail = ModelsUser::where('email', request('email'))
            ->first();
            
            if (!$userEmail['locked_at']) {
                if ($userEmail['failed_attempts'] > 4) {
                    $userEmail->locked_at = $now->toDateTimeString();
                    $userEmail->save();
                } else {
                    $userEmail->failed_attempts = $userEmail['failed_attempts'] + 1;
                    $userEmail->save();
                }
            } else {
                $locked_at = Carbon::createFromFormat('Y-m-d H:i:s', $userEmail['locked_at']);
                $locked_at->addMinutes(5);

                if($now->greaterThan($locked_at)) {
                    $userEmail->failed_attempts = 1;
                    $userEmail->locked_at = null;
                    $userEmail->save();
                } else {
                    return response()->json(['message' => 'Your account has been locked for 5mins'], 401);
                }
                
            }
        } else {
            $user->failed_attempts = 1;
            $user->locked_at = null;
            $user->save();
        }

        $this->json = $user ? ['access_token' => $user['remember_token']] : ['message' => 'Invalid credentials'];
        $this->status = $user ? 201 : 401;

        return response()->json($this->json, $this->status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
