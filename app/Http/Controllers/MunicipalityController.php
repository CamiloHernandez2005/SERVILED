<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipality;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class MunicipalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Municipality::query();
    
        if ($request->has('filtervalue')) {
            $filterValue = $request->input('filtervalue');
            $query->where('id', 'like', '%' . $filterValue . '%')
                ->orWhere('name', 'like', '%' . $filterValue . '%');
        }
    
        $municipalities = $query->get();
    
        return view('reports.municipalities', compact('municipalities'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
    }

    /**
     * Display the specified resource.
     *  
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $municipalities = Municipality::find($id);

        return view('municipalities.show', compact('municipalities'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     *  @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
       
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update()
    {
        
    }

    /**
     * Remove the specified resource from storage.
     * 
     */
    public function destroy()
    {
        
    }
}
