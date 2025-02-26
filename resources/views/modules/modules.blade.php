@extends('layouts.app_layout')
@section('content')
<div class="max-w-3xl px-4 mb-16 mx-auto lg:px-6 sm:py-8 lg:py-8">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex justify-self-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a
                    href="/quick-kb"
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
                        >{{$workspace['title']}}</a>
                </div>
            </li>
        </ol>
    </nav>
    <div class="text-left mt-4 flex justify-between">
        <h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Modules (6)</h2>
        
        @auth
        <button
            data-modal-target="createEventModal"
            data-modal-toggle="createEventModal"
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
        @endauth
        <div
            id="tooltip-add"
            role="tooltip"
            class="absolute z-10 invisible inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs opacity-0 tooltip dark:bg-gray-700">
            Add New Module
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>

    <div
        class="max-w-3xl p-5 mx-auto mt-4 space-y-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 shadow-md">
        <div class="pb-5 border-b border-gray-200 dark:border-gray-700">
            <a
                href="/quick-kb/articles"
                class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                Onboarding and Account Setup
            </a>
            <p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                This chapter provides an overview of the basic principles of design, such as balance,
                contrast, and hierarchy. It explains how these principles can be used to create visually
                pleasing and effective designs.
            </p>
            
            @auth
            <div class="sm:flex sm:items-center sm:justify-right mt-2">
                <button
                    data-tooltip-target="tooltip-edit"
                    data-modal-target="editWorkspaceModal"
                    data-modal-toggle="editWorkspaceModal"
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
                        ></svg> <span class="sr-only">Icon description</span></button>
                <button
                    data-tooltip-target="tooltip-archive"
                    data-modal-target="popup-modal"
                    data-modal-toggle="popup-modal"
                    type="button"
                    class="text-black bg-gray-300 hover:bg-red-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-3"
                        ><path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"
                        ></path
                        ></svg> <span class="sr-only">Icon description</span></button>
            </div>
            @endauth
        </div>

        <div class="pb-5 border-b border-gray-200 dark:border-gray-700">
            <a
                href="/quick-kb/articles"
                class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                Billing and Subscription Plans
            </a>
            <p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                This chapter explores the concept of user experience (UX) design and how it relates to the
                overall design process. It covers topics such as user research, usability testing, and
                user-centered design.
            </p>
			@auth
            <div class="sm:flex sm:items-center sm:justify-right mt-2">
                <button
                    data-tooltip-target="tooltip-edit"
                    data-modal-target="editWorkspaceModal"
                    data-modal-toggle="editWorkspaceModal"
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
                        ></svg> <span class="sr-only">Icon description</span></button>
                <button
                    data-tooltip-target="tooltip-archive"
                    data-modal-target="popup-modal"
                    data-modal-toggle="popup-modal"
                    type="button"
                    class="text-black bg-gray-300 hover:bg-red-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="size-3"
                        ><path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"
                        ></path
                        ></svg> <span class="sr-only">Icon description</span></button>
            </div>
            @endauth
        </div>

        <div class="pb-5 border-b border-gray-200 dark:border-gray-700">
            <a
                href="/quick-kb/articles"
                class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                Account and Personal Settings
            </a>
            <p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                This chapter delves into the art and technique of typography, including the history and
                evolution of type, the basics of typographic hierarchy, and the use of typography in
                digital design.
            </p>
        </div>

        <div class="pb-5 border-b border-gray-200 dark:border-gray-700">
            <a
                href="/quick-kb/articles"
                class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                Managing Teams and Permissions
            </a>
            <p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                This chapter covers the basics of color theory and its application in design. It includes
                information on color wheels, complementary colors, color schemes, and the psychological
                effects of color. It also covers color management and color spaces in digital design.
            </p>
        </div>

        <div class="pb-5 border-b border-gray-200 dark:border-gray-700">
            <a
                href="/quick-kb/articles"
                class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                Managing Archive
            </a>
            <p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                This chapter will cover the basics of web design, including the principles of responsive
                design, website layout, and typography, as well as the use of HTML, CSS, and JavaScript.
            </p>
        </div>

        <div class="">
            <a
                href="/quick-kb/articles"
                class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                Infrastructure and Security
            </a>
            <p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
                This chapter will explore the process of creating and maintaining a brand, including the
                development of a brand strategy, the creation of a visual identity, and the use of design
                elements to communicate a brand's message.
            </p>
        </div>
    </div>
</div>


    <!-- Main modal -->
@auth
<div
	id="createEventModal"
	tabindex="-1"
	aria-hidden="true"
	class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
	<div class="relative p-4 w-full max-w-xl h-full md:h-auto">
		<!-- Modal content -->
		<div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
			<!-- Modal header -->
			<div class="flex justify-between items-center mb-4 sm:mb-5 dark:border-gray-600">
				<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add new module</h3>
				<button
					type="button"
					class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-sm text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
					data-modal-toggle="createEventModal">
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
			<form action="#">
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
					</div>

					<div>
						<label
							for="description"
							class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
							>Description</label>
						<textarea
							id="message"
							rows="4"
							class="block p-1.5 w-full text-sm text-gray-900 bg-gray-50 rounded-sm border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
							placeholder="Write description..."></textarea>
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
						data-modal-toggle="createEventModal"
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
			<form action="#">
				<div class="grid gap-4 mb-4">
					<div>
						<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
							>Title</label>
						<input
							type="text"
							name="title"
							id="title"
							class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
							value="Onboarding and Account Setup"
							required="" />
					</div>

					<div>
						<label
							for="description"
							class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
							>Description</label>
						<textarea
							id="message"
							rows="4"
							class="block p-1.5 w-full text-sm text-gray-900 bg-gray-50 rounded-sm border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
							value="This is description for module being edited"></textarea>
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
				<button
					data-modal-hide="popup-modal"
					type="button"
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
@endsection