<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'descripcion',
        'estatus_proyecto_id',
    ];
    public function estatus()
    {
        return $this->belongsTo(EstatusProyecto::class,'estatus_proyecto_id','id');
    }
    public function usuarios_proyecto()
    {
        return $this->hasMany(UsuarioProyecto::class,'proyecto_id','id');
    }
    public function comentarios()
    {
        return $this->hasMany(ProyectoComentario::class,'proyecto_id','id');
    }
    public function proyecto_actividad()
    {
        return $this->hasMany(ProyectoActividad::class,'proyecto_id','id');
    }

}
