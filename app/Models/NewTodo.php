<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

use App\Models\Project;
use App\Models\Status;

class NewTodo extends Model
{
    use HasFactory, softDeletes;

    public $new_todo = 'new_todos';

    protected $fillable = [
        'project_id',
        'status_id', 
        'todo',
        'user_id',
    ];

    protected $dates = ['deleted_at'];


    public function projects(){
        return $this->belongsTo(project::class, 'project_id');
    }

    public function status(){
        return $this->belongsTo(Status::class, 'status_id');
    }
}
