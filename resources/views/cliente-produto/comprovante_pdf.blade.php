@php
header("Content-type: text/css");
$url = public_path('img/logo.jpg');
$total = 0;
$objeto = ["id" => 0, "data" => null];
@endphp
<html>
    <head>
        <title>Comprovante de Venda</title>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <style>
        .page-break {
            page-break-after: always;
        }
        
        body{
            background-image: url(<?php echo $url ?>);
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.3;
        }
        div#fundo{
            position: absolute;
            left:25%;
            top:25%;
            opacity: 0.2;
            z-index: -34;
        }
        .font-pixel{
            font-size: 15px;
        }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="text-align: center;">R&R</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5>@php echo str_repeat("=", 25) @endphp</h5>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-12">
                    <h5 style="text-align: center">Produtos</h5>
                </div>
            </div> --}}
            {{-- <div class="row">
                <div class="col-md-12">
                    <h5>@php echo str_repeat("=", 19) @endphp</h5>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                        <h5 class="font-pixel">Código // Nome // quantidade * valor = total</h5>
                        <h5>@php echo str_repeat("*", 20) @endphp</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @forelse ($vendas as $item)
                        @php
                        $objeto["id"] = $item->id;
                        $objeto["data"] = $item->created_at;
                        @endphp
                        <h5 class="font-pixel">{{$item->codigo}} // {{$item->nome}} // {{$item->quantidade_vendida}} * {{$item->valor_venda}} = {{ ($item->quantidade_vendida * $item->valor_venda) }}</h5>
                        @php
                        $total += ($item->quantidade_vendida * $item->valor_venda);
                        @endphp
                        <h5>@php echo str_repeat("-", 35) @endphp</h5>
                    @empty
                        <h5></h5>
                    @endforelse
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                        <h2 style="font-size: 23px">Total: R$ {{$total}}</h2>
                        <h4>@php echo str_repeat("*", 20) @endphp</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                        <h5 style="font-size: 18px">Data da Venda: {{date('d/m/Y H:i:s', strtotime($objeto["data"]))}}</h5>
                        <h5 style="font-size: 18px">Data de Emissão: {{date('d/m/Y H:i:s')}}</h5>
                        <h5 style="font-size: 18px">Comprovante em razão do cliente: {{$cliente->nome}}</h5>
                        {{-- <h4>@php echo str_repeat("*", 20) @endphp</h4> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                        @php
                            $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                            $id = $objeto["id"];
                            echo $generator->getBarcode("$id", $generator::TYPE_CODE_128);
                        @endphp
                </div>
            </div>
        </div>
    </body>
</html>