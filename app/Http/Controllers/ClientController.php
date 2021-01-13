<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    public function index()
    {
        $data = ['data' =>$this->client->where('ativo', true)->get()];
        return response()->json($data);
    }

    public function show($id)
    {
        $data = ['data' =>$this->client->where('id', $id)->where('ativo', true)->get()];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required',
            'email'=>[
                'required',
                'unique:clients',
            ],
            'telefone'=>'required'
        ]);
        try{
            $clientData = $request->all();
            $this->client->create($clientData);
            return response()->json(['msg' => 'Cliente criado com sucesso', 'cod' => '201'], 201);

        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['error'=> $e->getMessage(), 'codigo'=> '1010']);
            }
            return response()->json(['error'=> 'Erro ao realizar a operação', 'codigo'=> '1010']);
        }
    }

    public function update(Request $request, $id)
    {

        try{
            $client_data = $request->all();
            $client = $this->client->find($id);
            $client->update($client_data);
            return response()->json(['msg' => 'Cliente atualizado com sucesso', 'cod' => '201'], 201);
        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
            }
            return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
        }
    }

    public function delete($id)
    {
        try{
            $this->client->where('id', $id)->update(array('ativo' => '0'));
            return response()->json(['msg' => 'Cliente deletado com sucesso', 'cod' => '201'], 201);
        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
            }
            return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
        }
    }
}
