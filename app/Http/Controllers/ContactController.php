<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
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
    public function create()
    {
        //
    }

    public function search(Request $request)
    {
      $contacts = DB::table('contacts')
                    ->where('phonebook_id', '=', $request->phonebookId)
                    ->where(function ($query) use ($request) {
                      $query->where('first_name', 'like', '%'.$request->search.'%')
                            ->orWhere('last_name', 'like', '%'.$request->search.'%')
                            ->orWhere('patronymic', 'like', '%'.$request->search.'%')
                            ->orWhere('position', 'like', '%'.$request->search.'%')
                            ->orWhere('birthday', 'like', '%'.$request->search.'%')
                            ->orWhere('phone1', 'like', '%'.$request->search.'%')
                            ->orWhere('phone2', 'like', '%'.$request->search.'%')
                            ->orWhere('phone3', 'like', '%'.$request->search.'%')
                            ->orWhere('fax', 'like', '%'.$request->search.'%')
                            ->orWhere('email', 'like', '%'.$request->search.'%');
                            })
                    ->limit(6)->select('id', 'first_name', 'last_name', 'patronymic')->get();

      return response()->json(compact('contacts'));
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
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
  }
