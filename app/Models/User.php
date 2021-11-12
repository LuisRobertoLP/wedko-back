<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'imagen'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function telefonos()
    {
        return $this->hasMany(Telefono::class,'usuario_id','id');
    }

    public function proyectos_usuario()
    {
        return $this->hasMany(UsuarioProyecto::class,'usuario_id','id');
    }
    public function proyecto_comentarios()
    {
        return $this->hasMany(ProyectoComentario::class,'usuario_id','id');
    }
    public function proyectoActividad()
    {
        
        return $this->belongsToMany(ProyectoActividad::class,'usuario_proyecto_actividads','usuario_id','proyecto_actividad_id')->withTimestamps();

    }
}
