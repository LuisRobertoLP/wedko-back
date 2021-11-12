<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstatusProyectoActividad extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    public function proyecto_actividad()
    {
        return $this->hasMany(ProyectoActividad::class,'estatus_proyecto_actividad_id','id');
    }
}
