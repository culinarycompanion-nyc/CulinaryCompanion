<!doctype html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset("assets/favicon.png") }}">
    <title>Culinary Companion</title>
    @vite(['resources/css/app.css'])
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    @vite(['resources/js/app.js'])
</head>

<body class="h-full w-full">
    {{ $slot }}
</body>

</html>