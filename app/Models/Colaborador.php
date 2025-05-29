<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $table = "colaboradores";

    protected $fillable = [
        "nome_completo",
        "apelido",
        "nome_pai",
        "nome_mae",
        "cpf",
        "data_nascimento",
        "cargo",
    ];
}
