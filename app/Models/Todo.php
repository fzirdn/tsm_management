<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\Status;

class Todo extends Model
{
    use HasFactory;

    public $todolist = 'todos';

    protected $fillable = [
        'project_id',
        'lstatus_id',
        'todo',
        'user_id',
    ];


    public function projects(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function lstatus(){
        return $this->belongsTo(Status::class, 'project_id');
    }
}
