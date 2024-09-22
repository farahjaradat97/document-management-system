<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use  Illuminate\Database\Eloquent\Relations\BelongsTo;


class Project extends Model
{
    protected $fillable = ['name','org_id'];
    use HasFactory;
    public function files(): HasMany
    {
        return $this->HasMany(File::class, 'project_id');
    }
   
}
