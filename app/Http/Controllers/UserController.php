<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Nutnet\LaravelSms\SmsSender;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_admin', false)->paginate(10);

        return view('users.index', compact('users'));
    }

     public function search(Request $request)
    {   
        // dd($request->all());
        $users = User::where('name', 'like', '%'.$request->search.'%')
                                ->orWhere('phone','LIKE','%'.$request->search.'%')->limit(6)->select('id', 'name')->get();

        return response()->json(compact('users'));
    }

    
    public function getCode(Request $request)
    {
        // $request - phone

        // $code = rand(1000,9999);
        $code = '1111';

        $now = Carbon::now();
        $expires = Carbon::now()->addMinutes(10);

        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            return response()->json(['response'=>'Уже зарегистрирован']);
        }

        $phone = DB::table('sms_code')->where('phone', $request->phone)->first();
        // return response()->json(['$now'=>$now->subMinutes(1), '$phone->created_at'=>Carbon::create($phone->created_at)]);
        if ($phone) {
            if ($now->subMinutes(1) < $phone->created_at) {
                return response()->json(['response'=>'Не прошла минута']);
            } else {
                DB::table('sms_code')->where('phone', $request->phone)->delete();
            }
        }

        DB::table('sms_code')->insert([
            'phone' => $request->phone,
            'code' => $code,
            'expires_at' => $expires,
            'created_at' => $now,
        ]);

        return response()->json(['success'=>'success']);
    }

    public function register(Request $request)
    {
        // $request - phone
        // $request - code
        // $request - name

        $now = Carbon::now();

        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            return response()->json(['response'=>'Уже зарегистрирован']);
        }

        $phone = DB::table('sms_code')->where('phone', $request->phone)->first();
        if (!$phone) {
            return response()->json(['response'=>'Нет кода для этого пользователя']);
        }
        if ($now > Carbon::create($phone->expires_at)) {
            return response()->json(['response'=>'Код уже не действует']);
        }
        if ($request->code != $phone->code) {
            return response()->json(['response'=>'Неверный код']);
        }
        DB::table('sms_code')->where('phone', $request->phone)->delete();

        $userId = User::create([
            'name'      => $request->name,
            'phone'     => $request->phone,
        ]);

        return redirect()->route('gettoken', compact('userId'));
    }

    public function getlogin(Request $request)
    {
        // $request - phone

        // $code = rand(1000,9999);
        $code = '1111';

        $now = Carbon::now();
        $expires = Carbon::now()->addMinutes(10);

        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return response()->json(['response'=>'Пользователь не зарегистрирован']);
        }

        $phone = DB::table('sms_code')->where('phone', $request->phone)->first();
        // return response()->json(['$now'=>$now->subMinutes(1), '$phone->created_at'=>Carbon::create($phone->created_at)]);
        if ($phone) {
            if ($now->subMinutes(1) < $phone->created_at) {
                return response()->json(['response'=>'Не прошла минута']);
            } else {
                DB::table('sms_code')->where('phone', $request->phone)->delete();
            }
        }

        DB::table('sms_code')->insert([
            'phone' => $user->phone,
            'code' => $code,
            'expires_at' => $expires,
            'created_at' => $now,
        ]);

        return response()->json(['success'=>'success']);
    }

    public function login(Request $request)
    {
        // $request - phone
        // $request - code

        $now = Carbon::now();

        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return response()->json(['response'=>'Пользователь не зарегистрирован']);
        }

        $phone = DB::table('sms_code')->where('phone', $user->phone)->first();
        if (!$phone) {
            return response()->json(['response'=>'Нет кода для этого пользователя']);
        }
        if ($now > Carbon::create($phone->expires_at)) {
            return response()->json(['response'=>'Код уже не действует']);
        }
        if ($request->code != $phone->code) {
            return response()->json(['response'=>'Неверный код']);
        }
        DB::table('sms_code')->where('phone', $user->phone)->delete();

        $userId = $user->id;

        return redirect()->route('gettoken', compact('userId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('users.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->with(['activations.code.customer', 'activations.code.phonebook'])->first();

        // dd($user);

        return view('users.edit', compact('user'));
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
        User::findOrFail($id)->delete();

        $successText="Пользователь удален!";
        return redirect()->route('users.index')->with('success', $successText);
    }
}
