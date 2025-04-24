@extends('layouts.app_layout')
@section('content')
    <div class="max-w-3xl px-4 mb-16 mx-auto lg:px-6 sm:py-8 lg:py-8" style="--link-color: {{ $color }};">
        @if(!empty($workspace))
            <div
                id="alert-additional-content-2"
                class="p-4 mb-4 text-red-800 border border-red-300 rounded-md bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                role="alert">
                <div class="flex items-center">
                    <svg
                        class="shrink-0 w-4 h-4 me-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <h3 class="text-lg font-medium">Archived Workspace</h3>
                </div>
                <div class="mt-2 mb-4 text-sm">
                    This workspace has been archived by {{$workspace->updatedBy->name}} on {{$workspace->archived_at}}. This is no longer visible
                    to users but can be restored at any time.
                </div>
                <div class="flex">
                    <div class="flex-1">
                        <button
                            type="button"
                            onclick="restoreWorkspaceModal({{$workspace->id}})"
                            data-modal-target="restoreWorkspaceModal" 
                            data-modal-toggle="restoreWorkspaceModal"
                            class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Restore Workspace
                        </button>
                        <button
                            type="button"
                            onclick="deleteWorkspaceModal({{$workspace->id}})"
                            class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800"
                            data-modal-target="deleteWorkspaceModal" 
                            data-modal-toggle="deleteWorkspaceModal" 
                            aria-label="Close">
                            Delete Permanently
                        </button>
                    </div>
                    <a
                        href="{{route('adminland.archivedworkspaces')}}"
                        class="button-link text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800">
                        Back
                    </a>
                </div>
            </div>
        @endif
        <nav class="flex" aria-label="Breadcrumb" style="--link-color: {{ $color }};">
            <ol class="inline-flex justify-self-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a
                        href="/"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white hover:underline">
                        <svg
                            class="w-3 h-3 me-2.5"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg
                            class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10">
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a
                            href="#"
                            class="cursor-not-allowed ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline"
                            >{{getShortTitle($workspace['title']??"", 50)}}</a>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="text-left mt-4">
            <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Modules @if(!empty($workspace)) ({{count($workspace->modules)}}) @else (0) @endif</h2>
        </div>

        
            @if(!empty($workspace) && count($workspace->modules) > 0)
                @if($spacing == 'default')
                    <div class="max-w-3xl p-5 mx-auto mt-4 space-y-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
                        @foreach($workspace->modules as $module)
                            <div class="{{ $loop->last ? '' : 'border-b pb-5 ' }} border-gray-200 dark:border-gray-700">
                                <a
                                    href="{{route('modules.getArchivedModule', ['workspace_slug' => $workspace->slug, 'module_slug' => $module->slug])}}"
                                    class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                                    {{$module->title}}
                                </a>
                                <p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400 line-clamp-3">
                                    {{$module->description}}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="max-w-3xl mt-4 flex flex-col" style="--link-color: {{ $color }};">
                        @foreach($workspace->modules as $module)
                            <div class="">
                                <a
                                    href="{{route('modules.getArchivedModule', ['workspace_slug' => $workspace->slug, 'module_slug' => $module->slug])}}"
                                    class="text-gray-900 dark:text-white hover:underline">
                                    {{$module->title}}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="max-w-3xl p-5 mx-auto mt-4 space-y-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
                    <div class="text-center">
                        <p class="text-gray-500 dark:text-gray-400">No modules found in this workspace.</p>
                    </div>
                </div>
            @endif

    </div>

    <div id="restoreWorkspaceModal" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <input type="hidden" id="workspace_id" value="">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="restoreWorkspaceModal">
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
                    <button onclick="restoreWorkspace()" data-modal-hide="restoreWorkspaceModal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, I'm sure</button> 
                    <button data-modal-hide="restoreWorkspaceModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                </div>
            </div>
        </div>
    </div>


    <div id="deleteWorkspaceModal" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700"><button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deleteWorkspaceModal"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg> <span class="sr-only">Close modal</span></button>
                <div class="p-4 md:p-5 text-center"><svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-400">Are you sure you want to delete this workspace?</h3>
                    <p class="mb-5 font-xs text-gray-500">All the information regarding this workspace will be lost and its content will also be
                        lost. This is not reversible.</p> 
                        <button onclick="deleteWorkspace()" data-modal-hide="deleteWorkspaceModal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, I'm sure</button> 
                        <button data-modal-hide="deleteWorkspaceModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection

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
                toastify.success(data.message);
                const worspaceData = data.data;
				const workspace_slug = worspaceData.slug;

				setTimeout(() => { 
					window.location.href = "{{ route('modules.modules', ['workspace_slug' => ':workspace_slug']) }}"
						.replace(':workspace_slug', workspace_slug);
				}, 1000);
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
                window.location.href = '{{ route("adminland.archivedworkspaces") }}';
			} else {
				toastify.error(data.message);
			}
		})
		.catch(error => {
			toastify.error("Something went wrong.");
			console.error('Error:', error);	
		});
	}

</script>