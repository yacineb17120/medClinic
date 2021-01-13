<?php

namespace App\Http\Controllers;

use App\Http\Requests\Doctor\DoctorStoreRequest;
use App\Http\Requests\Doctor\DoctorUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{

    /**
     * Display a dome page
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('doctor.home');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::orderBy('last_name', 'Asc')
                        ->orderBy('first_name', 'Asc')
                        ->paginate(10);
        return view('doctor.index',['doctors'=>$doctors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Doctor\DoctorStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorStoreRequest $request)
    {
        if(Doctor::where('last_name',$request['last_name'])
            ->where('first_name',$request['first_name'] )->first()==null){

            $array_request = $this->processStoreRequest($request);
            $doc = Doctor::create($array_request);
            $request->session()->flash('store_doctor',$doc->last_name .' ' . $doc->first_name .' a été Ajouté a la liste des médecin.');
            return redirect(route('doctor.index'));
        }
        else{
            $request->session()->flash('first_name_last_name_unique',$request->first_name_last_name_unique_msg);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::guard('doctor')->user()->id == $id)
            return redirect(route('doctor.profile'));
        else
        {
            $doctor = Doctor::find($id);
            return view('doctor.edit',['doctor'=>$doctor]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Doctor\DoctorUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorUpdateRequest $request, $id)
    {
        $doctor = Doctor::find($id);
        //verify if he has changed the first_name last_name and that the combination of them are steel unique if not he redirect back
        if(
            (($doctor->last_name .' '. $doctor->first_name ) == ($request['last_name'] .' '. $request['first_name'] ))
            ||
            (count(Doctor::where('last_name',$request['last_name'])->where('first_name',$request['first_name'] )->get())==0)
        ){
            $array_request = $this->processUpdateRequest($request);
            $doctor->update($array_request);

            $request->session()->flash('update_doctor',$doctor->last_name .' ' . $doctor->first_name .' a été Mise a Jour.');
            return redirect(route('doctor.index'));
        }else{
            $request->session()->flash('first_name_last_name_exist',$request->first_name_last_name_exist_msg);
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Doctor::findOrFail($id)->delete();
        session()->flash('destroy_doctor','Un Docteur a été supprimer.');
        return redirect(route('doctor.index'));
    }


    /**
     * Show the Profile Of Auth Doctor.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('doctor.profile');
    }

    /*
    |---------------------------------------------------------------------------|
    | CUSTOM FUNCTION                                                           |
    |---------------------------------------------------------------------------|
    */

    /**
     * Process the Store Request
     *
     * @param  mixed $request
     * @return array
     */
    public function processStoreRequest(DoctorStoreRequest $request)
    {
        $request['password'] = Hash::make($request->input('password'));
        $array_except= ['_token'];
        if($request['specialty']==null)
            array_push($array_except,'specialty');

        return $request->except($array_except);
    }

     /**
     * Process the Update Request
     *
     * @param  mixed $request
     * @return array
     */
    public function processUpdateRequest(DoctorUpdateRequest $request)
    {
        $array_except= ['_token'];
        if($request['specialty']==null)
            array_push($array_except,'specialty');

        return $request->except($array_except);
    }
}
