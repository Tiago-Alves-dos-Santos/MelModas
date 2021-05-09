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
Route::get('/', 'Controller\UsuarioC@viewLogin')->name('inicio');

Route::group( [ 'prefix' => 'admin' ], function()
{
    //tela principal admin
    Route::get('/dashboard', 'Controller\UsuarioC@viewDashboard')->name('admin.view.dashboard');
    //logout
    Route::get('/logout/{validate}', 'Controller\UsuarioC@logout')->name('admin.logout');
    //login
    Route::post('/login', 'Controller\UsuarioC@login')->name('admin.login');
    //view config
    Route::get('/config', 'Controller\UsuarioC@viewConfig')->name('admin.view.config');
    //view create
    Route::get('/view-create', 'Controller\UsuarioC@viewCreate')->name('admin.view.create');
    //criar usuario
    Route::post('/create', 'Controller\UsuarioC@create')->name('admin.create');
    //deletar
    Route::delete('/deletar', 'Controller\UsuarioC@delete')->name('admin.delete');
});

Route::group( [ 'prefix' => 'admin/peso' ], function()
{
    //tela configuração de peso
    Route::get('/', 'Controller\PesoVendaC@viewIndex')->name('peso.view.index');
    //cadastrar ou alterar configuração peso
    Route::post('/create', 'Controller\PesoVendaC@create')->name('peso.create');
    //relizar revisao do peso, alterar o peso
    Route::put('/revisao-peso', 'Controller\PesoVendaC@revisarPeso')->name('peso.ajax.revisarPeso');
    //verficar se peso esta em uma quantidade alertiva
    Route::get('/alerta-peso', 'Controller\PesoVendaC@alertaPeso')->name('peso.ajax.alert');
});

Route::group( [ 'prefix' => 'admin/caixa' ], function()
{
    //tela inicial caixa
    Route::get('/', 'Controller\CaixaC@viewIndex')->name('caixa.view.index');
    //abrir caixa
    Route::post('/abrir', 'Controller\CaixaC@open')->name('caixa.abrir');
    //fechar caixa
    Route::post('/fechar', 'Controller\CaixaC@close')->name('caixa.close');
    //reabrir caixa
    Route::post('/reabrir', 'Controller\CaixaC@reOpen')->name('caixa.reOpen');
    //deletar caixa
    Route::post('/deletar', 'Controller\CaixaC@delete')->name('caixa.delete');
    //verficar
    Route::get('/check', 'Controller\CaixaC@check')->name('caixa.check');

});

Route::group( [ 'prefix' => 'admin/depositos' ], function()
{
    //tela configuração de peso
    Route::get('/', 'Controller\DepositoC@viewIndex')->name('deposito.view.index');
    //adcionar despesa
    Route::get('/cadastrar-depositos','Controller\DepositoC@viewCadastrar')->name('deposito.view.create');
    //cadastrar
    Route::post('/create', 'Controller\DepositoC@create')->name('deposito.create');
    //deletar
    Route::delete('/delete', 'Controller\DepositoC@delete')->name('deposito.delete');
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
    //listar telefones de cliente na hora de selecionar
    Route::get('/getTelefonesLista/{id}', 'Controller\ClienteC@getTelefonesLista')->name('cliente.getTelefonesLista');
    //view Aniversarios
    Route::get('/viewAniversarios', 'Controller\ClienteC@viewAniversarios')->name('cliente.view.viewAniversarios');
    //coutn aniversariantes do mês(dia)
    Route::get('/aniversariantesCount', 'Controller\ClienteC@aniversariantesCount')->name('cliente.ajax.aniversariantes');
    //count aniversariantes do dia
    Route::get('/aniversariantesDayCount', 'Controller\ClienteC@aniversariantesDayCount')->name('cliente.ajax.aniversariantesDay');
});

Route::group( [ 'prefix' => 'admin/produto' ], function()
{
    //tela principal produto
    Route::get('/','Controller\ProdutoC@viewPrincipal')->name('produto.view.principal');
    //view cadastro produto
    Route::get('/cadastro', 'Controller\ProdutoC@viewCadastro')->name('produto.view.cadastro');
    //view alteração
    Route::get('/alterar/{id}/{url}', 'Controller\ProdutoC@viewAlterar')->name('produto.view.alterar');
    //ajax verificar se vai adicionar ou cadastrar produto
    Route::post('/verficar-produto', 'Controller\ProdutoC@cadastrarAtualizar')->name('produto.ajax.cadastrarAtualizar');
    //ajax cadastrar produto
    Route::post('/cadastrar', 'Controller\ProdutoC@create')->name('produto.ajax.create');
    //alterar produto
    Route::post('/alterar', 'Controller\ProdutoC@alterar')->name('produto.alterar');
    //ajax adicionar produto - adicionar quantidade
    Route::post('/adicionar-produto', 'Controller\ProdutoC@adicionarQuantidade')->name('produto.ajax.addQuantidade');
    //ajax retorna apenas um objeto produto
    Route::post('/getProduto', 'Controller\ProdutoC@getProduto')->name('produto.ajax.getProduto');
    //ajax filtrar produto
    Route::any('/filtrar', 'Controller\ProdutoC@filtro')->name('produto.ajax.filtrar');
    //ajax verficar codigo existente do produto
    Route::post('/verificar-codigo', 'Controller\ProdutoC@verificarCodigo')->name('produto.ajax.verficarCodigo');
    //deletar produto
    Route::post('/deletar', 'Controller\ProdutoC@delete')->name('produto.ajax.delete');
});

Route::group( [ 'prefix' => 'admin/venda' ], function()
{
    //tela de efetuar venda
    Route::get('/vender', 'Controller\ClienteProdutoC@viewVenda')->name('venda.view.venda');
    //retorna cliente buscado para selecionar em uma operação de venda
    Route::any('/listar-clientes', 'Controller\ClienteProdutoC@getClientesSelect')->name('venda.ajax.getClientesSelect');
    //adicionar produto a tabela de venda
    Route::post('/addProduto', 'Controller\ClienteProdutoC@addProduto')->name('venda.ajax.addProduto');
    //vender
    Route::post('/vender', 'Controller\ClienteProdutoC@vender')->name('venda.ajax.vender');
    //verficar se cliente tem promocao
    Route::post('/verficarPromocao', 'Controller\ClientePromocaoC@verficarPromocao')->name('venda.ajax.verficarPromocao');
    //ver vendas realizadas
    Route::any('/viewVendas', 'Controller\ClienteProdutoC@viewVendas')->name('venda.view.viewVendas');
    //ver vendas realizadas filtro
    Route::any('/viewVendas/filtro', 'Controller\ClienteProdutoC@filtrar')->name('venda.ajax.filtrar');
    //listar Produtos
    Route::get('/listarProdutos/{data}/{id?}', 'Controller\ClienteProdutoC@listarProdutos')->name('venda.listarProdutos');
    //emitir comprovante de venda
    Route::get('/comprovanteVenda/{id}/{nome}/{data}', 'Controller\ClienteProdutoC@comprovanteVenda')->name('venda.comprovanteVenda');
    //venda nunca ocorridas
    Route::post('/resetarVenda', 'Controller\ClienteProdutoC@resetarVenda')->name('venda.ajax.resetarVenda');
    //concluir venda fiado que esta em andamento
    Route::post('/concluirVenda', 'Controller\ClienteProdutoC@concluirVenda')->name('venda.ajax.concluirVenda');
});
Route::group( [ 'prefix' => 'admin/promocao' ], function()
{
    //view principal promocao
    Route::get('/', 'Controller\PromocaoC@viewPrincipal')->name('promocao.view.principal');
    //calcular valor total obitdo(por compra) por um cliente durante o mes
    Route::get('/valorTotalMes', 'Controller\PromocaoC@valorTotalMes')->name('promocao.ajax.valorTotalMes');
    //view Editar promoção
    Route::get('/viewEditar', 'Controller\PromocaoC@viewEditar')->name('promocao.ajax.viewEditar');
    //alterar promocao
    Route::post('/alterar', 'Controller\PromocaoC@alterar')->name('promocao.alterar');
});
Route::group( [ 'prefix' => 'admin/relatorio' ], function()
{
    Route::get('/', 'Controller\RelatorioC@viewRelatorio')->name('relatorio.inicio');
    Route::post('/emitirRelatorio', 'Controller\RelatorioC@emitirRelatorio')->name('relatorio.emitirRelatorio');
});
Route::group( [ 'prefix' => 'admin/rotinas' ], function()
{
    Route::get('/vendasConcluidas', 'Controller\RotinasC@vendasConcluidas')->name('rotinas.ajax.vendasConcluidas');
});
//iniciar sistema
// Route::get('/iniciar', function () {
//     App\Model\Usuario::create([
//         "nome" => "Tiago",
//         "email" => "tiagoalves@email.com",
//         "senha" => "melmodas"
//     ]);
// });
// Route::get('/promocao', function () {
//     App\Model\Promocao::create([
//         "valor_atingir" => 4300,
//         "desconto_porcento" => 10
//     ]);
// });
// Route::get('/teste', function () {
//     $localIP = getHostByName(getHostName());
//     echo $localIP;
// });
