<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
use App\Models\project;

class NewTask extends Model
{
    use HasFactory, softDeletes;
    public $new_task = "new_tasks";

    //protected $primarykey = 'id';

    protected $fillable = [
        'project_id', 'employee_id', 'task', 'effort_hours', 'progress', 'created_at', 'user_id'
    ];

    /*protected $casts = [
        'task' => 'array',
        'progress' => 'array'
    ];*/
    
    protected $dates = ['deleted_at'];
    

    public function projects(){
        return $this->belongsTo(project::class, 'project_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
