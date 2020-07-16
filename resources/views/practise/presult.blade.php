@foreach($data as $value)
<ul>
    <li>{{$value->id}}</li>
    <li>{{$value->name}}</li>
</ul>
   @endforeach

  

{!! $data->render() !!}