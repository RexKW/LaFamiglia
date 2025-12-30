<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LaFamiglia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body  class="font-mono text-white flex flex-col relative items-center justify-center">
    {{-- <x-navBar /> --}}

    <div id="loader" class="z-0 fixed top-0 w-screen h-screen">
        </div>
    <div class="flex relative z-10 flex-col w-full min-h-screen items-center justify-center p-4">

        {{ $slot }}
    </div>

</body>
<script src="/js/balatroShader.js"></script>
<script>
        const fx = new BalatroShader({
            container: "#loader",
            colours: { c1: "#DE443B", c2: "#006BB4", c3: "#162325" },
            speed: 1.4,
            contrast: 2,
            spinAmount: 0.5,
            pixelSizeFac: 1000,
            spinEase: 0.5
        });
    </script>
</html>
