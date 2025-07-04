<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Models\Badge;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    private CustomerService $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['name', 'phone', 'isActive']);
        $customers = $this->service->filter($filters);
        return view('customers.index', compact('customers'));
        
    }


    public function search(Request $request)
    {
        $customers = $this->service->search($request->input('query'));
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        $badges = Badge::all();
        return view('customers.create', compact('badges'));
    }

    public function edit(int $id)
    {
        $model = $this->service->getById($id);
        $badges = Badge::all();
        return view('customers.edit', compact('model', 'badges'));
    }

    public function validateInput(Request $request)
    {
        $error = $this->service->validateData($request->input('name'), $request->input('value'));
        return response()->json(['error' => $error]);
    }

    public function addToDB(Request $request)
    {
        $this->service->create($request);
        return redirect('/customers');
    }

    public function updateToDB(Request $request, int $id)
    {
        $this->service->edit($request, $id);
        return redirect('/customers');
    }

    public function delete(int $id)
    {
        $this->service->delete($id);
        return response(200);
    }
}
