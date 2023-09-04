@extends('layout.app')

@section('title', 'List of donations')

@section('content')
    <a class="btn-link btn-primary" href="{{ route('donation.create') }}">Create donation</a>

    <table class="table">
        <thead>
            <th scope="col">Correlation ID</th>
            <th scope="col">Status</th>
            <th scope="col">Value</th>
            <th scope="col">Comment</th>
            <th scope="col">Actions</th>
        </thead>
        <tbody>
            @foreach ($donations as $donation)
                <tr>
                    <th scope="row">{{ $donation->correlationID }}</th>
                    <td>{{ $donation->status }}</td>
                    <td>{{ $donation->value }}</td>
                    <td>{{ $donation->comment }}</td>
                    <td>
                        <a href="{{ route('donation.show', [$donation]) }}">
                            View donation
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection