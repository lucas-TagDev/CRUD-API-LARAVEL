<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
 
use App\Models\Orcamento;
 
use Validator;

class OrcamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Orcamento::all();
     
        return response()->json(
            /*"success" => true,
            "message" => "Lista de orcamentos",
            "data" => $products*/
            $products
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
    
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required',
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        //Upload Imagem
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();                    
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $input['image'] = $name;
        }

        /*
        $uploadFolder = 'users';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageResponse = array(
            "image_name" => basename($image_uploaded_path),
            "image_url" => Storage::disk('public')->url($image_uploaded_path),
            "mime" => $image->getClientMimeType()
        );
        */
    
        $product = Orcamento::create($input);
 
        return response()->json([
            "success" => true,
            "message" => "Orcamento criado.",
            "data" => $product
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Orcamento::find($id);
   
        if (is_null($product)) {
            return $this->sendError('Orcamento nao encontrado.');
        }
         
        return response()->json([
            "success" => true,
            "message" => "Orcamento recuperado com sucesso",
            "data" => $product
        ]);
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function atualizar(Request $request)
    {
        $input = $request->all();
        
    
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required',
        ]);
    
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        //Upload Imagem
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = $image->getClientOriginalName();                    
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
            $input['image'] = $name;
            
            
            $product = Orcamento::find($request->id);
    
            $product->name = $input['name'];
            $product->detail = $input['detail'];
            $product->image = $input['image'];
            
            $product->save();
        
            return response()->json([
                "success" => true,
                "message" => "Orcamento atualizado.",
                "data" => $product
            ]);

        }

            $product = Orcamento::find($request->id);
    
            $product->name = $input['name'];
            $product->detail = $input['detail'];
            
            $product->save();
        
            return response()->json([
                "success" => true,
                "message" => "Orcamento atualizado.",
                "data" => $product
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Orcamento::find($id);
        $product->delete();
    
        return response()->json([
            "success" => true,
            "message" => "Orcamento deletado.",
            "data" => $product
        ]);
    }
}
