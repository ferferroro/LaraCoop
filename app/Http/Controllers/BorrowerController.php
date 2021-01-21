<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Borrower;

class BorrowerController extends Controller
{

    /**
     * Require AUth and menu access
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'menu_access']); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search_string = $request['search_string'] ?? '';
        
        $borrowers = DB::table('borrowers')
                ->where('search_text', 'like', '%' . $search_string . '%' )
                ->paginate(15);

        return view('pages.borrowers')
            ->with('borrowers',  $borrowers)
            ->with('search_string', $search_string);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.borrower_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'primary_contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'percent_interest' => 'required|numeric|min:1',
            'percent_penalty' => 'required|numeric|min:1',
            'date_joined' => 'required|date',
        ]);

        $borrower = new Borrower;
        $borrower->fill($validated);
        $borrower->search_text = "$borrower->name $borrower->order $borrower->address $borrower->primary_contact $borrower->interest_rate $borrower->penalty_rate $borrower->date_joined";
        $borrower->save();
        $borrower->refresh();

        // get back to borrowers list and show only this record
        $borrowers = DB::table('borrowers')
                ->where('id', '=', $borrower->id )
                ->paginate(15);

        Session::flash('success_message', "Borrower ID [' $borrower->id '] has been added!");

        return redirect()->route('borrower.index');
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
    public function edit(Request $request)
    {
        $borrower_id = $request['id'] ?? 0;

        $borrower = Borrower::findOrFail($borrower_id);

        return view('pages.borrower_edit')
            ->with('borrower',  $borrower);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'primary_contact' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'percent_interest' => 'required|numeric|min:1',
            'percent_penalty' => 'required|numeric|min:1',
            'date_joined' => 'required|date',
        ]);

        $borrower_id = $request['id'] ?? 0;
        $borrower = Borrower::findOrFail($borrower_id);

        $borrower->fill($validated);
        $borrower->search_text = "$borrower->name $borrower->order $borrower->address $borrower->primary_contact $borrower->interest_rate $borrower->penalty_rate $borrower->date_joined";
        $borrower->save();
        
        Session::flash('success_message', "Borrower ID [' $borrower_id '] has been updated!");

        return redirect()->route('borrower.edit', ['id' => $borrower_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // find the record and delete it
        $borrower_id = $request['id'] ?? 0;
        $borrower = Borrower::findOrFail($borrower_id);
        $borrower->delete();

        // create success message 
        Session::flash('success_message', "Borrower ID [' $borrower_id '] has been deleted!");

        // go back to the index page
        return redirect()->route('borrower.index');
    }

    /**
     * Get borrower interest percentage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_borrower(Request $request)
    {
        // find the record and delete it
        $borrower_id = $request['id'] ?? 0;
        $borrower = Borrower::findOrFail($borrower_id);

        // go back to the index page
        return $borrower;
    }

    
}
