<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'mobile',
        'country',
        'city',
        'postal_code',
        'address',
        'action_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function action()
    {
        return $this->belongsTo(customerActions::class, 'action_id')->select(['id', 'action_name']);
    }

    public function employees()
    {
        return $this->belongsToMany(Customer::class, 'customer_employee', 'customer_id', 'employee_id');
    }
}
