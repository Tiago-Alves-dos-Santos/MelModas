<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('inicio');

Route::group( [ 'prefix' => 'admin' ], function()
{
    //tela principal admin
    Route::get('/dashboard', 'Controller\UsuarioC@viewDashboard')->name('admin.view.dashboard');
    //logout
    Route::get('/logout/{validate}', 'Controller\UsuarioC@logout')->name('admin.logout');
    //login
    Route::post('/login', 'Controller\UsuarioC@login')->name('admin.login');
});
Route::group( [ 'prefix' => 'admin/cliente' ], function()
{
    //ver clientes(dashboard)
    Route::get('/', 'Controller\ClienteC@viewPrincipal')->name('cliente.view.principal');
    //requisião ajax filtrar clientes
    Route::any('/filtrar-cliente', 'Controller\ClienteC@filtrar')->name('cliente.ajax.filtro');
    //alterar cliente view
    Route::get('/alterar-cliente/{id}/{url}', 'Controller\ClienteC@viewAlterar')->name('cliente.view.alterar');
    //alterar cliente
    Route::post('/alterar','Controller\ClienteC@alterar')->name('cliente.alterar');
    //tela principal admin
    Route::get('/cadastro', 'Controller\ClienteC@viewCadastro')->name('cliente.view.cadastro');
    //cadastrar cliente
    Route::post('/cadastrar', 'Controller\ClienteC@create')->name('cliente.create');
    //requisição ajax para verificar nome do cliente
    Route::post('/verficar-cliente','Controller\ClienteC@verficarExistencias')->name('cliente.ajax.verficar');
    //requisição ajax para listar telfones de um cliente especifico
    Route::post('/listar-telefones','Controller\ClienteC@listarTelefones')->name('cliente.ajax.listarTelfones');
    //requisição ajax para retornar um cliente a paritr do id
    Route::post('/getCliente','Controller\ClienteC@getCliente')->name('cliente.ajax.getCliente');
    //requisição ajax para adcionar um novo numero ao cliente
    Route::post('/addTelefone', 'Controller\ClienteC@addTelefone')->name('cliente.ajax.addTelefone');
    //requisição para deletar telefone de cliente
    Route::post('/deletarTelefone', 'Controller\ClienteC@deletarTelefone')->name('cliente.ajax.deletarTelefone');
    //deletar cliente
    Route::post('/delete', 'Controller\ClienteC@delete')->name('cliente.delete');

});


// Route::get('/iniciar', function () {
//     App\Model\Usuario::create([
//         "nome" => "Tiago",
//         "email" => "tiagoalves@email.com",
//         "senha" => "melmodas"
//     ]);
// });
