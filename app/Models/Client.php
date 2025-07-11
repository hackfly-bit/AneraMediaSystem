<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'company',
        'address',
        'phone',
        'email',
        'status',
    ];

    /**
     * Get the projects for the client.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the invoices for the client.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
