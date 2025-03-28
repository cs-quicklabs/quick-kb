<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="../../favicon.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
    <meta name="viewport" content="width=device-width" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .ql-container.ql-snow {
            border: none !important;
        }
    </style>
</head>

<body data-sveltekit-preload-data="hover">
    <div style="display: contents">
        <div class="w-full">
            @yield('content')
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>

</html>