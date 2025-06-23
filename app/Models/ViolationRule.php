<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationRule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'description',
        'fine_amount',
    ];

    /**
     * Get the reports that reference this violation rule.
     */
    public function reports()
    {
        return $this->hasMany(Report::class, 'violation_article_id');
    }
}
