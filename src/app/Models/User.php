<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'org_id'
    ];

 
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class,'org_id');
    }
     // JWTSubject Methods

    /**
     * Get the identifier that will be stored in the JWT
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); 
    }


    public function getJWTCustomClaims(): array
    {
        return [
            'id'=> $this->id,
            'usr'=>$this->first_name

        ];
    }

}
