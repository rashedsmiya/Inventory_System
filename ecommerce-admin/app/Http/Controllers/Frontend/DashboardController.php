<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
class DashboardController extends BaseController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user();

        // You can add more data here as needed
        // For example: recent orders, favorite products, etc.

        return view('frontend.dashboard', compact('user'));
    }

    /**
     * Alternative index method (if your route uses index instead of dashboard)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->dashboard();
    }
}
