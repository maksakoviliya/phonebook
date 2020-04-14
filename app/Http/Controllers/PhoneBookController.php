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

    public function all($id = 0)
    {
        $phonebooks = PhoneBook::where('parent_id', $id)->select('id', 'title')->get();

        return response()->json(compact('phonebooks'));
    }

    public function search(Request $request)
    {
        $phonebooks = PhoneBook::where('title', 'like', '%'.$request->search.'%')->limit(6)->select('id', 'title')->get();

        return response()->json(compact('phonebooks'));
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
        // dd($request->all());
        $validatedData = $request->validate([
            'title'       => 'required|min:3|max:255',
            'full_name'   => 'max:255',
            'description' => 'max:600',
            'parent_id'   => 'digits_between:1,3|nullable',
            'file'        => 'mimes:xls,xlsx',
            'site'        => 'max:255',
            'address'     => 'max:255',
            'email'       => 'sometimes|email|max:255|nullable',
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
            'parent_id'   => (int) $request->parent_id,
            'contacts'    => $contacts,
            'site'        => $request->site,
            'address'     => $request->address,
            'email'       => $request->email,
        ]);

        $successText = 'Справочник успешно добавлен!';
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
        $parent = PhoneBook::findOrFail($id)->only(['id', 'title']);

        $phonebooks = PhoneBook::where('parent_id', $parent['id'])->paginate(10);

        if (! count($phonebooks)) {
            return redirect()->route('phonebooks.edit', $parent['id']);
        }

        return view('phonebooks.index', compact('phonebooks', 'parent'));
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
            'file'        => 'mimes:xls,xlsx',
            'site'        => 'max:255',
            'address'     => 'max:255',
            'email'       => 'sometimes|email|max:255|nullable',
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
            'parent_id'   => (int) $request->parent_id,
            'site'        => $request->site,
            'address'     => $request->address,
            'email'       => $request->email,
        ]);

        $successText = 'Справочник успешно обновлен!';
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
