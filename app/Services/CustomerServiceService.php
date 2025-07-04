<?php

namespace App\Services;

use App\Models\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class CustomerServiceService
{
    public function get(): Collection
    {
        return CustomerService::where('UserId', Auth::id())
                              ->where('IsActive', true)
                              ->get();
    }

    public function getById(int $id): ?CustomerService
    {
        return CustomerService::where('UserId', Auth::id())->find($id);
    }

    public function validateData($name, $value): string
    {
        if ($name === 'name' && empty($value)) {
            return 'Name is required!';
        }
        if ($name === 'price' && (!is_numeric($value) || $value < 0)) {
            return 'Price must be a non-negative number!';
        }
        if ($name === 'duration' && (!is_numeric($value) || $value <= 0)) {
            return 'Duration must be a positive number!';
        }
        return '';
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $model = new CustomerService();
        $model->Name = $request->input('name');
        $model->Description = $request->input('description');
        $model->Price = $request->input('price');
        $model->Duration = $request->input('duration');
        $model->IsActive = true;
        $model->UserId = Auth::id();
        $model->save();
    }

    public function edit(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|numeric|min:1',
            'description' => 'nullable|string',
        ]);

        $model = $this->getById($id);
        if (!$model) {
            abort(404);
        }

        $model->Name = $request->input('name');
        $model->Description = $request->input('description');
        $model->Price = $request->input('price');
        $model->Duration = $request->input('duration');
        $model->save();
    }

    public function delete(int $id)
    {
        $model = $this->getById($id);
        if ($model) {
            $model->IsActive = false;
            $model->save();
        }
    }
}
