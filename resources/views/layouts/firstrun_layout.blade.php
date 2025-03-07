
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="utf-8" />
	<link rel="icon" href="../../favicon.png" />
	
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
	<meta name="viewport" content="width=device-width" />
	
        @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body data-sveltekit-preload-data="hover">
	<div style="display: contents">  
			
			<section class="bg-gray-50 dark:bg-gray-900">
				<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
					<a
						href="/quick-kb"
						class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
						<!-- <img
							class="w-8 h-8 mr-2"
							src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg"
							alt="logo" /> -->
						Quick KB
					</a>

					@yield('content')
				</div>
			</section>
    </div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>

</html>