<!-- resources/views/payment.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Payment Form</h2>
        <form action="{{ route('payment.process') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter amount">
            </div>
            <button type="submit" class="btn btn-primary">Pay with PayPal</button>
        </form>
    </div>
@endsection
