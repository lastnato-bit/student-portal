<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name'];

    public function students()
    {
        return $this->hasMany(\App\Models\Student::class);
    }
    public function instructors()
{
    return $this->hasMany(Instructor::class);
}
public function courses()
{
    return $this->hasMany(\App\Models\Course::class);
}


}