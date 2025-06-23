<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reporter_id',
        'license_plate',
        'photo_url',
        'violation_article_id',
        'location',
        'violation_date',
        'status',
        'rejection_reason',
        'report_fee',
        'verified_by',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the reporter (user) that owns the report.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Get the violation rule associated with the report.
     */
    public function violationRule()
    {
        return $this->belongsTo(ViolationRule::class, 'violation_article_id');
    }

    /**
     * Get the user who verified the report.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get the user who created the report.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the report.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
