<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieve necessary data for dashboard
        return view('Dashboard');
    }
}
