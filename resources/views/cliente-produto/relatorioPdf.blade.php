@php
header("Content-type: text/css");
$url = public_path('img/logo.jpg');
$fonte = public_path('fonts/maquina/maquina_regular.otf');
$total = 0;
$objeto = ["id" => 0, "data" => null];

@endphp
<html>
    <head>
        <title>Relatório Mensal</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <style>
        /* @font-face{
            font-family:'FonteMaquina';/*O nome da fonte é obrigatorio colocar com aspas simples*/
            src: url(<?php echo $fonte ?>);
        } */
        .page-break {
            page-break-after: always;
        }
        body{
            background-image: url(<?php echo $url ?>);
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.1;
            /* font-family: FonteMaquina, sans-serif; */
        }
        div.aviso{
            position: relative;
            width: 100%;
            box-sizing: border-box;
            border: 2px dashed red;
        }
        </style>
    </head>
    <body>
            <div class="row">
                <div class="col-md-12">
                    <div class="aviso">
                        <h1 style="text-align:  center">Aviso!</h1>
                        <p>O total acumulado de vendas 'fiado em andamento' não são subtraidas automáticamentes do total acumulado de vendas!</p>
                    </div>
                </div>
            </div>
    
            <table border="" style="width: 100%">
                <tr>
                    <td>
                        <h2 style="color: green; text-align: left">Total(R$): {{$valor_total}}<h2>
                    </td>
                    <td>
                        <h2 style="color: teal; text-align: left">Lucro(R$): {{$valor_lucro}}<h2>
                    </td>
                    <td>
                        <h2 style="color: red; text-align: left">Fiados(R$): {{$valor_fiados_anadamento}}<h2>
                    </td>
                </tr>
            </table>

            <table border="" style="width: 100%; margin: 10px 0">
                <tr>
                    <td style="background-color: red;">
                        <h2 style="color: white; text-align: center">Fiados<h2>
                    </td>
                </tr>
            </table>


            <table border="" style="width: 100%; margin: 10px 0">
                <thead style="background-color: rgba(206, 41, 41, .5); color:white">
                    <tr>
                        <td>Código</td>
                        <td>Nome</td>
                        <td>Quantidade Vendida</td>
                        <td>Valor Unitário(R$)</td>
                        <td>Total(R$)</td>
                        <td>Estado</td>
                        <td>Data da venda</td>
                        <td>Parcelamento</td>
                        <td>Forma Pagamento</td>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @forelse ($vendas_fiados_andamento as $venda)
                    <tr style="border-bottom: 2px solid black">
                        <td>{{$venda->codigo}}</td>
                        <td>{{$venda->nome}}</td>
                        <td style="text-align: center">{{$venda->quantidade_vendida}}</td>
                        @if($venda->nv_vl_unitario > 0)
                        <td>{{$venda->nv_vl_unitario}}</td>
                        <td>{{$venda->nv_vl_unitario * $venda->quantidade_vendida}}</td>
                        @else
                        <td>{{$venda->valor_venda}}</td>
                        <td>{{$venda->valor_venda * $venda->quantidade_vendida}}</td>
                        @endif
                        <td>{{$venda->estado_compra}}</td>
                        <td>{{date('d/m/Y H:i:s', strtotime($venda->created_at))}}</td>
                        <td>{{$venda->parcelamento}}/12</td>
                        <td>{{$venda->forma_pagamento}}</td>
                    </tr>
                    @empty
                        <tr style="border-bottom: 2px solid black">
                            <td colspan="6">Sem fiados em andamento no intervalo de datas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>




            <table border="" style="width: 100%; margin: 10px 0">
                <tr>
                    <td style="background-color: rgba(33, 66, 3,1);">
                        <h2 style="color: white; text-align: center">Vendas<h2>
                    </td>
                </tr>
            </table>


            <table border="" style="width: 100%; margin: 10px 0">
                <thead style="background-color: rgba(33, 66, 3,.5); color:white">
                    <tr>
                        <td>Código</td>
                        <td>Nome</td>
                        <td>Quantidade Vendida</td>
                        <td>Valor Unitário(R$)</td>
                        <td>Total(R$)</td>
                        <td>Estado</td>
                        <td>Data da venda</td>
                        <td>Parcelamento</td>
                        <td>Forma Pagamento</td>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    @forelse ($vendas_separadas as $venda)
                    <tr style="border-bottom: 2px solid black">
                        <td>{{$venda->codigo}}</td>
                        <td>{{$venda->nome}}</td>
                        <td>{{$venda->quantidade_vendida}}</td>
                        @if($venda->nv_vl_unitario > 0)
                        <td>{{$venda->nv_vl_unitario}}</td>
                        <td>{{$venda->nv_vl_unitario * $venda->quantidade_vendida}}</td>
                        @else
                        <td>{{$venda->valor_venda}}</td>
                        <td>{{$venda->valor_venda * $venda->quantidade_vendida}}</td>
                        @endif
                        <td>{{$venda->estado_compra}}</td>
                        <td>{{date('d/m/Y H:i:s', strtotime($venda->created_at))}}</td>
                        <td>{{$venda->parcelamento}}/12</td>
                        <td>{{$venda->forma_pagamento}}</td>
                    </tr>
                    @empty
                        <tr style="border-bottom: 2px solid black">
                            <td colspan="6">Sem lucros no intervalo de datas!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>


            <table  border="" style="width: 100%; margin: 10px 0">
                <thead style="background-color: rgb(193, 193, 193); color: black">
                    <tr>
                        <td>Data de inicio</td>
                        <td>Data de final</td>
                        <td>Intervalo</td>
                        <td>Data de emissão</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{date('d/m/Y', strtotime($data_inicio))}}</td>
                        <td>{{date('d/m/Y', strtotime($data_final))}}</td>
                        @php
                        $data_um = new \Datetime($data_inicio);
                        $data_dois = new \Datetime($data_final);
                        $intervalo = $data_um->diff($data_dois);
                        @endphp
                        {{-- <td>{{ ($intervalo->m == 0) ?1:$intervalo->m}} mês(meses)</td> --}}
                        <td>{{ ($intervalo->m == 0) ?0:$intervalo->m}} mês(meses)</td>
                        {{-- <td>{{ ($intervalo->m + 1)}} mês(meses)</td> --}}
                        <td>{{date('d/m/Y')}}</td>
                    </tr>
                </tbody>
            </table>
    </body>
</html>