<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria::all();
        if ($categorias->isEmpty()) {
            return response()->json([
                'message' => 'No hay categorias',
                'status' => 404
            ], 404);
        }
        return response()->json($categorias, 200);
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ]);

        if($validator->fails()) {
            $data = [
                'menssage' => 'error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;

        if ($categoria->save()) {
            return response()->json([
                'message' => 'Categoria creada exitosamente',
                'status' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error al crear la categoria',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria::find($id);
        if (!$categoria) {
            return response()->json([
                'message' => 'No existe la categoria',
                'status' => 404
            ], 404);
        }
        return response()->json($categoria, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria){
            $data = [
                'menssage' => 'Categoria no encontrada',
                'status' => 404
            ];
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required'
        ]);

        if($validator->fails()) {
            $data = [
                'menssage' => 'error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $categoria = Categoria::find($id);

        $categoria->nombre = $request->nombre;

        if ($categoria->save()) {
            return response()->json([
                'message' => 'Categoria actualizada exitosamente',
                'status' => 201
            ], 201);
        } else {
            return response()->json([
                'message' => 'Error al actualizar la categoria',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return response()->json([
                'message' => 'Categoria no encontrado',
                'status' => 404
            ], 404);
        }
        if (Categoria::destroy($id)) {
            return response()->json([
                'message' => 'Categoria eliminada exitosamente',
                'status' => 200
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error al eliminar la categoria',
                'status' => 500
            ], 500);
        }

    }
}
