<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_id',
    ];

    protected $table = 'employees';

    // If you need timestamps (created_at, updated_at columns)
    public $timestamps = true;

    /**
     * Get the company associated with the employee.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
