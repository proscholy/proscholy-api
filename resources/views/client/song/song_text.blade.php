@extends('layout.layout')

@section('navbar')
    @include('client.components.menu_song')
@endsection

@section('content')
    <div class="content-padding">
        <div class="row">
            <div class="col-sm-8">
                <h1>{{$song_l->name}}</h1>

                <div class="card">
                    <div class="card-body">
                        <p>@component('client.components.song_lyric_author',['song_l' => $song_l])@endcomponent</p>
                        <hr>

                        <div id="lyrics">
                            {!! nl2br($song_l->lyrics) !!}
                        </div>

                        <hr>
                        Zpěvník ProScholy.cz <img src="{{asset('img/logo_v2.png')}}" width="20px"> {{date('Y')}}
                    </div>
                </div>
            </div>
            <div class="col-sm-4 content-padding-top">
                @if($song_l->description)
                    <div class="card">
                        <div class="card-header">Informace o písni</div>
                        <div class="card-body">
                            <b>Autor</b>
                        </div>
                    </div>
                @endif

                @if($song_l->youtubeVideos()->count() > 0)
                    @component('client.components.external_embed', ['external' => $song_l->youtubeVideos()->first()])@endcomponent
                @endif
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    @include('scripts.chordpro_parse')

    <script>
        $(document).ready(function () {
            let lyrics = document.getElementById('lyrics');
            let lyrics_source = document.getElementById('lyrics').innerHTML;

            lyrics.innerHTML = parseChordPro(lyrics_source, 0);
        });
    </script>
@endsection