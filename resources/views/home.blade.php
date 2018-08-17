@extends('layout')

@section('content')



    <div class="row">
        <div class="col-sm-4">
            <h4>Nejnavštěvovanější písně</h4>
            @foreach($top_songs as $song)
                @if(isset($song->song_id))
                    <a href="{{route('translation.single', ['id'=> $song->id])}}">{{$song->name}}</a>
                    ({{$song->visits}}x)<br>
                @else
                    <a href="{{route('song.single', ['id'=> $song->id])}}">{{$song->name}}</a> ({{$song->visits}}x)<br>
                @endif
            @endforeach
        </div>
        <div class="col-sm-4">
            <h3>Rejstřík</h3>

            <a class="btn btn-primary" style="width: 100%; margin-bottom:10px;" href="{{route('song.list')}}">Abecední
                seznam písní</a><br>
            <a class="btn btn-primary" style="width: 100%; margin-bottom:10px;" href="{{route('author.list')}}">Seznam
                autorů</a>

            <h4>Zpěvník v počtech</h4>

            <p>Písně: <b>{{$songs}} <i class="fas fa-music"></i></b></p>
            <p>Překlady: <b>{{$translations}} <i class="fas fa-language"></i></b></p>
            <p>Autoři: <b>{{$authors}} <i class="fas fa-user"></i></b></p>
            <p>Videa: <b>{{$videos}} <i class="fas fa-video"></i></b></p>

            {{--<a class="btn btn-primary" style="width: 100%; margin-bottom:10px;" href="{{route('author.list')}}">--}}
                {{--Něco mi tu chybí!</a>--}}
        </div>
        <div class="col-sm-4">
            <h4>Nejnavštěvovanější autoři</h4>
            @foreach($top_authors as $author)
                <a href="{{route('author.single', ['id'=> $author->id])}}">{{$author->name}}</a> ({{$author->visits}}x)
                <br>
            @endforeach
        </div>

    </div>

@endsection
