<?php

namespace App\Http\Controllers;

use App\Models\Pastel;
use Illuminate\Http\Request;

class PastelController extends Controller
{

    public function __construct(Pastel $pastel)
    {
        $this->pastel = $pastel;
    }


    public function index()
    {
        $data = ['data' =>$this->pastel->where('ativo', true)->get()];
        return response()->json($data);
    }

    public function show($id)
    {
        $data = ['data' =>$this->pastel->where('id', $id)->where('ativo', true)->get()];
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'=>'required',
            'photo'=>'required',
            'preco'=>'required'
        ]);
        $pastelData = $request->all();
        $image = $request->file('photo');

        try{
            if($image){
                $ext = $image->extension();
                $allowedMimeTypes = ['jpeg','gif','png','bmp','svg+xml', 'jpg'];
                //$contentType = mime_content_type(storage_path().$path);

                if(in_array($ext, $allowedMimeTypes) ){
                    $path = $image->store('images', 'public');
                    $pastelData = array_merge($request->all(), ['foto' => $path]);
                    $this->pastel->create($pastelData);
                    return response()->json(['msg' => 'Pastel criado com sucesso', 'cod' => '201'], 201);
                }


            }
            return response()->json(['msg' => 'Invalid Image', 'cod' => '502'], 500);
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
            $pastel_data = $request->all();
            $pastel = $this->pastel->find($id);
            $pastel->update($pastel_data);
            return response()->json(['msg' => 'Pastel atualizado com sucesso', 'cod' => '201'], 201);
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
            $this->pastel->where('id', $id)->update(array('ativo' => '0'));
            return response()->json(['msg' => 'Pastel deletado com sucesso', 'cod' => '201'], 201);
        } catch(\Exception $e){
            if(config('app.debug')){
                return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
            }
            return response()->json(['msg' => 'Erro ao realizar a operação', 'cod' => '1010']);
        }
    }

}
