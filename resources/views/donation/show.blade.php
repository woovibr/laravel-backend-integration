@extends('layout.app')

@section('title', 'Show donation')

@section('content')
    <a class="btn-link btn-primary" href="{{ route('donation.index') }}">List of donations</a>

    <dl>
        <dt>Donation value</dt>
        <dd>{{ $donation->value }}</dd>

        <dt>Donation comment</dt>
        <dd>{{ $donation->comment }}</dd>

        <dt>Donation status</dt>
        <dd>{{ $donation->status }}</dd>
    </dl>

    <div class="woovi-order"></div>
@endsection

@push('scripts')
    @if (env('OPENPIX_JS_PLUGIN_URL'))
        <script src="{{ env('OPENPIX_JS_PLUGIN_URL') }}?appID={{ env('OPENPIX_APP_ID') }}&correlationID={{ $donation->correlationID }}"></script>
    @endif
@endpush
