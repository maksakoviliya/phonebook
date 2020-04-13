<?php

namespace App\Http\Controllers;

use App\Imports\PhoneBookImport;
use App\PhoneBook;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PhoneBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $phonebooks = PhoneBook::where('parent_id', 0)->paginate(10);

        return view('phonebooks.index', compact('phonebooks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $phonebooks = PhoneBook::all();
        
        return view('phonebooks.create', compact('phonebooks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|max:255',
            'full_name'   => 'max:255',
            'description' => 'max:600',
            'parent_id'   => 'digits_between:1,3|nullable',
            'file'        => 'mimes:xls,xlsx'
        ]);
        if($request->file('file'))
        {
            $contacts = Excel::toCollection(new PhoneBookImport, request()->file('file'))->first();
        } else {
            $contacts = collect([]);
        }
        PhoneBook::create([
            'title'       => $request->title,
            'full_name'   => $request->full_name,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
            'contacts'    => $contacts,
        ]);

        $successText = 'PhoneBook has been created successfully!';
        return redirect()->route('phonebooks.index')->with('success', $successText);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhoneBook  $phoneBook
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('phonebooks.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhoneBook  $phoneBook
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $phonebook = PhoneBook::findOrFail($id);
        $phonebooks = PhoneBook::all();

        return view('phonebooks.edit', compact('phonebook', 'phonebooks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhoneBook  $phoneBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
         $validatedData = $request->validate([
            'title'       => 'required|max:255',
            'full_name'   => 'max:255',
            'description' => 'max:600',
            'parent_id'   => 'digits_between:1,3|nullable',
            'file'        => 'mimes:xls,xlsx'
        ]);

         $phonebook = PhoneBook::findOrFail($id);

        if($request->file('file'))
        {
            $contacts = Excel::toCollection(new PhoneBookImport, request()->file('file'))->first();
            $phonebook->update(['contacts' => $contacts]);
        } 

        $phonebook->update([
            'title'       => $request->title,
            'full_name'   => $request->full_name,
            'description' => $request->description,
            'parent_id'   => $request->parent_id,
        ]);

        $successText = 'PhoneBook has been updated successfully!';
        return redirect()->route('phonebooks.edit', $id)->with('success', $successText);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhoneBook  $phoneBook
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PhoneBook::findOrFail($id)->delete();

        $successText="Справочник удален!";
        return redirect()->route('phonebooks.index')->with('success', $successText);
    }
}
