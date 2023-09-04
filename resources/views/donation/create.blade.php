@extends('layout.app')

@section('title', 'Create a donation')

@section('content')
    <form method="POST" action="{{ route('donation.store') }}" novalidate>
        @csrf

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-3">
            <label for="donationValue" class="form-label">
                Donation value in cents of money
            </label>
            <input
                type="number"
                class="form-control @error('value') is-invalid @enderror"
                id="donationValue"
                name="value"
            >
            @error('value')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="donationComment" class="form-label">Comment</label>
            <textarea
                class="form-control @error('comment') is-invalid @enderror"
                id="donationComment"
                rows="5"
                name="comment"
            ></textarea>
            @error('comment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
