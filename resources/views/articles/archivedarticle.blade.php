@extends('layouts.article_layout')
@section('content')
    <main class="max-w-screen-2xl mx-auto mt-16 py-3 md:px-4 sm:py-5 lg:px-8">
        <div class="-mt-4">
            <!--  -->
                <div class="justify-center mx-auto flex justify-center px-4 sm:px-6 lg:px-8">
                    <div id="alert-additional-content-2" class="p-4 mb-4 max-w-2xl text-red-800 border border-red-300 rounded-md bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                        <div class="flex items-center">
                            <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"></path>
                            </svg> 
                            <span class="sr-only">Info</span> 
                            <h3 class="text-lg font-medium">Archived Article</h3>
                        </div> 
                        <div class="mt-2 mb-4 text-sm">
                            This article has been archived by {{$articleData->createdBy->name}} on {{$articleData->archived_at}}. This is no longer visible to users but can be restored at any time.
                        </div> 
                        <div class="flex">
                            <button onclick="restoreArticleModal({{$articleData['id']}})" data-modal-target="restoreArticleModal" data-modal-toggle="restoreArticleModal" type="button" class="text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Restore Article</button> 
                            <button onclick="deleteArticleModal({{$articleData['id']}})" data-modal-target="articleDeleteModal" data-modal-toggle="articleDeleteModal" type="button" class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-md text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800" data-dismiss-target="#alert-additional-content-2" aria-label="Close">Delete Permanently</button>
                        </div>
                    </div>
                </div>
            <!--  -->



            <div class="flex justify-center px-4 pb-4 pt-5 sm:px-6 lg:px-8">
                <nav class="flex justify-self-center flex-wrap" aria-label="Breadcrumb">
                    <ol class="inline-flex justify-self-center flex-wrap align-center justify-center rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white hover:underline">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"></path>
                                </svg> Home
                            </a>
                        </li>
                        <li class="inline-flex items-center">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                                </svg> <a href="{{route('modules.modules', ['workspace_slug' => $articleData->module->workspace->slug])}}" class="truncate max-w-xs ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline">{{$articleData->module->workspace->title??''}}</a>
                            </div>
                        </li>
                        <li class="inline-flex items-center">
                            <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                                </svg> <a href="{{route('articles.articles', ['workspace_slug' => $articleData->module->workspace->slug, 'module_slug' => $articleData->module->slug])}}" class="truncate max-w-xs ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline">{{$articleData->module->title??''}}</a></div>
                        </li>
                    </ol>
                </nav>
            </div>

            

            <div class="mx-auto max-w-screen-lg bg-white">
                <form id="article-form">
                @csrf
                    <input type="hidden" id="article-id" value="{{$articleData->id}}">
                    <input type="hidden" id="article-content" value="{{$articleData->content}}">

                    
                    <textarea id="article-title" class="w-full text-3xl md:text-5xl font-bold text-center border-none overflow-hidden resize-none focus:outline-hidden min-h-[2.5rem] md:min-h-[3.5rem] transition-all focus:ring-0 " placeholder="Enter title" readonly="" rows="1" maxlength="80" aria-label="Lesson title" style="height: 56px;" value="{{$articleData->title}}">{{$articleData->title}}</textarea>
                    <p class="mt-1 ml-1 text-center text-sm text-gray-500 truncate sm:flex sm:items-center sm:justify-center">
                        {{$articleData->createdBy->name}} added this article on {{$articleData->created_at}}
                    </p>
                    <div class="quillHeader flex flex-col h-full mx-4">
                        <div class="grow relative">
                            <div class="quill h-full mb-12" style="line-height: 2rem;">
                                <div class="ql-container ql-snow ql-disabled">
                                    <div class="ql-editor" data-gramm="false" contenteditable="false" data-placeholder="Write something...">
                                        {!! $articleData->content !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </form>
                
            </div>
        </div>
    </main>


    <div id="restoreArticleModal" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <input type="hidden" id="article_id" value="">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="restoreArticleModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg> 
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-400">Are you sure you want to restore this article?</h3>
                    <p class="mb-5 font-xs text-gray-500">Once this article is restored, its content will also be restored and users will be able
                        to see it.
                    </p> 
                    <button onclick="restoreArticle()" data-modal-hide="restoreArticleModal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">Yes, I'm sure</button> 
                    <button data-modal-hide="restoreArticleModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                </div>
            </div>
        </div>
    </div>


    <div id="articleDeleteModal" data-modal-backdrop="static" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-md max-h-full">
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="articleDeleteModal">
				<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
				</svg> 
				<span class="sr-only">Close modal</span>
			</button>
			<div class="p-4 md:p-5 text-center">
				<svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"></path>
				</svg>
				<h3 class="text-lg font-bold text-gray-700 dark:text-gray-400">Are you sure you want to delete this article?</h3>
				<p class="mb-5 font-xs text-gray-500">All the information regarding this article will be lost and its content will also be
					lost. This is not reversible.
				</p> 
				<button onclick="deleteArticle()" data-modal-hide="articleDeleteModal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
					Yes, I'm sure
				</button> 
				<button data-modal-hide="articleDeleteModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
					No, cancel
				</button>
			</div>
		</div>
	</div>
</div>

    <script>
        function restoreArticleModal(article_id) {
            document.getElementById('article_id').value = article_id;
        }

        function restoreArticle() {
            var article_id = document.getElementById("article_id").value;

            const formData = new FormData();
            formData.append('status', '1');
            
            
            fetch('{{route("articles.updateArticleStatus", ["article_id" => ":article_id"])}}'.replace(':article_id', article_id), {
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
                    
                    const articleData = data.data;
                    const workspace_slug = articleData.module.workspace.slug;
                    const module_slug = articleData.module.slug;
                    const article_slug = articleData.slug;
                    window.location.href = "{{ route('articles.articleDetails', ['workspace_slug' => ':workspace_slug', 'module_slug' => ':module_slug', 'article_slug' => ':article_slug']) }}"
                            .replace(':workspace_slug', workspace_slug)
                            .replace(':module_slug', module_slug)
                            .replace(':article_slug', article_slug);
                } else {
                    toastify.error(data.message);
                    console.log(data.message);
                }   
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }


        function deleteArticleModal(article_id) {
            document.getElementById('article_id').value = article_id;
        }

        function deleteArticle() {
            const article_id = document.getElementById('article_id').value;
            console.log("article_id: ",article_id);
            const formData = new FormData();
            
            formData.append('article_id', article_id);

            fetch('{{route("adminland.deleteArticle", ["article_id" => ":article_id"])}}'.replace(':article_id', article_id), {
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
                    toastify.success(data.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('adminland.archivedarticles') }}";
                    }, 1000);
                } else {
                    toastify.error(data.errors);
                    console.log(data.errors);
                }
            })
            .catch(error => {
                toastify.error("Something went wrong.");
                console.error('Error:', error);	
            });
        }
    </script>

@endsection