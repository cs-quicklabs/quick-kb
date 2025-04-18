<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="../../favicon.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script> -->
    <meta name="viewport" content="width=device-width" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body data-sveltekit-preload-dataaa="hover">
    <div style="display: contents"><!--[--><!--[--><!----><!---->
        <section class="bg-white dark:bg-gray-900">
            <div class="w-full h-56 bg-{{$color}}-100 px-4 mx-auto lg:px-6 shadow-sm">
                
                @include('layouts.banner')

                
            </div>

            @yield('content')

        </section>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>

</html>