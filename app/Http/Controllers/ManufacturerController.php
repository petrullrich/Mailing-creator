<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufacturers = DB::table('manufacturers')
                ->where('name','!=', 'Není')
                ->get();

        return view('manufacturer.index', ['manufacturers' => $manufacturers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manufacturer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $manufacturer = new Manufacturer();

        $manufacturer->name = $request->input('name');
        if(!empty($request->file('image'))){

            $newProductImg = $request->file('image');
            $imgName = time().'-'.$newProductImg->getClientOriginalName();

            $path = $newProductImg->storeAs(
                'images/manufacturers',
                $imgName,
                'public'
            );
            $manufacturer->image = '/storage/'.$path;
        }
        $manufacturer->save();
        return redirect()->route('manufacturer.edit', ['manufacturer' => $manufacturer->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('manufacturer.edit', ['manufacturer' => Manufacturer::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('manufacturer.edit', ['manufacturer' => Manufacturer::findOrFail($id)]);
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
        $manufacturer = Manufacturer::findOrFail($id);

        $manufacturer->name = $request->input('name');

        if(!empty($request->file('image'))){

            $newProductImg = $request->file('image');
            $imgName = time().'-'.$newProductImg->getClientOriginalName();

            $path = $newProductImg->storeAs(
                'images/manufacturers',
                $imgName,
                'public'
            );
            $path = Storage::disk("public")->url($path);
            $manufacturer->image = $path;
        }
        $manufacturer->save();

        return redirect()->route('manufacturer.edit', ['manufacturer' => $manufacturer->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        //DB::table('mailing_product')->where('mailing_id', '=', $id)->delete();
        $manufacturer->product()->update(['manufacturer_id' => null]);
        $manufacturer->delete();
        
        session()->flash('status', 'Výrobce byl smazán!');

        return redirect()->route('manufacturer.index'); 
    }
}
