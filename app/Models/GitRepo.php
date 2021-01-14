<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GitRepo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'repo_name', 'owner', 'repo_fork_url', 'is_progress'];

    protected $table = 'repo_user';
}
