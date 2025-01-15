<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:report sales per person'])->only(['reportSalesPerPerson']);
    }

    public function reportSalesPerPerson()
    {
        return view('report.sales_per_person');
    }

    public function reportSalesPerStore()
    {
        return view('report.sales_per_store');
    }

    public function reportSalesAllStore()
    {
        return view('report.sales_all_store');
    }
}
