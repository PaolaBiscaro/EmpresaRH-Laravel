<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Funcionario;
use App\Models\Departamento;//classe criadas na model

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





#-----------------------------------------------------------
#ROTAS DE FUNCIONARIO

//Rota de cadastrar funcionarios
Route::post('/funcionarios', function (Request $request) {
    $funcionario = new Funcionario();
    $funcionario->nome = $request->input('nome');
    $funcionario->cargo = $request->input('cargo');
    $funcionario->dt_nasc = $request->input('dt_nasc');//YYYY-MM-DD
    $funcionario->departamento_id = $request->input('departamento_id');

    $funcionario->save();
    return response()->json($funcionario);
});


//Rota para buscar todos os funcionarios
Route::get('/funcionarios', function (Request $request) {
    $funcionarios = Funcionario::all();

    return response()->json($funcionarios);
});

//Rota para listar o departamento a qual um funcionario especifico pertence
Route::get('/funcionarios/departamentos/{id}', function ($id) {
    $funcionario = Funcionario::find($id);
    $departamento = $funcionario->departamento;

    return response()->json($departamento);
});


//Rota buscar todos os funcionarios com seus respectivos departamentos
Route::get('/funcionarios/departamentos', function () {
    $funcionarios = Funcionario::with('departamento')->get();
    return response()->json($funcionarios);
});


//Rota para buscar um funcionario especifico
Route::get('/funcionarios/{id}', function ($id){
    $funcionario = Funcionario::find($id);

    return response()->json($funcionario);
});


//Rota para atualizar o funcionario
Route::patch('/funcionarios/{id}', function (Request $request, $id){
    $funcionario = Funcionario::find($id);

    if($request->input('nome') !== null){
        $funcionario->nome = $request->input('nome');
    }

    if($request->input('cargo') !== null){
        $funcionario->cargo = $request->input('cargo');
    }

    if($request->input('dt_nasc') !== null){
        $funcionario->dt_nasc = $request->input('dt_nasc');
    }

    if($request->input('departamento_id') !== null){
        $funcionario->departamento_id = $request->input('departamento_id');
    }

    $funcionario->save();
    return response()->json($funcionario);
});


//Rota para deletar um funcionario
Route::delete('/funcionarios/{id}', function($id){
    $funcionario = Funcionario::find($id);
    $funcionario->delete();

    return response()->json($funcionario);
});




#----------------------------------------------------------
#ROTAS DE DEPARTAMENTOS


//Rota de cadastrar departamentos
Route::post('/departamentos', function (Request $request) {
    $departamento = new Departamento();
    $departamento->nome = $request->input('nome');
    $departamento->descricao = $request->input('descricao');

    $departamento->save();
    return response()->json($departamento);
});


//Rota para buscar todos os departamentos
Route::get('/departamentos', function (Request $request) {
    $departamento = Departamento::all();

    return response()->json($departamento);
});


//Rota para listar os funcionarios que pertencem a um departamento especifico
Route::get('/departamentos/funcionarios/{id}', function ($id) {
    $departamento = Departamento::find($id);
    $funcionario = $departamento->funcionarios;

    return response()->json($funcionario);
});


//Rota para buscar departamentos com seus respectivos funcionarios
Route::get('/departamentos/funcionarios', function () {
    $departamentos = Departamento::with('funcionarios')->get();

    return response()->json($departamentos);
});


//Rota para buscar um departamento especifico
Route::get('/departamentos/{id}', function ($id){
    $departamento = Departamento::find($id);

    return response()->json($departamento);
});


//Rota para atualizar um departamento
Route::patch('/departamentos/{id}', function (Request $request, $id){
    $departamento = Departamento::find($id);

    if($request->input('nome') !== null){
        $departamento->nome = $request->input('nome');
    }

    if($request->input('descricao') !== null){
        $departamento->descricao = $request->input('descricao');
    }

    $departamento->save();
    return response()->json($departamento);
});


//Rota para deletar um departamento
Route::delete('/departamentos/{id}', function( $id){
    $departamento = Departamento::find($id);
    $departamento->funcionarios()->update(['departamento_id'=>null]);
    $departamento->delete();

    return response()->json($departamento);
});



