@php
    $color = getThemeValues()['color'];
    $spacing = getThemeValues()['theme_spacing'];
@endphp
@extends('layouts.app_layout')
@section('content')
    <div class="max-w-3xl px-4 mb-16 mx-auto lg:px-6 sm:py-8 lg:py-8">
		<nav class="flex" aria-label="Breadcrumb">
			<ol class="inline-flex justify-self-center space-x-1 md:space-x-2 rtl:space-x-reverse">
				<li class="inline-flex items-center">
					<a
						href="/"
						class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-{{$color}}-900 dark:text-gray-400 dark:hover:text-white hover:underline">
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
							href="{{route('modules.modules', ['workspace_slug' => $workspace['slug']])}}"
							class="ms-1 text-sm font-medium text-gray-700 hover:text-{{$color}}-900 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline">
							{{getShortTitle($workspace->title??"", 50)}}
						</a>
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
							href="#"
							class="cursor-not-allowed ms-1 text-sm font-medium text-gray-700 hover:text-{{$color}}-900 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline"
							>{{getShortTitle($module->title??"", 50)}}</a>
					</div>
				</li>
			</ol>
		</nav>
		<div class="text-left mt-4 flex justify-between">
			<h2 class="text-xl font-extrabold text-gray-900 dark:text-white">Articles ({{count($articles)}})</h2>
			@auth
				<a
					href="{{route('articles.addArticle', ['workspace_slug' => $workspace['slug'], 'module_slug' => $module['slug']])}}"
					type="button"
					data-tooltip-target="tooltip-add"
					class="text-white bg-{{$color}}-700 hover:bg-{{$color}}-800 focus:ring-4 focus:outline-none focus:ring-{{$color}}-300 font-medium rounded-full text-sm p-2 text-center inline-flex items-center dark:bg-{{$color}}-600 dark:hover:bg-{{$color}}-700 dark:focus:ring-{{$color}}-800">
					<svg class="w-4 h-4 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 12h14m-7 7V5" />
					</svg>

					<span class="sr-only">Icon description</span>
				</a>
				<div id="tooltip-add" role="tooltip" class="absolute z-10 invisible inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs opacity-0 tooltip dark:bg-gray-700">
					Add New Article
					<div class="tooltip-arrow" data-popper-arrow></div>
				</div>
			@endauth
		</div>

		
			
			@if(count($articles) > 0)
				@if(getThemeValues()['theme_spacing'] == 'default')
					<div id="draggable-list" class="max-w-3xl p-5 mx-auto mt-4 space-y-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
						@foreach ($articles as $article)
							<div id="articlediv-{{$article['id']}}" 
								class="draggable-item {{ $loop->last ? '' : 'border-b pb-5' }} border-gray-200 dark:border-gray-700"
								data-draggablelist-id="{{$article['id']}}">
								<div class="flex items-center justify-between gap-2">
									<div class="flex-1">
										<input type="hidden" id="articletitle-{{$article['id']}}" value="{{$article['title']}}">
										<a href="{{route('articles.articleDetails', ['workspace_slug' => $workspace['slug'], 'module_slug' => $module['slug'], 'article_slug' => $article['slug']])}}" class="text-lg font-semibold text-gray-900 dark:text-white hover:underline hover:text-{{$color}}-900 line-clamp-2">
											{{$article['title']}}
										</a>
									</div>
								</div>

								<div class="flex items-center justify-between gap-2">
									<div class="flex-1">
										<p id="articledescription-{{$article['id']}}" class="line-clamp-3 mt-1 text-base font-normal text-gray-500 dark:text-gray-400">
											{{$article['content']}}
										</p>
									</div>
										
									@auth
									<span data-tooltip-target="tooltip-drag-{{$article['id']}}" class="drag-handle text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-move">
										<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
											<circle cx="9" cy="6" r="2"/>
											<circle cx="9" cy="12" r="2"/>
											<circle cx="9" cy="18" r="2"/>
											<circle cx="15" cy="6" r="2"/>
											<circle cx="15" cy="12" r="2"/>
											<circle cx="15" cy="18" r="2"/>
										</svg>
									</span>
									<div id="tooltip-drag-{{$article['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
										Drag to reorder 
										<div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
									</div>
									@endauth
									
								</div>
								@auth
									<div class="flex items-center justify-between gap-2">
										<div class="flex-1">
											<div class="sm:flex sm:items-center sm:justify-right mt-2">
												<a href="{{route('articles.articleDetails', ['workspace_slug' => $workspace['slug'], 'module_slug' => $module['slug'], 'article_slug' => $article['slug']])}}"  data-tooltip-target="tooltip-edit-{{$article['id']}}" class="text-black bg-gray-300 hover:bg-blue-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
													<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
														<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"></path>
													</svg>
													<span class="sr-only">Icon description</span>
												</a>
												<div id="tooltip-edit-{{$article['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
													Edit Article 
													<div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
												</div>
												<button onclick="archiveArticleModal({{$article['id']}})" data-tooltip-target="tooltip-archive-{{$article['id']}}" data-modal-target="archiveArticlemodal" data-modal-toggle="archiveArticlemodal" type="button" class="text-black bg-gray-300 hover:bg-red-800 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
													<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-3">
														<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"></path>
													</svg> 
													<span class="sr-only">Icon description</span>
												</button>
												<div id="tooltip-archive-{{$article['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
													Archive Article 
													<div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
												</div>
											</div>
										</div>
										@if($article['status'] == 2)
											<span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset">Draft</span>
										@endif

									</div>
								@endauth
							</div>
						@endforeach
					</div>
				@else
					<div id="draggable-list" class="max-w-3xl mt-4 flex flex-col">
						@foreach ($articles as $article)
							<div id="articlediv-{{$article['id']}}" data-draggablelist-id="{{$article['id']}}" class="draggable-item ">
								<div class="flex items-center">
									<div class="flex items-center justify-between gap-2">

										@auth
											<span data-tooltip-target="tooltip-drag-{{$article['id']}}" class="drag-handle text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-move">
												<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
													<circle cx="9" cy="6" r="2"/>
													<circle cx="9" cy="12" r="2"/>
													<circle cx="9" cy="18" r="2"/>
													<circle cx="15" cy="6" r="2"/>
													<circle cx="15" cy="12" r="2"/>
													<circle cx="15" cy="18" r="2"/>
												</svg>
											</span>
											<div id="tooltip-drag-{{$article['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
												Drag to reorder 
												<div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
											</div>
										@endauth
										<input type="hidden" id="articletitle-{{$article['id']}}" value="{{$article['title']}}">
										<input type="hidden" id="articledescription-{{$article['id']}}" value="{{$article['content']}}">
										<a href="{{route('articles.articleDetails', ['workspace_slug' => $workspace['slug'], 'module_slug' => $module['slug'], 'article_slug' => $article['slug']])}}" class="truncate text-gray-900 dark:text-white hover:underline hover:text-{{$color}}-900">
											{{$article['title']}}
										</a> 
									</div>
									@auth
										<div class="flex items-center justify-between gap-2">
											<a href="{{route('articles.articleDetails', ['workspace_slug' => $workspace['slug'], 'module_slug' => $module['slug'], 'article_slug' => $article['slug']])}}">
												<svg  data-tooltip-target="tooltip-edit-{{$article['id']}}" class="w-4 h-4 ml-4 text-blue-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
													<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"></path>
												</svg> 
											</a>
											<div id="tooltip-edit-{{$article['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
												Edit Article 
												<div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
											</div>

											<svg onclick="archiveArticleModal({{$article['id']}})" data-tooltip-target="tooltip-archive-{{$article['id']}}" data-modal-target="archiveArticlemodal" data-modal-toggle="archiveArticlemodal" class="ml-1 w-4 h-4 text-red-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
												<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"></path>
											</svg>
											<div id="tooltip-archive-{{$article['id']}}" role="tooltip" class="absolute z-10 inline-block px-2 py-1 text-md text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-sm shadow-xs tooltip dark:bg-gray-700 opacity-0 invisible" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1207px, 332px);" data-popper-placement="bottom">
												Archive Article 
												<div class="tooltip-arrow" data-popper-arrow="" style="position: absolute; left: 0px; transform: translate(61px, 0px);"></div>
											</div>

											
										</div>
									@endauth
								</div>
							</div>
						@endforeach
					</div>
				@endif
			@else
				<div id="draggable-list" class="max-w-3xl p-5 mx-auto mt-4 space-y-5 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 shadow-sm">
					<p class="text-gray-500 dark:text-gray-400">No articles found</p>	
				</div>
			@endif

	</div>

	<div id="archiveArticlemodal" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
		<div class="relative p-4 w-full max-w-md max-h-full">
			<div class="relative bg-white rounded-lg shadow dark:bg-gray-700"><button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-{{$color}}-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="archiveArticlemodal"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
					</svg> <span class="sr-only">Close modal</span></button>
				<div class="p-4 md:p-5 text-center"><svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
					</svg>
					<h3 class="text-lg font-bold text-gray-700 dark:text-gray-400">Are you sure you want to archive this article?</h3>
					<p class="mb-5 font-xs text-gray-500">All the information regarding this article will be hidden and its content will also be
						hidden. An archived article can be restore any time.</p> 
						<input type="hidden" name="article_id" id="archivearticle-id">
					<button onclick="archiveArticle()" data-modal-hide="archiveArticlemodal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
						Yes, I'm sure
					</button> 
					<button data-modal-hide="archiveArticlemodal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-{{$color}}-100 dark:focus:ring-{{$color}}-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
						No, cancel
					</button>
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
		function archiveArticleModal(id) {
			document.getElementById('archivearticle-id').value = id;
		}

		function archiveArticle() {
			const id = document.getElementById('archivearticle-id').value;
			const formData = new FormData();
			formData.append('status', '0');
			
			
			fetch('{{route("articles.updateArticleStatus", ["article_id" => ":article_id"])}}'.replace(':article_id', id), {
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
					console.log(data.message);
				}   
			})
			.catch(error => {
				console.error('Error:', error);
			});
		}



		// Update article order...
		function updateDraggableListOrder() {
			const items = [...document.querySelectorAll('.draggable-item')];
			const theme_spacing = "{{getThemeValues()['theme_spacing']}}";
			
			const orders = items.map((item, index) => ({
				id: item.dataset.draggablelistId,
				order: index
			}));

			// Add/remove border-b class
			if(theme_spacing == 'default'){
				items.forEach((item, index) => {
					if (index < items.length - 1) {
						item.classList.add('border-b');
					} else {
						item.classList.remove('border-b');
					}
				});
			}

			// Send the new order to the server
			fetch('{{route("articles.updateArticleOrder")}}', {
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
					toastify.error(data.message);
				} else {
					toastify.success(data.message);
				}
			})
			.catch(error => {
				toastify.error("Something went wrong.");
				console.error('Error updating article order:', error);
			});
		}
	</script>
@endsection