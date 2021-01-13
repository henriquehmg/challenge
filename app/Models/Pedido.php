<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'clients',
        'status'
    ];


    public function itensPedido()
    {
        return $this->hasMany(PedidoProduto::class, 'pedidos');
    }
    public function getClient()
    {
        return $this->hasOne(Client::class, 'id', 'clients');
    }
    public function relacaoInsert()
    {
        return $this->hasMany(PedidoProduto::class, 'pedidos', 'pastels', 'quantidade');
    }

}
