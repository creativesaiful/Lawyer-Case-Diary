@extends('layouts.app')

@section('content')

<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">{{ __('Account Pending Approval') }}</div>
<div class="card-body">
<p>Thank you for registering. Your account is currently pending approval by an administrator. You will be notified once your account is active.</p>
<p>Please check back later.</p>
</div>
</div>
</div>
</div>
</div>
@endsection