<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionarios';
    protected $fillable = ['nome', 'cargo', 'dt_nasc', 'departamento_id'];

    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }
}
