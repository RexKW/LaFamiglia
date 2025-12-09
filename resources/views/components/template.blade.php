<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaFamiglia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-white flex flex-col items-center justify-center">
    <x-navBar />
    <div class="flex  flex-col w-full min-h-screen items-center justify-center mt-8 mb-8 p-4">
        {{ $slot }}
    </div>
    
</body>
</html>
