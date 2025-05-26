<?php

namespace App\Models;

use Filament\Panel\Concerns\HasFont;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportus extends Model
{
    use HasFactory;
    protected $fillable =['user_name','type','subject','description','status','admin_user','admin_note','attachment','solve_date'];

    protected $casts = [
        'attachment' => 'array',
    ];
}
