<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyAdjustment;

class CompanyAdjustmentController extends Controller
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
        
        $company_adjustments = CompanyAdjustment::with('user_adjusted')
            ->where('search_text', 'like', '%' . $search_string . '%' )
            ->paginate(15);
            
        return view('pages.company_adjustments')
            ->with('company_adjustments',  $company_adjustments)
            ->with('search_string', $search_string);
    }
}
