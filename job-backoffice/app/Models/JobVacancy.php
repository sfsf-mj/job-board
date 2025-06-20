<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobVacancy extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'job_vacancies';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'title',
        'description',
        'location',
        'salary',
        'type',
        'required_skills',
        'view_count',
        'company_id',
        'job_category_id',
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

    public function jobCategory()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id', 'id');
    }
}
