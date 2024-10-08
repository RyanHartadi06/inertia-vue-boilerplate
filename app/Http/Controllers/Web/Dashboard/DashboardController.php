<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Index', [
            'title'         => 'Dashboard',
            'pageTitle'     => 'Dashboard',
            'description'   => 'Welcome to HCMS'
        ]);
    }
}
