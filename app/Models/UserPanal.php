<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserPanal extends Authenticatable
{
protected $table = 'user_panals';
   use HasFactory;
   protected $fillable=['name','email','password',];
}
