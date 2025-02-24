
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" href="../../favicon.png" />
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/datepicker.min.js"></script>
	<meta name="viewport" content="width=device-width" />
	
		<!-- <link href="../../_app/immutable/assets/0.B0WjZmEn.css" rel="stylesheet"> -->
        @vite('resources/css/app.css')
</head>

<body data-sveltekit-preload-data="hover">
	<div style="display: contents"><!--[--><!--[--><!----><!---->
        @include('adminland.common.header')
        <main class="max-w-7xl mx-auto pb-10 lg:py-8 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                @include('adminland.common.sidebar')
                
                <!----> 
                
                @yield('content')
            </div>
        </main>
			
    </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>

</html>