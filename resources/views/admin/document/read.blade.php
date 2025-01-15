@extends('admin.admin_layout')
@section('admin_content')

<style>
    ul.drive{
        padding: 10px;
    }
    ul.drive li{
        color: #000;
        margin: 2px 0;
        font-weight: 300;
        list-style: none;
    }
</style>
 
<div class="row">
    <ul class="drive">
        @foreach ($contents as $key => $value)
        <li>Name : {{$value['name']}}</li>
        <li>Path : {{$value['path']}}</li>
        <li>Basename : {{$value['basename']}}</li>
        <li>Mimetype : {{$value['mimetype']}}</li>
        <li>Type: : {{$value['type']}}</li>
        <li>Size : {{$value['size']}}</li>

        <li>Download file cách 1: <a href="https://drive.google.com/file/d/{{$value['path']}}/view" target="_blank">Tải</a></li>

        <li>Delete : <a href="{{url('delete_document',['path'=>$value['path']])}}">Delete</a></li>

        <li><iframe src="https://drive.google.com/file/d/{{$value['path']}}/preview" target="_blank"></iframe></li>
        @endforeach
    </ul>
</div>

@endsection
