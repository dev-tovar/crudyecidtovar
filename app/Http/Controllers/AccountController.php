<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return Account::with('infoTypeId')->orderBy('created_at', 'DESC')->get();
        } else {
            return response()->json(['message' => 'Forbidden request'], 403);
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:5120',
        ]);

        $image = $request->image;
        $nombre = $request->nombre;
        $apellido = $request->apellido;
        $tipo_id = $request->tipo_id;
        $numero_id = $request->numero_id;
        $numero_telefono = $request->numero_telefono;

        $full_save_path_name = null;

        if ($image) {
            $original_name = $request->image->getClientOriginalName(); //Original image file name
            $file_size = $request->image->getSize(); //Size in bytes
            $extension = $request->image->extension(); //Image file extension eg. jpg or png
            $directory = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d'); //Upload and move image into this directory
            $id = Str::random(8) . '_' . date('His'); //Random 8 character string
            $image_name = $id . '.' . $extension;
            $full_save_path_name = $directory . '/' . $image_name;
            $request->image->move(storage_path('app/public/' . $directory), $image_name); //Save into: public/images
        }

        DB::beginTransaction();
        try {

            $insertNewUser = new Account();
            $insertNewUser->nombre = $nombre;
            $insertNewUser->apellido = $apellido;
            $insertNewUser->tipo_id =  $tipo_id;
            $insertNewUser->numero_id = $numero_id;
            $insertNewUser->numero_telefono = $numero_telefono;
            $insertNewUser->path = $full_save_path_name;

            $insertNewUser->save();

            DB::commit();
            return response()->json(['response' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            unlink(storage_path('app/public/' . $full_save_path_name)); //se elimina la imagen que se cargo porque fue erronea
            return $e;
            // return false;
        }
        // return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Account::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


        $this->validate($request, [
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5120',
        ]);

        $image = $request->image;
        $nombre = $request->nombre;
        $apellido = $request->apellido;
        $tipo_id = $request->tipo_id;
        $numero_id = $request->numero_id;
        $numero_telefono = $request->numero_telefono;

        $full_save_path_name = null;

        $infoAccount = Account::find($id);

        if ($image) {
            unlink(storage_path('app/public/' . $infoAccount->path)); //se elimina la imagen que se tenia anteriormente


            $original_name = $request->image->getClientOriginalName(); //Original image file name
            $file_size = $request->image->getSize(); //Size in bytes
            $extension = $request->image->extension(); //Image file extension eg. jpg or png
            $directory = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d'); //Upload and move image into this directory
            $id = Str::random(8) . '_' . date('His'); //Random 8 character string
            $image_name = $id . '.' . $extension;
            $full_save_path_name = $directory . '/' . $image_name;
            $request->image->move(storage_path('app/public/' . $directory), $image_name); //Save into: public/images
        }

        DB::beginTransaction();
        try {

            $infoAccount->nombre = $nombre;
            $infoAccount->apellido = $apellido;
            $infoAccount->tipo_id =  $tipo_id;
            $infoAccount->numero_id = $numero_id;
            $infoAccount->numero_telefono = $numero_telefono;
            if (isset($full_save_path_name)) {
                $infoAccount->path = $full_save_path_name;
            }

            $infoAccount->save();

            DB::commit();
            return response()->json(['response' => 'success'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            unlink(storage_path('app/public/' . $full_save_path_name)); //se elimina la imagen que se cargo porque fue erronea
            return $e;
            // return false;
        }
        // return $request->all();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $infoAccount = Account::find($id);

        if(Storage::disk('public')->exists($infoAccount->path)){
            unlink(storage_path('app/public/' . $infoAccount->path)); 
        }

        Account::where('id', $id)->delete();




        return response()->json(['response' => 'success'], 200);
    }
}
