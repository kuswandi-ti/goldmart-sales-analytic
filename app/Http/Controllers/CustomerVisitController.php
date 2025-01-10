<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\RangeHarga;
use App\Models\TipeBarang;
use Illuminate\Http\Request;

class CustomerVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function input()
    {
        return view('customer_visit.input');
    }

    public function param1()
    {
        return view('customer_visit.param1');
    }

    public function param2()
    {
        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        $range_harga = RangeHarga::orderBy('nama', 'ASC')->get();

        return view('customer_visit.param2', compact('brand', 'tipe_barang', 'range_harga'));
    }

    public function param3()
    {
        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        return view('customer_visit.param3', compact('brand', 'tipe_barang'));
    }

    public function param4()
    {
        $brand = Brand::orderBy('nama', 'ASC')->get();
        $tipe_barang = TipeBarang::orderBy('nama', 'ASC')->get();
        return view('customer_visit.param4', compact('brand', 'tipe_barang'));
    }
}
