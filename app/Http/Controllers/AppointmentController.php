<?php

namespace App\Http\Controllers;

use App\Services\AppointmentService;
use App\Models\Customer;
use App\Models\CustomerService;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    private AppointmentService $service;

    public function __construct()
    {
        $this->service = new AppointmentService();
        $this->middleware('auth');
    }

    public function index()
    {
         return view('appointments.index');
    }


    public function all(Request $request)
    {
        $query = Appointment::with(['customer', 'service'])
            ->where('UserId', Auth::id());

        if ($request->filled('customer')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('Name', 'like', '%' . $request->customer . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('isActive')) {
            $query->where('IsActive', $request->isActive);
        }

        $appointments = $query->orderByDesc('AppointmentDate')->get();

        return view('appointments.all', compact('appointments'));
    }



    public function render()
    {
        $events = (new AppointmentService)->get();
        return view('livewire.calendar', ['events' => $events]);
    }

    public function create()
    {
        $userId = Auth::id();
        $customers = Customer::where('UserId', $userId)->get();
        $services = CustomerService::where('UserId', $userId)->get();

        return view('appointments.create', compact('customers', 'services'));
    }


    public function addToDB(Request $request)
    {
        $this->service->create($request);
        return redirect('/appointments')->with('success', 'Appointment created successfully!');
    }

     public function updateToDB(Request $request, int $id)
    {
        $this->service->edit($request, $id);
        return redirect('/appointments')->with('success', 'Appointment edited successfully!');
    }

    public function show($id)
    {
        $appointment = $this->service->getById($id);
        return view('appointments.show', ['model' => $appointment]);
    }

    public function edit($id)
    {
        $customers = Customer::all();
        $services = CustomerService::all();
        $appointment = $this->service->getById($id);
        
        return view('appointments.edit', [
            'customers' => $customers,
            'services' => $services,
            'appointment' => $appointment,
        ]);
    }


    public function delete(int $id)
    {
        $this->service->delete($id);
        return response(200);
    }
}