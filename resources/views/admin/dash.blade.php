@extends('layout')

@section('content')

    <h1>Administrace</h1>


    <h2>Písně</h2>
    <a class="btn btn-outline-primary" href="{{route('admin.song.new')}}">+ Nová píseň</a>

    <h2>Překlady</h2>

    <h2>Autoři</h2>

    <h2>Videa</h2>
    <a class="btn btn-outline-primary" href="{{route('admin.video.new')}}">+ Nové video</a>
    <a class="btn btn-outline-primary" href="{{route('admin.videos')}}">Spravovat videa</a>

@endsection
