<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Queries;

class QueryController extends Controller
{

    private $user_id;
    private $user_role;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() 
    {
        $this->middleware(function ($request, $next) {
            $this->user_id = auth()->user()->id;
            $this->user_role = auth()->user()->Role;
            return $next($request);
        });
        
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        if($this->user_role == 'admin')
            $queries = Queries::all();
        else
            $queries = Queries::where('user_id','=',$this->user_id)->get();
        return view('Query.index')->with('queries',$queries);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->Role == 'admin') {
            return redirect('/query')->with('error','Page not accesible');
        }
        return View('Query.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'query' => 'required'
        ]);
        $query = new Queries;
        $query->query = $request->input('query');
        $query->user_id = $this->user_id;
        $query->save();

        return redirect('/query')->with('success','Query Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $query = Queries::findOrFail($id);
                
        if($this->user_id != $query->user_id&&$this->user_role!='admin') {
            return redirect('/query')->with('error','Page not accesible');
        }  
        return view('/query/show')->with('query',$query);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($this->user_role != 'admin') {
            return redirect('/query')->with('error','Page not accesible');
        }
        $query = Queries::find($id);
        return view('/query/edit')->with('query',$query);
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
        $query = Queries::find($id);
        $query->solution = $request->input('solution');
        $query->update();
        return view('/query/show')->with('query',$query);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = Queries::find($id);
        if($this->user_id != $query->user_id) {
            return redirect('/query')->with('error','Page not accesible');
        }            
        $query->delete();
        return redirect('/query')->with('success','Query deleted');
    }
}
