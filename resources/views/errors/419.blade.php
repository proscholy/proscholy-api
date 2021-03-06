@extends('errors::layout')

@section('code', '419')
@section('title-suffixed', 'Stránka už neplatí')
@section('error-description')
	<p>Omlouváme se, vaše relace vypršela.<br> Zkuste obnovit stránku.</p>
	<a href="/" class="btn btn-secondary mr-2">
        <i class="fas fa-home pr-1"></i> DOMŮ
    </a>
@endsection
