<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Application</title>
    
    <!-- App CSS -->
    <link href="{{ asset('/assets/css/app.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    @stack('styles')
</head>
<body>
    <h2>Hello world</h2>
    @stack('scripts')
</body>
</html>