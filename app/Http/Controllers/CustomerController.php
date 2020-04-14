<?php

namespace App\Http\Controllers;

use App\Customer;
use App\PhoneBook;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $customers = Customer::paginate(10);

      return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create');
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
            'name'        => 'required|max:255',
            'phone'       => ['regex:/^(\+7|8)+([0-9]{10})$/'],
            'description' => 'max:600',
            'files_link'  => 'max:255',
        ]);

        $customer = Customer::create([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'description' => $request->description,
            'files_link'  => $request->files_link,
        ]);

        $successText = 'Заказчик успешно добавлен!';
        return redirect()->route('customers.edit', compact('customer'))->with('success', $successText);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('customers.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $phonebooks = PhoneBook::all();

        return view('customers.edit', compact('customer', 'phonebooks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'        => 'required|max:255',
            'phone'       => ["unique:customers,phone,$id",'regex:/^(\+7|8)+([0-9]{10})$/'],
            'description' => 'max:600',
            'files_link'  => 'max:255',
        ]);

        $customer = Customer::findOrFail($id)->update([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'description' => $request->description,
            'files_link'  => $request->files_link,
        ]);

        $successText = 'Информация о заказчике успешно обновлена!';
        return redirect()->route('customers.edit', compact('customer'))->with('success', $successText);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();

        $successText="Заказчик удален!";
        return redirect()->route('customers.index')->with('success', $successText);
    }
}
