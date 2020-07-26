<?php

namespace App\Http\Controllers;

use App\Contact;
use App\PhoneBook;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

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
    public function create($phonebookId)
    {
        $phonebookTitle = PhoneBook::find($phonebookId)->select('title')->first()->title;
        return view('contacts.create', compact('phonebookId', 'phonebookTitle'));
    }

    public function search(Request $request)
    {
        $contacts = DB::table('contacts')
            ->where('phonebook_id', '=', $request->phonebookId)
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%')
                    ->orWhere('patronymic', 'like', '%' . $request->search . '%')
                    ->orWhere('position', 'like', '%' . $request->search . '%')
                    ->orWhere('birthday', 'like', '%' . $request->search . '%')
                    ->orWhere('phone1', 'like', '%' . $request->search . '%')
                    ->orWhere('phone2', 'like', '%' . $request->search . '%')
                    ->orWhere('phone3', 'like', '%' . $request->search . '%')
                    ->orWhere('fax', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
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
        Log::info('$request');
        Log::info($request->all());
        $request->validate([
            'phonebook_id' => 'required|exists:phone_books,id',
            'first_name' => 'required|max:15',
            'last_name' => 'required|max:15',
            'patronymic' => 'max:15',
            'position' => 'max:255',
            'birthday' => 'max:15',
            'phone1' => 'max:15',
            'phone2' => 'max:15',
            'phone3' => 'max:15',
            'file' => 'image|mimes:jpeg,png,jpg,gif',
            'fax' => 'max:15',
            'email' => 'max:25'
        ]);

        $imagePath = null;
        if ($request->has('file') && $request->file('file')) {
            $name = Str::slug($request->input('last_name') . '_' . $request->input('first_name')) . '.' . $request->file('file')->getClientOriginalExtension();
            $image = Image::make($request->file('file'))->resize(509, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $directory = storage_path('app/public/contacts');
            if (!is_dir($directory)) {
                mkdir($directory);
            }
            $path = storage_path('app/public/contacts/' . $name);
            $imagePath = '/storage/contacts/' . $name;
            $image->save($path);
        }

        Contact::create([
            'phonebook_id' => $request->phonebook_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'position' => $request->position,
            'birthday' => $request->birthday,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'phone3' => $request->phone3,
            'fax' => $request->fax,
            'email' => $request->email,
            'photo' => $imagePath,
        ]);

        $successText = 'Контакт успешно добавлен!';
        return redirect()->route('phonebooks.contacts', $request->phonebook_id)->with('success', $successText);
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
    public function edit($phonebookId, $id)
    {
        $contact = Contact::find($id);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update($phonebookId, $id, Request $request)
    {
        Log::info('$request');
        Log::info($request->all());
        $request->validate([
            'phonebook_id' => 'required|exists:phone_books,id',
            'first_name' => 'required|max:15',
            'last_name' => 'required|max:15',
            'patronymic' => 'max:15',
            'position' => 'max:255',
            'birthday' => 'max:15',
            'phone1' => 'max:15',
            'phone2' => 'max:15',
            'phone3' => 'max:15',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'fax' => 'max:15',
            'email' => 'max:25'
        ]);

        $contact = Contact::find($id);

        $imagePath = null;
        if ($request->has('file') && $request->file('file')) {
            $name = Str::slug($request->input('last_name') . '_' . $request->input('first_name')) . '.' . $request->file('file')->getClientOriginalExtension();
            $image = Image::make($request->file('file'))->resize(509, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $directory = storage_path('app/public/contacts');
            if (!is_dir($directory)) {
                mkdir($directory);
            }
            $path = storage_path('app/public/contacts/' . $name);
            $imagePath = public_path('storage/contacts/' . $name);
            Log::info($imagePath);
            $image->save($path);
            $contact->photo = $imagePath;
        }

        $contact->update([
            'phonebook_id' => $request->phonebook_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'patronymic' => $request->patronymic,
            'position' => $request->position,
            'birthday' => $request->birthday,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'phone3' => $request->phone3,
            'fax' => $request->fax,
            'email' => $request->email,
        ]);

        $successText = 'Контакт успешно изменен!';
        return redirect()->route('phonebooks.contacts', $request->phonebook_id)->with('success', $successText);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($phonebookId, $id)
    {
        Contact::findOrFail($id)->delete();

        $successText = "Контакт удален!";
        return redirect()->route('phonebooks.contacts', $phonebookId)->with('success', $successText);
    }
}
