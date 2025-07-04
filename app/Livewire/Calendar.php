<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;


class Calendar extends Component
{
    public $events = [];

    public function mount()
    {
        if (!Auth::check()) {
            abort(403);
        }

        $this->loadEvents();
    }


    public function loadEvents()
    {
        try {
            $this->events = Appointment::with(['customer', 'service'])
                ->where('IsActive', true)
                ->where('UserId', Auth::id())
                ->get()
                ->map(function ($appointment) {
                    return [
                        'id' => $appointment->Id,
                        'title' => $appointment->service->Name ?? 'Appointment',
                        'start' => $appointment->StartDateTime,
                        'end' => $appointment->EndDateTime,
                        'url' => route('appointments.show', $appointment->Id),
                        'color' => $this->getEventColor($appointment->status ?? 'confirmed'),
                        'extendedProps' => [
                            'customer' => $appointment->customer->Name ?? '',
                            'service' => $appointment->service->Name ?? ''
                        ]
                    ];
                })
                ->toArray();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Failed to load appointments: ' . $e->getMessage());
            $this->events = [];
        }
    }


    protected function getEventColor($status)
    {
        return match(strtolower($status)) {
            'confirmed' => '#28a745',
            'pending' => '#ffc107',
            'cancelled' => '#dc3545',
            default => '#0d6efd'
        };
    }

    public function refresh()
    {
        $this->loadEvents();
        $this->dispatch('eventsUpdated', events: $this->events);
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}