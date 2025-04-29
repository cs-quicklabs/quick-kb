<aside class="px-2 py-6 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
	<nav class="space-y-1">
		<a
			href="{{route('adminland.settings')}}"
			class=" {{ request()->routeIs('adminland.settings') ? 'bg-gray-200 hover:bg-gray-200' : 'hover:bg-gray-50'}}  text-gray-900  rounded px-3 py-2 flex items-center text-sm font-medium">
			<svg 
				class="w-6 h-6 text-gray-800 dark:text-white" 
				aria-hidden="true" 
				xmlns="http://www.w3.org/2000/svg" 
				width="24" 
				height="24" 
				fill="none" 
				viewBox="0 0 24 24">
				<path 
					stroke="currentColor" 
					stroke-linecap="round" 
					stroke-linejoin="round" 
					stroke-width="2" 
					d="M21 13v-2a1 1 0 0 0-1-1h-.757l-.707-1.707.535-.536a1 1 0 0 0 0-1.414l-1.414-1.414a1 1 0 0 0-1.414 0l-.536.535L14 4.757V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v.757l-1.707.707-.536-.535a1 1 0 0 0-1.414 0L4.929 6.343a1 1 0 0 0 0 1.414l.536.536L4.757 10H4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h.757l.707 1.707-.535.536a1 1 0 0 0 0 1.414l1.414 1.414a1 1 0 0 0 1.414 0l.536-.535 1.707.707V20a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-.757l1.707-.708.536.536a1 1 0 0 0 1.414 0l1.414-1.414a1 1 0 0 0 0-1.414l-.535-.536.707-1.707H20a1 1 0 0 0 1-1Z">
				</path>
				<path 
					stroke="currentColor" 
					stroke-linecap="round" 
					stroke-linejoin="round" 
					stroke-width="2" 
					d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z">
				</path>
			</svg>
			<span class="truncate ml-2"> Account Settings </span>
		</a>
		<a
			href="{{route('adminland.changepassword')}}"
			class=" {{ request()->routeIs('adminland.changepassword') ? 'bg-gray-200 hover:bg-gray-200' : 'hover:bg-gray-50'}}  text-gray-900  rounded px-3 py-2 flex items-center text-sm font-medium">
			<!-- Heroicon name: outline/user-circle -->
			<svg
				class="w-6 h-6 text-gray-800 dark:text-white"
				aria-hidden="true"
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24">
				<path
					stroke="currentColor"
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.3-.6-1-1-1.6-1H7.6c-.7 0-1.3.4-1.6 1M4 5h16c.6 0 1 .4 1 1v12c0 .6-.4 1-1 1H4a1 1 0 0 1-1-1V6c0-.6.4-1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
			</svg>
			<span class="truncate ml-2"> Change Password </span>
		</a>
		<a
			href="{{route('adminland.archivedworkspaces')}}"
			class="{{ request()->routeIs('adminland.archivedworkspaces') ? 'bg-gray-200 hover:bg-gray-200' : 'hover:bg-gray-50' }} text-gray-900 hover:text-gray-900  rounded px-3 py-2 flex items-center text-sm font-medium">
			<!-- Heroicon name: outline/user-circle -->
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="size-6">
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
			</svg>

			<span class="truncate ml-2"> Archived Workspaces </span>
		</a>
		<a
			href="{{route('adminland.archivedmodules')}}"
			class="{{ request()->routeIs('adminland.archivedmodules') ? 'bg-gray-200 hover:bg-gray-200' : 'hover:bg-gray-50' }} rounded px-3 py-2 flex items-center text-sm font-medium">
			<!-- Heroicon name: outline/user-circle -->
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="size-6">
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
			</svg>

			<span class="truncate ml-2"> Archived Modules </span>
		</a>
		<a
			href="{{route('adminland.archivedarticles')}}"
			class="{{ request()->routeIs('adminland.archivedarticles') ? 'bg-gray-200 hover:bg-gray-200' : 'hover:bg-gray-50' }} rounded px-3 py-2 flex items-center text-sm font-medium">
			<!-- Heroicon name: outline/user-circle -->
			<svg
				class="w-6 h-6 text-gray-800 dark:text-white"
				aria-hidden="true"
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24">
				<path
					stroke="currentColor"
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					d="M15 4h3c.6 0 1 .4 1 1v15c0 .6-.4 1-1 1H6a1 1 0 0 1-1-1V5c0-.6.4-1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
			</svg> <span class="truncate ml-2"> Archived Articles </span>
		</a>

		<a
			href="{{route('adminland.manageDatabase')}}"
			class="{{ request()->routeIs('adminland.manageDatabase') ? 'bg-gray-200 hover:bg-gray-200' : 'hover:bg-gray-50' }} rounded px-3 py-2 flex items-center text-sm font-medium">
			<!-- Heroicon name: outline/user-circle -->
			<svg
				xmlns="http://www.w3.org/2000/svg"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				class="w-6 h-6 text-gray-800 dark:text-white">
				<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
			</svg>
			<span class="truncate ml-2"> Manage Database</span>
		</a>
	</nav>
</aside>