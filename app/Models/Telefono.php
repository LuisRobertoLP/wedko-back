<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefono extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'numero',
        'descripcion',
        'usuario_id'
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class,'usuario_id','id');
    }
}
