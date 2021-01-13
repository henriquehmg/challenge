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

            $itens = $retorno->itensPedido()->get();
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

        //requisitos
        // id_cliente
        // pastel[
            // quantidade
            // id_pastel
        // ]

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

            //Enviar email para o cliente






        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['error'=> $e->getMessage(), 'codigo'=> '1010']);
            }
            return response()->json(['error'=> 'Erro ao realizar a operação', 'codigo'=> '1010']);
        }


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
                //Para pegar a nomeclatura do Pastel.
                //

                //Gerar um Json com todos os itens
            }
            $jsonPedido = ['id'=>$retorno->id, 'criado_em'=>$retorno->created_at, 'cliente'=>$cliente, 'itens'=> $produtos];
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

            $itens = $retorno->itensPedido()->get();
            $produtos = array();
            foreach($itens as $item){
                //Pega a lista de todos os itens
                $pastelGet = $item->pastelTipo()->first();
                $insereArray = ['quantidade'=>$item->quantidade, 'pastel'=>$pastelGet];
                array_push($produtos, $insereArray);
                //Para pegar a nomeclatura do Pastel.
                //

                //Gerar um Json com todos os itens
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

    private function sendMail($idPedido)
    {
        $message = $this->show($idPedido);

        // MailableMail::send('','', function ($message) {
        //     $message->from('john@johndoe.com', 'John Doe');
        //     $message->sender('john@johndoe.com', 'John Doe');
        //     $message->to('john@johndoe.com', 'John Doe');
        //     $message->subject('Pedido realizado');
        //     $message->priority(3);
        // });
    }
}
