<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;


class System extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'systems';
    protected $guarded = [];

}
