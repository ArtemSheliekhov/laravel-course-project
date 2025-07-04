<?php

namespace App\Http\Controllers;

use App\Services\CustomerServiceService;
use App\Models\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerServiceController extends Controller
{
    private CustomerServiceService $service;

    public function __construct(CustomerServiceService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = CustomerService::where('UserId', Auth::id());

        if ($request->filled('name')) {
            $query->where('Name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('is_active') && $request->is_active !== '') {
            $query->where('IsActive', $request->is_active);
        } else {
            $query->where('IsActive', true);
        }

        $models = $query->orderBy('Name')->get();

        return view('customerServices.index', [
            'models' => $models,
            'title' => 'customerService'
        ]);
    }

    public function create()
    {
        return view('customerServices.create');
    }

    public function edit(int $id)
    {
        $model = $this->service->getById($id);
        return view('customerServices.edit', ['model' => $model]);
    }

    public function validateInput(Request $request)
    {
        $error = $this->service->validateData($request->input('name'), $request->input('value'));
        return response()->json(['error' => $error]);
    }

    public function addToDB(Request $request)
    {
        $this->service->create($request);
        return redirect('/customerServices');
    }

    public function updateToDB(Request $request, int $id)
    {
        $this->service->edit($request, $id);
        return redirect('/customerServices');
    }

    public function delete(int $id)
    {
        $this->service->delete($id);
        return response(200);
    }
}
