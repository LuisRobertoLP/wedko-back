<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleProyecto extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    public function usuario_proyectos()
    {
        return $this->hasMany(UsuarioProyecto::class,'role_proyecto_id','id');
    }
}
