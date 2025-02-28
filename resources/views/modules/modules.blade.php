
@extends('layouts.app_layout')
@section('content')
<div class="max-w-3xl px-4 mb-16 mx-auto lg:px-6 sm:py-8 lg:py-8">
    <nav class="flex" aria-label="Breadcrumb">
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
                        href="{{route('workspaces.workspaces')}}"
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline"
                        >{{$workspace['title']??""}}</a>
                </div>
            </li>
        </ol>
    </nav>
    <div class="text-left mt-4 flex justify-between">
        <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Modules ({{$moduleCount??0}})</h2>
        
        @auth
            @if(!empty($workspace))
                <button
                    data-modal-target="createModuleModal"
                    data-modal-toggle="createModuleModal"
                    data-tooltip-target="tooltip-add"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg
                        class="w-4 h-4 dark:text-white"
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
                            stroke-width="4"
                            d="M5 12h14m-7 7V5" />
                    </svg>

                    <span class="sr-only">Icon description</span>
                </button>
                <div
                    id="tooltip-add"
                    role="tooltip"
                    class="absolute z-10 invisible inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs opacity-0 tooltip dark:bg-gray-700">
                    Add New Module
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            @endif
        @endauth
        
    </div>

    <div id="draggable-list" 
        class="max-w-3xl p-5 mx-auto mt-4 space-y-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 shadow-md">
        
        @if($moduleCount > 0)
            @foreach($modules as $module)
                <div data-module-id="{{ $module['id'] }}" class="draggable-item pb-5 {{ $loop->last ? '' : 'border-b' }} border-gray-200 dark:border-gray-700">
                    
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex-1">
                            <input type="hidden" id="module-title-{{$module['id']}}" value="{{$module['title']}}">
                            <a
                                href="/quick-kb/articles"
                                class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                                {{$module['shortTitle']}}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-2">
                        <div class="flex-1">
                            <p id="module-description-{{$module['id']}}" class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                                {{$module['description']}}
                            </p>
                        </div>
                        @auth
                            <span title="Drag to reorder" class="drag-handle text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-move">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <circle cx="9" cy="6" r="2"/>
                                    <circle cx="9" cy="12" r="2"/>
                                    <circle cx="9" cy="18" r="2"/>
                                    <circle cx="15" cy="6" r="2"/>
                                    <circle cx="15" cy="12" r="2"/>
                                    <circle cx="15" cy="18" r="2"/>
                                </svg>
                            </span>
                        @endauth
                    </div>

                    @auth
                        <div class="sm:flex sm:items-center sm:justify-right mt-2">
                            <button
                                data-tooltip-target="tooltip-edit-{{$module['id']}}"
                                data-modal-target="editWorkspaceModal"
                                data-modal-toggle="editWorkspaceModal"
                                onclick="editModuleModal({{$module['id']}})"
                                type="button"
                                class="text-black bg-gray-300 hover:bg-blue-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                ><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-3"
                                    ><path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"
                                    ></path
                                    ></svg> <span class="sr-only">Icon description</span>
                            </button>
                            <div id="tooltip-edit-{{$module['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
                                Edit Module 
                                <div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
                            </div>
                            <button onclick="archiveModuleModal({{$module['id']}})" type="button" data-tooltip-target="tooltip-archive-{{$module['id']}}" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="text-black bg-gray-300 hover:bg-red-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-3">
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z">
                                    </path>
                                </svg> 
                                <span class="sr-only">Icon description</span>
                            </button>
                            <div id="tooltip-archive-{{$module['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
                                Archive Module 
                                <div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
                            </div>
                        </div>
                    @endauth
                </div>
            @endforeach
        @else
            <p class="text-gray-500 dark:text-gray-400">No Modules found</p>
        @endif

        
    </div>
</div>


    <!-- Main modal -->
@auth
<div
	id="createModuleModal"
	tabindex="-1"
	aria-hidden="true"
    data-modal-backdrop="static"
	class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
	<div class="relative p-4 w-full max-w-xl h-full md:h-auto">
		<!-- Modal content -->
		<div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<!-- Modal header -->
			<div class="flex justify-between items-center mb-4 sm:mb-5 dark:border-gray-600">
				<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add new module</h3>
				<button
					type="button"
                    onclick="clearAddModuleForm()"
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-sm text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-toggle="createModuleModal">
					<svg
						aria-hidden="true"
						class="w-5 h-5"
						fill="currentColor"
						viewBox="0 0 20 20"
						xmlns="http://www.w3.org/2000/svg"
						><path
							fill-rule="evenodd"
							d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
							clip-rule="evenodd"></path
						></svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<form action="#" id="createModuleForm">
                <input type="hidden" name="workspace_id" value="{{$workspace['id']??0}}">
				<div class="grid gap-4 mb-4">
					<div>
						<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
							>Title</label>
						<input
							type="text"
							name="title"
							id="title"
							class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
							placeholder="Add title here"
							required="" />
                            <span class="text-red-500 text-xs error-title"></span>
					</div>

					<div>
						<label
							for="description"
							class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
							>Description</label>
						<textarea
							id="description"
							name="description"
							rows="4"
							class="block p-1.5 w-full text-sm text-gray-900 bg-gray-50 rounded-sm border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
							placeholder="Write description..."></textarea>
                            <span class="text-red-500 text-xs error-description"></span>
					</div>
				</div>
				<div class="flex items-center space-x-4">
					<button
						type="submit"
						class="text-white inline-flex items-center justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
						Add Module
						<span class="sr-only">Add Module</span>
					</button>
					<button
						data-modal-toggle="createModuleModal"
                        onclick="clearAddModuleForm()"
						type="button"
						class="inline-flex justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
						Discard
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Edit modal -->
<div
	id="editWorkspaceModal"
	tabindex="-1"
	aria-hidden="true"
    data-modal-backdrop="static"
	class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
	<div class="relative p-4 w-full max-w-xl h-full md:h-auto">
		<!-- Modal content -->
		<div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<!-- Modal header -->
			<div class="flex justify-between items-center mb-4 sm:mb-5 dark:border-gray-600">
				<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit workspace</h3>
				<button
					type="button"
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-sm text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-toggle="editWorkspaceModal">
					<svg
						aria-hidden="true"
						class="w-5 h-5"
						fill="currentColor"
						viewBox="0 0 20 20"
						xmlns="http://www.w3.org/2000/svg"
						><path
							fill-rule="evenodd"
							d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
							clip-rule="evenodd"></path
						></svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<form action="#" id="editModuleForm">
                <input type="hidden" name="module_id" id="editModule-id">
				<div class="grid gap-4 mb-4">
					<div>
						<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
							>Title</label>
						<input
							type="text"
							name="title"
							id="editModule-title"
							class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
							value=""
							required="" />
                            <span id="error-title" class="text-red-500 text-xs error-title"></span>
					</div>

					<div>
						<label
							for="description"
							class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
							>Description</label>
						<textarea
							id="editModule-description"
							rows="4"
                            name="description"
							class="block p-1.5 w-full text-sm text-gray-900 bg-gray-50 rounded-sm border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
							value=""></textarea>
                            <span id="error-description" class="text-red-500 text-xs error-description"></span>
					</div>
				</div>
				<div class="flex items-center space-x-4">
					<button
						type="submit"
						class="text-white inline-flex items-center justify-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
						Edit Module
						<span class="sr-only">Edit Module</span>
					</button>
					<button
						data-modal-toggle="editWorkspaceModal"
						type="button"
						class="inline-flex justify-center text-gray-500 items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
						Discard
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div
	id="popup-modal"
	tabindex="-1"
    data-modal-backdrop="static"
	class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-md max-h-full">
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<button
				type="button"
				class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
				data-modal-hide="popup-modal">
				<svg
					class="w-3 h-3"
					aria-hidden="true"
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 14 14">
					<path
						stroke="currentColor"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
				</svg>
				<span class="sr-only">Close modal</span>
			</button>
			<div class="p-4 md:p-5 text-center">
				<svg
					class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200"
					aria-hidden="true"
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 20 20">
					<path
						stroke="currentColor"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
				</svg>
				<h3 class="text-lg font-bold text-gray-700 dark:text-gray-400">
					Are you sure you want to archive this module?
				</h3>
				<p class="mb-5 font-xs text-gray-500">
					All the information regarding this module will be hidden and its content will also be
					hidden. An archived module can be restore any time.
				</p>
                <input type="hidden" name="module_id" id="archiveModule-id">
				<button
					data-modal-hide="popup-modal"
					type="button"
                    onclick="archiveModule()"
					class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
					Yes, I'm sure
				</button>
				<button
					data-modal-hide="popup-modal"
					type="button"
					class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
					>No, cancel</button>
			</div>
		</div>
	</div>
</div>
@endauth


<script>
    


    document.getElementById('createModuleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset error messages
        document.querySelector('.error-title').textContent = '';
        document.querySelector('.error-description').textContent = '';
        
        const formData = new FormData(this);
        console.log(formData);
        //return false;
        
        fetch('{{route("modules.createModule")}}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success handling
                alert(data.message);
                window.location.reload(); // Or update the UI without reload
            } else {
                // Error handling
                if (data.errors) {
                    alert(data.message);

                    Object.keys(data.errors).forEach(key => {
                        document.querySelector(`.error-${key}`).textContent = data.errors[key][0];
                    });
                }
            }
        })
        .catch(error => {
            alert("Something went wrong.");
            console.error('Error:', error);
        });
    });

    function clearAddModuleForm() {
        document.getElementById('createModuleForm').reset();
        document.querySelector('.error-title').textContent = '';
        document.querySelector('.error-description').textContent = '';
    }


    function archiveModuleModal(id) {
        document.getElementById('archiveModule-id').value = id;
    }

    function archiveModule() {
        const moduleId = document.getElementById('archiveModule-id').value;
        console.log(moduleId);
        const formData = new FormData();
        formData.append('status', '0');
        console.log(formData);
        fetch('{{route("modules.update", ["module_id" => ":module_id"])}}'.replace(':module_id', moduleId), {
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
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message);
            }   
        })
        .catch(error => {
            alert("Something went wrong.");
            console.error('Error:', error);
        });
    }


    function editModuleModal(id) {
        document.getElementById('editModule-title').value = document.getElementById('module-title-'+id).value.trim();
        document.getElementById('editModule-description').value = document.getElementById('module-description-'+id).textContent.trim();
        document.getElementById('editModule-description').textContent = document.getElementById('module-description-'+id).textContent.trim();
        document.getElementById('editModule-id').value = id;
        document.getElementById('error-title').textContent = '';
        document.getElementById('error-description').textContent = '';
    } 
    
    
    document.getElementById('editModuleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const moduleId = document.getElementById('editModule-id').value;
        const title = document.getElementById('editModule-title').value.trim();
        const description = document.getElementById('editModule-description').value.trim();
    
        
        // Reset error messages
        document.getElementById('error-title').textContent = '';
        document.getElementById('error-description').textContent = '';


        // Validation
        let hasErrors = false;
        
        // Title validation
        if (!title) {
            document.getElementById('error-title').textContent = 'The title field is required.';
            hasErrors = true;
        }

        // Description validation
        if (!description) {
            document.getElementById('error-description').textContent = 'The description field is required.';
            hasErrors = true;
        }

        // Stop if there are validation errors
        if (hasErrors) {
            return;
        }


        const formData = new FormData(this);

        fetch('{{route("modules.update", ["module_id" => ":module_id"])}}'.replace(':module_id', moduleId), {
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
                alert(data.message);
                window.location.reload(); // Or update the UI without reload
            } else {
                // Error handling
                if (data.errors) {
                    alert(data.message);

                    Object.keys(data.errors).forEach(key => {
                        document.querySelector(`#error-${key}`).textContent = data.errors[key][0];
                    });
                }
            }
        })
        .catch(error => {
            alert("Something went wrong.");
            console.error('Error:', error);
        });
    });

    // Update module order...
    function updateDraggableListOrder() {
        const modules = [...document.querySelectorAll('.draggable-item')];
        const orders = modules.map((module, index) => ({
            id: module.dataset.moduleId,
            order: index
        }));
        console.log('orders',orders);

        // Add/remove border-b class
        modules.forEach((module, index) => {
            if (index < modules.length - 1) {
                module.classList.add('border-b');
            } else {
                module.classList.remove('border-b');
            }
        });

        // Send the new order to the server
        fetch('{{route("modules.updateModuleOrder")}}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ orders })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Failed to update module order');
            }
        })
        .catch(error => {
            console.error('Error updating module order:', error);
        });
    }
</script>

@endsection