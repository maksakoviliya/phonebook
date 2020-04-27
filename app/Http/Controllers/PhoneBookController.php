<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Imports\PhoneBookImport;
use App\PhoneBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
      $allPhonebooks = PhoneBook::all();

      return view('phonebooks.index', compact('phonebooks', 'allPhonebooks'));
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

      $newPhonebook = PhoneBook::create([
        'title'       => $request->title,
        'full_name'   => $request->full_name,
        'description' => $request->description,
        'parent_id'   => (int) $request->parent_id,
        'site'        => $request->site,
        'address'     => $request->address,
        'email'       => $request->email,
      ]);


      if($request->file('file'))
      {
        $contacts = Excel::toArray(new PhoneBookImport, request()->file('file'))[0];
        foreach ($contacts as $contact) {
          if ($contact['first_name'] != null &&
               $contact['last_name'] != null && 
               $contact['phone1'] != null) {
            $contact['phonebook_id'] = $newPhonebook->id;
            Contact::create($contact);
          }
        }
      } 

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

     $phonebook->update([
      'title'       => $request->title,
      'full_name'   => $request->full_name,
      'description' => $request->description,
      'parent_id'   => (int) $request->parent_id,
      'site'        => $request->site,
      'address'     => $request->address,
      'email'       => $request->email,
    ]);

     if($request->file('file'))
      {
        $oldContacts = Contact::where('phonebook_id', $phonebook->id)->get();
        foreach ($oldContacts as $oldContact) {
          $oldContact->delete();
        }

        $newContacts = Excel::toArray(new PhoneBookImport, request()->file('file'))[0];
        foreach ($newContacts as $newContact) {
          if ($newContact['first_name'] != null &&
               $newContact['last_name'] != null && 
               $newContact['phone1'] != null) {
            $newContact['phonebook_id'] = $phonebook->id;
            Contact::create($newContact);
          }
        }
      } 

    $successText = 'Справочник успешно обновлен!';
    return redirect()->route('phonebooks.edit', $id)->with('success', $successText);
  }

  public function contacts($phonebookId)
  {
    $phonebook = PhoneBook::findOrFail($phonebookId);
    $contacts = Contact::where('phonebook_id', $phonebook->id)->paginate(15);

    return view('contacts.index', compact('contacts', 'phonebook'));
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
