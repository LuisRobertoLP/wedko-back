<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoComentario extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'comentario',
        'usuario_id',
        'proyecto_id'
    ];
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class,'proyecto_id','id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class,'usuario_id','id');
    }
}
