<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'email', 'password', 'nama_lengkap', 'level'
    ];

    protected $hidden = [
        'password',
    ];
}
