<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProduto extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedidos',
        'quantidade',
        'pastels'
    ];

    public function pastelTipo()
    {
        return $this->hasOne(Pastel::class, 'id', 'pastels');
    }


}
