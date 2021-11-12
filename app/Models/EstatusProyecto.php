<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstatusProyecto extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
    public function proyecto()
    {
        return $this->hasMany(Proyecto::class,'estatus_proyecto_id','id');
    }
}
