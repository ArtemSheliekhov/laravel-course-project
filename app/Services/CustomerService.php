<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    public function get()
    {
        return $this->filter();
    }

    public function filter(array $filters = [])
    {
        $query = Customer::with('badges')->where('UserId', Auth::id());

        if (!empty($filters['name'])) {
            $query->where('Name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['phone'])) {
            $query->where('Phone', 'like', '%' . $filters['phone'] . '%');
        }

        if (isset($filters['isActive']) && $filters['isActive'] !== '') {
            $query->where('IsActive', (bool)$filters['isActive']);
        }

        return $query->latest()->get();
    }

    public function search(string $query)
    {
        return Customer::with('badges')
            ->where('UserId', Auth::id())
            ->where(function ($q) use ($query) {
                $q->where('Name', 'like', '%' . $query . '%')
                ->orWhere('Email', 'like', '%' . $query . '%')
                ->orWhere('Phone', 'like', '%' . $query . '%');
            })
            ->get();
    }


    public function getById(int $id)
    {
        return Customer::where('UserId', Auth::id())
                     ->findOrFail($id);
    }

    public function validateData($name, $value): string
    {
        if ($name === 'email') {
            if (empty($value)) {
                return 'Email is required!';
            }
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return 'Invalid email format!';
            }
            if (Customer::where('email', $value)
                      ->where('UserId', Auth::id())
                      ->exists()) {
                return 'Email already exists for your account!';
            }
        }
        if ($name === 'name' && empty($value)) {
            return 'Name is required!';
        }
        if ($name === 'phone' && !preg_match('^[\d\s\-+]+$/', $value)) {
            return 'Invalid phone number format!';
        }
        return '';
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email,NULL,id,UserId,'.Auth::id()],
            'phone' => ['required', 'string', 'max:20'],
            'badges' => ['array'],
            'badges.*' => ['integer', 'exists:badges,Id']
        ]);

        $model = Customer::create([
            'Name' => $request->input('name'),
            'Email' => $request->input('email'),
            'Phone' => $request->input('phone'),
            'IsActive' => true,
            'UserId' => Auth::id()
        ]);

        if ($request->has('badges')) {
            $model->badges()->sync($request->input('badges'));
        }

        return $model;
    }

    public function edit(Request $request, int $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email,'.$id.',id,UserId,'.Auth::id()],
            'phone' => ['required', 'string', 'max:20'],
            'badges' => ['array'],
            'badges.*' => ['integer', 'exists:badges,Id']
        ]);

        $model = $this->getById($id);
        $model->update([
            'Name' => $request->input('name'),
            'Email' => $request->input('email'),
            'Phone' => $request->input('phone'),
            'IsActive' => $request->input('isActive') ? true : false,
        ]);

        $badgeIds = $request->input('badges', []);
        foreach ($badgeIds as $badgeId) {
            if ($model->badges()->where('badge_Id', $badgeId)->exists()) {
                $model->badges()->updateExistingPivot($badgeId, [
                    'UpdatedAt' => now(),
                ]);
            }
        }

        return $model;
    }

    public function delete(int $id)
    {
        $model = $this->getById($id);
        $model->update(['IsActive' => false]);
        
        return $model;
    }

}