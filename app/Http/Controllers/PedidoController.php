<?php

namespace App\Http\Controllers;

use App\Mail\PedidoRealizado;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\DB;
use Mail;

class PedidoController extends Controller
{


    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    public function index()
    {
        $retornos = $this->pedido->where('ativo', true)->get();
        $pedidos = array();
        foreach($retornos as $retorno){
            $cliente = $retorno->getClient()->first();
            $jsonCliente = ['nome'=>$cliente->nome, 'email'=>$cliente->email, 'telefone'=>$cliente->telefone, 'data_nascimento'=>$cliente->data_de_nascimento, 'endereco'=>$cliente->endereco, 'complemento'=>$cliente->complemento, 'bairro'=>$cliente->bairro, 'cep'=>$cliente->cep, 'criadoEm'=>$cliente->created_at];

            $itens = $retorno->itensPedido()->where('ativo', true)->get();
            $produtos = array();
            foreach($itens as $item){
                //Pega a lista de todos os itens
                $pastelGet = $item->pastelTipo()->first();
                $jsonPastel = ['id'=>$pastelGet->id, 'nome'=>$pastelGet->nome, 'preco'=>$pastelGet->preco, 'photo'=>$pastelGet->foto];
                $insereArray = ['quantidade'=>$item->quantidade, 'pastel'=>$jsonPastel];
                array_push($produtos, $insereArray);
                //Para pegar a nomeclatura do Pastel.
                //

                //Gerar um Json com todos os itens
            }
            $jsonPedido = ['id'=>$retorno->id, 'cliente'=>$jsonCliente, 'itens'=> $produtos];
            array_push($pedidos, $jsonPedido);
        }
        return response()->json(['codigo' =>'200', 'data' =>$pedidos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $requests = $request->all();
            $insert_pedido = $this->pedido->create(['clients'=>$requests["id_cliente"], 'status'=> '']);
            foreach(json_decode($requests["pastel"], true) as $pastel){
                $create = ["pedidosa" => $insert_pedido->id, 'quantidade' => $pastel["quantidade"], 'pastels' => $pastel["id_pastel"]]; // Algum erro aqui!
                //return response()->json(['msg' => $create, 'cod' => '201'], 201);
                DB::table('pedido_produtos')->insert($create);
                //$this->pedido->relacaoInsert()->create($create);
            }
            //$this->client->create($clientData);

        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['error'=> $e->getMessage(), 'codigo'=> '1010']);
            }
            return response()->json(['error'=> 'Erro ao realizar a operação', 'codigo'=> '1010']);
        }

        //Pega informações para envio de email
        $retorno = $this->pedido->where('id', $insert_pedido->id)->where('ativo', true)->first();
        if($retorno){
            $cliente = $retorno->getClient()->first();

            $itens = $retorno->itensPedido()->get();
            $produtos = array();
            foreach($itens as $item){
                //Pega a lista de todos os itens
                $pastelGet = $item->pastelTipo()->first();
                $insereArray = ['quantidade'=>$item->quantidade, 'pastel'=>$pastelGet];
                array_push($produtos, $insereArray);
            }
            $jsonPedido = ['id'=>$retorno->id, 'criado_em'=>$retorno->created_at, 'cliente'=>$cliente, 'itens'=> $produtos];
            //Enviar email
            $email = new PedidoRealizado($jsonPedido);
            $email->build();
            return response()->json(['msg' => 'Pedido criado com sucesso', 'cod' => '201'], 201);
        }else{
            return response()->json(['codigo' =>'404']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $retorno = $this->pedido->where('id', $id)->where('ativo', true)->first();
        if($retorno){
            $cliente = $retorno->getClient()->first();

            $itens = $retorno->itensPedido()->where('ativo', true)->get();
            $produtos = array();
            foreach($itens as $item){
                //Pega a lista de todos os itens
                $pastelGet = $item->pastelTipo()->first();
                $insereArray = ['quantidade'=>$item->quantidade, 'pastel'=>$pastelGet];
                array_push($produtos, $insereArray);
            }
            $jsonPedido = ['id'=>$retorno->id, 'criado_em'=>$retorno->created_at, 'cliente'=>$cliente, 'itens'=> $produtos];
            return response()->json(['codigo' =>'200', 'data' =>$jsonPedido]);
        }else{
            return response()->json(['codigo' =>'404']);
        }

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //request->novo cliente
        try{
            $pedido_data = $request->all();
            $pedido = $this->pedido->find($id);
            if(isset($pedido_data['cliente'])){
                $pedido->update(['clients'=>$pedido_data['cliente']]);
            }
            if(isset($pedido_data['novoPastel'])){
                foreach ($pedido_data['novoPastel'] as $novoPastel) {
                    $create = ["pedidosa" => $id, 'quantidade' => $novoPastel["quantidade"], 'pastels' => $novoPastel["id_pastel"]];
                    DB::table('pedido_produtos')->insert($create);
                }
            }
            if(isset($pedido_data['pastel'])){
                foreach ($pedido_data['pastel'] as $alteraPastel) {
                    $id_pastel_remove = DB::table('pedido_produtos')->where('pedidosa', $id)->where('pastels', $alteraPastel['idPastel'])->first()->id;
                    DB::table('pedido_produtos')->where('id', $id_pastel_remove)->update(array('quantidade' => $alteraPastel['quantidade']));
                }
            }
            if(isset($pedido_data['removePastel'])){
                foreach ($pedido_data['removePastel'] as $removePastel) {
                    $id_pastel_remove = DB::table('pedido_produtos')->where('pedidosa', $id)->where('pastels', $removePastel['idPastel'])->first()->id;
                    DB::table('pedido_produtos')->where('id', $id_pastel_remove)->update(array('ativo' => '0'));
                }
            }

            return response()->json(['msg' => 'Pedido atualizado com sucesso', 'cod' => '201'], 201);
        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
            }
            return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
        }

        //update em:

        //Mudar cliente
        //adicionar produto ao pedido
        //remover produto do pedido
        //Alterar a quantidade do item desejado



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try{
            $this->pedido->where('id', $id)->update(array('ativo' => '0'));
            return response()->json(['msg' => 'Pedido deletado com sucesso', 'cod' => '201'], 201);
        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
            }
            return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
        }
    }
}
