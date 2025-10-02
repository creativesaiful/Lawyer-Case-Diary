<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lawyer Case Diary</title>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

 

</head>

<body>

 



        <div class="container-fluid">
            <div id="page-content-wrapper" class="flex-grow-1">
                @include('layouts.navbar')


            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Account Pending Approval') }}</div>
                        <div class="card-body">
                            <p>Thank you for registering. Your account is currently pending approval by an
                                administrator. You will be notified once your account is active.</p>
                            <p>Please check back later.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>
