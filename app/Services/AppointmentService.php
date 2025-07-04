<?php 

namespace App\Services;

use App\Models\Appointment;
use App\Models\CustomerService;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentService
{

    public function get(): Collection
    {
        $appointments = Appointment::where('IsActive', true)
            ->where('UserId', Auth::id())
            ->with(['customer', 'service'])
            ->get();

        return $appointments->map(function ($appointment) {
            return [
                'title' => $appointment->customer->Name ?? 'Appointment',
                'start' => Carbon::parse($appointment->StartDateTime)->toIso8601String(),
                'end' => Carbon::parse($appointment->EndDateTime)->toIso8601String(),
                'url' => '/appointments' . $appointment->Id,
            ];
        });
    }
    
    public function create(Request $request)
    {
        $validated = $request->validate([
            'CustomerId' => 'required|exists:Customers,Id',
            'ServiceId' => 'required|exists:CustomerServices,Id',
            'StartDateTime' => 'required|date_format:Y-m-d\TH:i',
            'EndDateTime' => 'required|date_format:Y-m-d\TH:i',
            'AppointmentDate' => 'required|date',
            'status' => 'required|string|in:confirmed,pending,cancelled',
        ]);

        $model = new Appointment();
        $model->CustomerId = $validated['CustomerId'];
        $model->ServiceId = $validated['ServiceId'];
        $model->StartDateTime = $validated['StartDateTime'];
        $model->EndDateTime = $validated['EndDateTime'];
        $model->AppointmentDate = $validated['AppointmentDate'];
        $model->status = $validated['status'];
        $model->IsActive = true;
        $model->UserId = Auth::id();
        $model->save();

        return $model;
    }


    public function getById(int $id): Appointment
    {
        return Appointment::where('UserId', Auth::id())
            ->with(['customer', 'service'])
            ->findOrFail($id);
    }

    public function edit(Request $request, int $id): Appointment
    {
        $appointment = Appointment::where('UserId', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'CustomerId' => 'required|exists:Customers,Id',
            'ServiceId' => 'required|exists:CustomerServices,Id',
            'StartDateTime' => 'required|date_format:Y-m-d\TH:i',
            'EndDateTime' => 'required|date_format:Y-m-d\TH:i',
            'AppointmentDate' => 'required|date',
            'status' => 'required|string|in:confirmed,pending,cancelled',
            'IsActive' => 'nullable|boolean',
        ]);

        $appointment->CustomerId = $validated['CustomerId'];
        $appointment->ServiceId = $validated['ServiceId'];
        $appointment->StartDateTime = $validated['StartDateTime'];
        $appointment->EndDateTime = $validated['EndDateTime'];
        $appointment->AppointmentDate = $validated['AppointmentDate'];
        $appointment->status = $validated['status'];
        $appointment->IsActive = $request->input('IsActive', false);

        $appointment->save();

        return $appointment;
    }

    public function delete(int $id)
    {
        $appointment = Appointment::where('UserId', Auth::id())->findOrFail($id);
        $appointment->IsActive = false;
        $appointment->save();
    }

}