<?php

namespace App\Models;
use Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invitations extends Model
{
    use HasFactory;
        protected $fillable = [
        'email', 'invitation_token', 'org_id','role',
    ];
    public function generateInvitationToken() {
        $this->invitation_token = substr(md5(rand(0, 9) . $this->email . time()), 0, 32);
    }
    public function getLink() {
        return urldecode(route('register', [
            'org_id' => $this->org_id,
            'invitation_token' => $this->invitation_token
        ]));
    }
}
