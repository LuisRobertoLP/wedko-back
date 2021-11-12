<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioProyecto extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'proyecto_id',
        'usuario_id',
        'role_proyecto_id'
    ];
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class,'proyecto_id','id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class,'usuario_id','id');
    }
    public function role_proyecto()
    {
        return $this->belongsTo(RoleProyecto::class,'role_proyecto_id','id');
    }
}
