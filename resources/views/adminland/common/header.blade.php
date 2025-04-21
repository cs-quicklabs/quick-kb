<nav class="bg-white border-gray-200 dark:bg-gray-900">
	<div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
		<a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
			<!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" /> -->
			<span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
				>{{getKnowledgeBase()}}</span>
		</a>
		<div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
			<button
				type="button"
				class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
				id="user-menu-button"
				aria-expanded="false"
				data-dropdown-toggle="user-dropdown"
				data-dropdown-placement="bottom">
				<span class="sr-only">Open user menu</span>
				<img
					class="w-8 h-8 rounded-full"
					src="{{ asset('/images/profile_image.jpg') }}"
					alt="user photo" />
			</button>
			<!-- Dropdown menu -->
			<div
				class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm border dark:bg-gray-700 dark:divide-gray-600"
				id="user-dropdown">
				<div class="px-4 py-3">
					@if(Auth::check())
						<span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
						<span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
					@else
						<span class="block text-sm text-gray-900 dark:text-white">Guest</span>
						<span class="block text-sm text-gray-500 truncate dark:text-gray-400">guest@example.com</span>
					@endif
				</div>
				<ul class="py-2" aria-labelledby="user-menu-button">
					<li>
						<a
							href="{{route('adminland.changepassword')}}"
							class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
							>Admin Land</a>
					</li>

					<li>
						<a
							href="{{ route('logout') }}"
							class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
							>Sign out</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>