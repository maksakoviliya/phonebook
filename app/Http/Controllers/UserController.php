<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private function getPhone($rawPhone)
    {
        $phone ='';

        if (substr($rawPhone, 0, 1) == '+') {
            $phone = substr($rawPhone, 1);
        } else {
            $phone = substr($rawPhone, 0);
        }

        return $phone;
    }
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

        $reqPhone = $this->getPhone($request->phone);


        $now = Carbon::now();
        $expires = Carbon::now()->addMinutes(10);

        $user = User::where('phone', $reqPhone)->first();
        if ($user) {
            return response()->json(['error'=>'Уже зарегистрирован']);
        }


        $phone = DB::table('sms_code')->where('phone', $reqPhone)->first();
        // return response()->json(['$now'=>$now->subMinutes(1), '$phone->created_at'=>Carbon::create($phone->created_at)]);
        
        if ($phone) {
            if ($now->subMinutes(1) < $phone->created_at) {
                return response()->json(['error'=>'Не прошла минута']);
            } else {
                DB::table('sms_code')->where('phone', $reqPhone)->delete();
            }
        }

        // $code = '1111';
        $code = rand(1000,9999);

        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth(env('SMSCRU_API_Id')));
        $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $code);

        // Log::info('$client');
        // Log::info(print_d($client));
        // Log::info('$sms');
        // Log::info(print_d($sms));

        try {
            $send = $client->smsSend($sms);
        } catch (Exception $e) {
            return response()->json(['error'=>'Не удалось отправить смс']);
        }

        if (!$send->ids) {
            return response()->json(['error'=>'Не удалось отправить смс']);
        }


        DB::table('sms_code')->insert([
            'phone' => $reqPhone,
            'code' => $code,
            'expires_at' => $expires,
            'created_at' => $now,
        ]);

        return response()->json(['success'=>'success']);
    }

    public function verifyCode(Request $request)
    {
        $now = Carbon::now();
        $reqPhone = $this->getPhone($request->phone);

        $phone = DB::table('sms_code')->where('phone', $reqPhone)->first();

        if (!$phone) {
            return response()->json(['error'=>'Нет кода для этого пользователя']);
        }
        if ($now > Carbon::create($phone->expires_at)) {
            return response()->json(['error'=>'Код уже не действует']);
        }
        if ($request->code != $phone->code) {
            return response()->json(['error'=>'Неверный код']);
        }
        return response()->json(['success'=>'Верный код']);
    }

    public function register(Request $request)
    {
        // $request - phone
        // $request - code
        // $request - name

        $now = Carbon::now();

        $phone = $this->getPhone($request->phone);

        $user = User::where('phone', $phone)->first();
        if ($user) {
            return response()->json(['error'=>'Уже зарегистрирован']);
        }

        $phone = DB::table('sms_code')->where('phone', $phone)->first();
        if (!$phone) {
            return response()->json(['error'=>'Нет кода для этого пользователя']);
        }
        if ($now > Carbon::create($phone->expires_at)) {
            return response()->json(['error'=>'Код уже не действует']);
        }
        if ($request->code != $phone->code) {
            return response()->json(['error'=>'Неверный код']);
        }
        DB::table('sms_code')->where('phone', $phone)->delete();

        $userId = User::create([
            'name'      => $request->name,
            'phone'     => $phone,
        ]);

        return redirect()->route('gettoken', compact('userId'));
    }

    public function getlogin(Request $request)
    {

        $now = Carbon::now();
        $expires = Carbon::now()->addMinutes(10);
        $reqphone = $this->getPhone($request->phone);

        $user = User::where('phone', $reqphone)->first();
        if (!$user) {
            return response()->json(['error'=>'Пользователь не зарегистрирован']);
        }
        $phone = DB::table('sms_code')->where('phone', $reqphone)->first();
        // return response()->json(['$now'=>$now->subMinutes(1), '$phone->created_at'=>Carbon::create($phone->created_at)]);
        if ($phone) {
            if ($now->subMinutes(1) < $phone->created_at) {
                return response()->json(['error'=>'Не прошла минута']);
            } else {
                DB::table('sms_code')->where('phone', $reqphone)->delete();
            }
        }

        /*Не тестовый пользователь*/
        if($user->id != 2) { 
            $code = rand(1000,9999);
           
            $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth(env('SMSCRU_API_Id')));
            $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $code);

            try {
                $send = $client->smsSend($sms);
            } catch (Exception $e) {
                return response()->json(['error'=>'Не удалось отправить смс']);
            }

            if (!$send->ids) {
                return response()->json(['error'=>'Не удалось отправить смс']);
            }
        } 
        /*Тестовый пользователь*/
         // phone +79991112233 //
        else {
            $code = '1111';
        }
        /*END Тестовый пользователь*/

        DB::table('sms_code')->insert([
            'phone' => $reqphone,
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
        $reqphone = $this->getPhone($request->phone);

        $user = User::where('phone', $reqphone)->first();
        if (!$user) {
            return response()->json(['error'=>'Пользователь не зарегистрирован']);
        }

        $phone = DB::table('sms_code')->where('phone', $reqphone)->first();
        if (!$phone) {
            return response()->json(['error'=>'Нет кода для этого пользователя']);
        }
        if ($now > Carbon::create($phone->expires_at)) {
            return response()->json(['error'=>'Код уже не действует']);
        }
        if ($request->code != $phone->code) {
            return response()->json(['error'=>'Неверный код']);
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
