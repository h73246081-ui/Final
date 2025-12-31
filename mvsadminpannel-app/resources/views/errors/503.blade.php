<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>503 - Service Unavailable</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="text-center p-4 border rounded shadow-sm bg-white">
        <h1 class="display-4 text-warning">503</h1>
        <h4 class="mb-3">Service Unavailable</h4>
        <p class="text-muted">
            Sorry, the service is temporarily unavailable. Please try again later.
        </p>

        <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
    </div>
</div>

</body>
</html>
