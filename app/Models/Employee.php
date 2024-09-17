<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable=['name','email','phone','pofile'];
    public function companies(){
        return $this->hasBelongTo(Company::class);

    }
    public function users(){
        return $this->hasBelongTo(User::class);

    }
}
