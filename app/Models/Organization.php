<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = ['name'];
    use HasFactory;
    public function users(): HasMany
    {
        return $this->HasMany(User::class,'org_id');
    }
}
