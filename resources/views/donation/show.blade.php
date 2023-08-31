@extends('layout.app')

@section('title', 'Show donation')

@section('content')
    <dl>
        <dt>Donation value</dt>
        <dd>{{ $donation->value }}</dd>

        <dt>Donation comment</dt>
        <dd>{{ $donation->comment }}</dd>
    </dl>

    <div class="woovi-order"></div>
@endsection

@push('scripts')
    @if (env('OPENPIX_JS_PLUGIN_URL'))
        <script src="{{ env('OPENPIX_JS_PLUGIN_URL') }}?appID={{ env('OPENPIX_APP_ID') }}&correlationID={{ $donation->correlationID }}"></script>
    @endif
@endpush
