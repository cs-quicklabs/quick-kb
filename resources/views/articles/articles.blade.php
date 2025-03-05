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
							href="/"
							class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline"
							>{{$workspace->title}}</a>
					</div>
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
							href="{{route('modules.modules', ['workspace_slug' => $workspace['slug']])}}"
							class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline"
							>{{$module->title}}</a>
					</div>
				</li>
			</ol>
		</nav>
		<div class="text-left mt-4 flex justify-between">
			<h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Articles (6)</h2>
			<a
				href="/quick-kb/articles/add"
				type="button"
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
			</a>
			<div
				id="tooltip-add"
				role="tooltip"
				class="absolute z-10 invisible inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs opacity-0 tooltip dark:bg-gray-700">
				Add New Article
				<div class="tooltip-arrow" data-popper-arrow></div>
			</div>
		</div>

		<div
			class="max-w-3xl p-5 mx-auto mt-4 space-y-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
			<div class="pb-5 border-b border-gray-200 dark:border-gray-700">
				<a
					href="/quick-kb/articles/1"
					class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
					Chapter 1: Introduction to Design Principles
				</a>
				<p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
					This chapter provides an overview of the basic principles of design, such as balance,
					contrast, and hierarchy. It explains how these principles can be used to create visually
					pleasing and effective designs.
				</p>
				<div class="sm:flex sm:items-center sm:justify-right mt-2">
					<a
						href="/quick-kb/articles/1"
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
							></svg> <span class="sr-only">Icon description</span></a>
					<div
						id="tooltip-edit"
						role="tooltip"
						class="absolute z-10 inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible"
						style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(347.5px, -323px, 0px);"
						data-popper-placement="top">
						Edit Article <div
							class="tooltip-arrow"
							data-popper-arrow=""
							style="position: absolute; left: 0px; transform: translate3d(38px, 0px, 0px);">
						</div>
					</div>
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
					<div
						id="tooltip-archive"
						role="tooltip"
						class="absolute z-10 inline-block px-2 py-1 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded shadow-sm tooltip dark:bg-gray-700 opacity-0 invisible"
						style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(376.5px, -323px, 0px);"
						data-popper-placement="top">
						Archive Article <div
							class="tooltip-arrow"
							data-popper-arrow=""
							style="position: absolute; left: 0px; transform: translate3d(49px, 0px, 0px);">
						</div>
					</div>
				</div>
			</div>

			<div class="pb-5 border-b border-gray-200 dark:border-gray-700">
				<a
					href="/quick-kb/articles/1"
					class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
					Chapter 2: Designing for User Experience
				</a>
				<p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
					This chapter explores the concept of user experience (UX) design and how it relates to the
					overall design process. It covers topics such as user research, usability testing, and
					user-centered design.
				</p>
			</div>

			<div class="pb-5 border-b border-gray-200 dark:border-gray-700">
				<a
					href="/quick-kb/articles/1"
					class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
					Chapter 3: Typography in Design
				</a>
				<p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
					This chapter delves into the art and technique of typography, including the history and
					evolution of type, the basics of typographic hierarchy, and the use of typography in
					digital design.
				</p>
			</div>

			<div class="pb-5 border-b border-gray-200 dark:border-gray-700">
				<a
					href="/quick-kb/articles/1"
					class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
					Chapter 4: Color Theory and its Applications
				</a>
				<p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
					This chapter covers the basics of color theory and its application in design. It includes
					information on color wheels, complementary colors, color schemes, and the psychological
					effects of color. It also covers color management and color spaces in digital design.
				</p>
			</div>

			<div class="pb-5 border-b border-gray-200 dark:border-gray-700">
				<a
					href="/quick-kb/articles/1"
					class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
					Chapter 5: Design for the Web
				</a>
				<p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
					This chapter will cover the basics of web design, including the principles of responsive
					design, website layout, and typography, as well as the use of HTML, CSS, and JavaScript.
				</p>
			</div>

			<div class="">
				<a
					href="/quick-kb/articles/1"
					class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
					Chapter 6: Branding and Identity Design
				</a>
				<p class="mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
					This chapter will explore the process of creating and maintaining a brand, including the
					development of a brand strategy, the creation of a visual identity, and the use of design
					elements to communicate a brand's message.
				</p>
			</div>
		</div>
	</div>
@endsection