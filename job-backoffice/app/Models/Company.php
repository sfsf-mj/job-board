<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasUuids, HasFactory, SoftDeletes;
    protected $table = "companies";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'industry',
        'website',
        'owner_id',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function casts(): array
    {
        return [
            'deleted_at' => 'datetime',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'category_id', 'id');
    }
}
