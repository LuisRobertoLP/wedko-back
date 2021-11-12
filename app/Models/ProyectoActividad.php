<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoActividad extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'descripcion',
        'proyecto_id',
        'estatus_proyecto_actividad_id',
        'fecha'
    ];
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class,'proyecto_id','id');
    }
    public function estatus()
    {
        return $this->belongsTo(EstatusActividad::class,'estatus_proyecto_actividad_id','id');
    }
    public function comentarios()
    {
        return $this->hasMany(ProyectoActividadComentario::class,'proyecto_actividad_id','id');
    }
    public function usuario_proyecto_actividad()
    {
        return $this->hasMany(UsuarioProyectoActividad::class,'proyecto_actividad_id','id');
    }
    public function usuarios()
    {
        
        return $this->belongsToMany(User::class,'usuario_proyecto_actividads','proyecto_actividad_id','usuario_id')->withTimestamps();

    }
}
