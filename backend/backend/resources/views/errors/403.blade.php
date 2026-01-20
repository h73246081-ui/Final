<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 - Unauthorized</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="text-center p-4 border rounded shadow-sm bg-white">
        <h1 class="display-4 text-danger">403</h1>
        <h4 class="mb-3">Unauthorized</h4>
        <p class="text-muted">
            You are not allowed to access this page.
        </p>

        <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Go Back</a>
        <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
    </div>
</div>

</body>
</html>
