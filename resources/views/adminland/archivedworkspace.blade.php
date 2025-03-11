@extends('adminland.common.layout')
@section('content')
<main class="max-w-xl px-4 pb-12 lg:col-span-8">
	<div class="overflow-hidden bg-white">
		<div class="pb-4 ml-4">
			<div>
				<h1 class="text-lg leading-6 font-medium text-gray-900">Archived Workspaces</h1>
				<p class="mt-1 text-sm text-gray-500">Following workspaces have been archived.</p>
			</div>
		</div>
		<div class="flex space-x-4 ml-4">
			<div class="flex-1 min-w-0" data-behavior="autocomplete" data-controller="nav-search" data-nav-search-url-value="/search/deactivated"><label for="search" class="sr-only">Search</label>
				<div class="relative rounded-md shadow-sm">
					<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
						<svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
						</svg>
					</div> 
					<input type="search" name="search" id="search-input" class="pl-10 form-text-field" placeholder="Search" data-nav-search-target="input" autocomplete="off" spellcheck="false" value="{{ request('search') }}">
				</div>
				<div class="relative">
					<div class="absolute left-0 z-10 block w-full mt-1 origin-top-right bg-white rounded-md shadow-lg focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
						<ul data-nav-search-target="results" hidden=""></ul>
					</div>
				</div>
			</div>
		</div>
		<div class="overflow-hidden bg-white" data-controller="infinite-scroll">
			<div>
				<table class="table border-separate mt-4">
					<thead class="bg-gray-50"></thead>
					<tbody class="table-body" id="employees" data-infinite-scroll-target="entries">
						@if(count($workspaces) > 0)
							@foreach ($workspaces as $workspace)
								<tr id="user_426">
									<td class="table-cell whitespace-nowrap">
									<div class="flex items-center">
										<div class="flex-1 min-w-0 sm:flex sm:items-center sm:justify-between">
											<div><a href="{{route('workspaces.getArchivedWorkspace', ['workspace_slug' => $workspace['slug']])}}" class="truncate hover:text-gray-600 hover:underline">
													<div class="flex text-sm font-medium text-gray-600 truncate">
														<p>{{$workspace['title']}}</p>
													</div>
												</a>
												<div class="flex-1 w-full mt-2">
													<div class="flex items-center text-sm text-gray-500"><svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
															<path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
														</svg>
														<p>Deactivated on {{$workspace['updated_at']}} by {{$workspace['updated_by']}}</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</td>
								<td class="table-cell">
									<div class="flex justify-end">
										<button onclick="restoreWorkspaceModal({{$workspace['id']}})" class="btn-inline-delete" data-modal-target="popup-modal-activate" data-modal-toggle="popup-modal-activate" href="#">Restore</button> 
										<button onclick="deleteWorkspaceModal({{$workspace['id']}})" class="btn-inline-delete ml-2" data-modal-target="popup-modal" data-modal-toggle="popup-modal" href="#">Delete</button>
									</div>
								</td>
							</tr>
						@endforeach
						@else
							<tr>
								<td colspan="2" class="text-center">No archived workspaces found</td>
							</tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</main>
		
<div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-md max-h-full">
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700"><button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
				</svg> <span class="sr-only">Close modal</span></button>
			<div class="p-4 md:p-5 text-center"><svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
				</svg>
				<h3 class="text-lg font-bold text-gray-700 dark:text-gray-400">Are you sure you want to delete this workspace?</h3>
				<p class="mb-5 font-xs text-gray-500">All the information regarding this workspace will be lost and its content will also be
					lost. This is not reversible.</p> 
					<button onclick="deleteWorkspace()" data-modal-hide="popup-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, I'm sure</button> 
					<button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
			</div>
		</div>
	</div>
</div>

<div id="popup-modal-activate" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-md max-h-full">
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<input type="hidden" id="workspace_id" value="">
			<button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal-activate">
				<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
				</svg> 
				<span class="sr-only">Close modal</span>
			</button>
			<div class="p-4 md:p-5 text-center">
				<svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
				</svg>
				<h3 class="text-lg font-bold text-gray-700 dark:text-gray-400">Are you sure you want to restore this workspace?</h3>
				<p class="mb-5 font-xs text-gray-500">Once this workspace is restored, its content will also be restored and users will be able
					to see it.
				</p> 
				<button onclick="restoreWorkspace()" data-modal-hide="popup-modal-activate" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, I'm sure</button> 
				<button data-modal-hide="popup-modal-activate" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
			</div>
		</div>
	</div>
</div>

	@if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                toastify.success('{{session("success")}}');
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                toastify.error('{{session("error")}}');
            });
        </script>
    @endif

<script>
	function restoreWorkspaceModal(workspace_id) {
		document.getElementById('workspace_id').value = workspace_id;
	}

	function restoreWorkspace() {
		const workspace_id = document.getElementById('workspace_id').value;
		const formData = new FormData();
		formData.append('status', '1');

		fetch('{{route("workspaces.updateWorkspaceStatus", ["workspace_id" => ":workspace_id"])}}'.replace(':workspace_id', workspace_id), {
			method: 'post',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
				'Accept': 'application/json'
			},
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
                window.location.reload();
			} else {
				toastify.error(data.message);
			}
		})
		.catch(error => {
			toastify.error("Something went wrong.");
			console.error('Error:', error);
		});
	}

	function deleteWorkspaceModal(workspace_id) {
		document.getElementById('workspace_id').value = workspace_id;
	}
	

	function deleteWorkspace() {
		const workspace_id = document.getElementById('workspace_id').value;
		const formData = new FormData();
		
		formData.append('workspace_id', workspace_id);

		fetch('{{route("adminland.deleteWorkSpace", ["workspace_id" => ":workspace_id"])}}'.replace(':workspace_id', workspace_id), {
			method: 'delete',
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
				'Accept': 'application/json'
			},
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				window.location.reload();
			} else {
				toastify.error(data.errors);
			}
		})
		.catch(error => {
			toastify.error("Something went wrong.");
			console.error('Error:', error);	
		});
	}


	document.addEventListener('DOMContentLoaded', function() {
		const searchInput = document.getElementById('search-input');

		searchInput.addEventListener('keydown', function(event) {
			if (event.key === 'Enter') {
				const query = searchInput.value.trim();
				if (query.length >= 3) {
					// Reload the page with the search parameter
					const currentUrl = new URL(window.location.href);
					currentUrl.searchParams.set('search', query); // Set the search parameter
					window.location.href = currentUrl.toString(); // Reload the page with the new URL
				} 
				else if (query.length === 0) {
					// Reload the page without any parameters
					const currentUrl = new URL(window.location.href);
					currentUrl.searchParams.delete('search'); // Remove the search parameter
					window.location.href = currentUrl.toString(); // Reload the page without the search parameter
				}
			}
		});
	});
</script>
@endsection