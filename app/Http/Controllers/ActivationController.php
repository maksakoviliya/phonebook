<?php

namespace App\Http\Controllers;

use App\Activation;
use App\Code;
use App\PhoneBook;
use App\User;
use Illuminate\Http\Request;

use App\Http\Resources\Phonebooks as PhonebooksResource;

class ActivationController extends Controller
{
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
    public function create(Request $request)
    {   
            if(! $user = User::find(Auth()->user()->id)) {
                return response()->json(['error'=>'No such user']);
            }
            if(! $code = Code::where('code', $request->code)->first()){
                return response()->json(['error'=>'No such code']);
            }
            
            if (in_array($code->id, $user->activations->pluck('code_id')->toArray())) {
                return response()->json(['error'=>'У пользователя уже есть доступ к этому справочнику']);
            }

            if ($code->users_count < $code->users_total) {
                try {
                    Activation::create([
                        'user_id' => $user->id,
                        'code_id' => $code->id,
                    ]);
                } catch (Exception $e) {
                    return response()->json(['error'=>$e->getMessage()]);
                }

                try {
                    $code->update([
                        'users_count' => $code->users_count+1
                    ]);
                } catch (Exception $e) {
                    return response()->json(['error'=>$e->getMessage()]);
                }
            } else {
                return response()->json(['error'=>'Превышено число лицензионных ключей']);
            }
            
            if (! $phoneBook = PhoneBook::find($code->phonebook_id)) {
                return response()->json(['error'=>'Ошибка - нет такого справочника']);
            }

            $contacts = $phoneBook->contacts;
            

        return new PhonebooksResource($phoneBook);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(! $user = User::find(Auth()->user()->id)) {
            return response()->json(['error'=>'No such user']);
        }
        if(! $code = Code::where('code', $request->code)->first()){
            return response()->json(['error'=>'No such code']);
        }

        if (! in_array($code->id, $user->activations->pluck('code_id')->toArray())) {
            return response()->json(['error'=>'У пользователя нет доступа к этому справочнику']);
        }

        if (! $phoneBook = PhoneBook::find($code->phonebook_id)) {
            return response()->json(['error'=>'Ошибка - нет такого справочника']);
        }

        return new PhonebooksResource($phoneBook);
        // return PhonebooksResource::collection($phoneBook);
        // $contacts = $phoneBook;

        // return response()->json(['contacts'=>$contacts]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function edit(Activation $activation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activation $activation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activation  $activation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activation $activation)
    {
        //
    }

    public function codes()
    {
        $codes = array_map(function($activation) {
            return $activation['code']['code'];
        }, Activation::where('user_id', Auth()->user()->id)->with('code')->get()->toArray());

        if (count($codes)) {
            return response()->json(compact('codes'));
        }
        return response()->json(['error'=>'Кодов не найдено']);
    }
}
