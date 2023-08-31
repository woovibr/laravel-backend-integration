@extends('layout.app')

@section('title', 'Show donation')

@section('content')
    <dl>
        <dt>Donation value</dt>
        <dd>{{ $donation->value }}</dd>

        <dt>Donation comment</dt>
        <dd>{{ $donation->comment }}</dd>
    </dl>
@endsection
