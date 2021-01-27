@if(session()->has('msg') && session('msg.tipo') != 'alerta') 
<script>
    $.msgbox({
    'message': "{{session('msg.texto')}}",
    'type': "{{session('msg.tipo')}}",
    });
</script>
@elseif(session()->has('msg') && session('msg.tipo') == 'alerta')
<script>
    $.msgbox({
    'message': "{{session('msg.texto')}}",
    });
</script>
@endif
@php
if(session()->has('msg')){
    session()->forget('msg');
}
@endphp