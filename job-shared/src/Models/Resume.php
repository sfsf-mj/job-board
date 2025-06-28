<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'resumes';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'file_name',
        'file_Uri',
        'summary',
        'contact_details',
        'education',
        'experience',
        'skills',
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'resume_id', 'id');
    }
}
