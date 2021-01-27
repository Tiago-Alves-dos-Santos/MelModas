@if(isset($bootstrap) == false || $bootstrap == true)
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap/css/bootstrap.css')}}"/>
@endif
<script src="https://kit.fontawesome.com/100dc002c3.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="{{asset('plugins/alert/msgbox.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}"/>
<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('plugins/ckeditor/ckeditor.js')}}" charset="utf-8"></script>
<script>

</script>    
{{$slot}}