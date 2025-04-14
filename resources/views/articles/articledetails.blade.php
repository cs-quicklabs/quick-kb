@extends('layouts.article_layout')
@section('content')
    <meta property="og:url" content="{{url()->current()}}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$articleData->title?? ''}}">
    <meta property="og:description" content="{{getShortTitle(getCleanContent($articleData->content?? ''), 100)}}">
    <meta property="og:site_name" content="{{getKnowledgeBase()}}">


    <main class="max-w-screen-2xl mx-auto mt-16 py-3 md:px-4 sm:py-5 lg:px-8" style="--breadcrumb-color: {{ $color }};">
        <div class="-mt-4">

            <div class="flex justify-center px-4 pb-4 pt-5 sm:px-6 lg:px-8">
                <nav class="flex justify-self-center flex-wrap" aria-label="Breadcrumb">
                    <ol class="inline-flex justify-self-center flex-wrap align-center justify-center rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="/" class="breadcrumb-link inline-flex items-center text-sm font-medium text-gray-700  dark:text-gray-400 dark:hover:text-white hover:underline">
                                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"></path>
                                </svg> Home
                            </a>
                        </li>
                        <li class="inline-flex items-center">
                            <div class="flex items-center">
                                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                                </svg> <a href="{{route('modules.modules', ['workspace_slug' => $articleData->module->workspace->slug])}}" class="breadcrumb-link truncate max-w-xs ms-1 text-sm font-medium text-gray-700 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline">{{getShortTitle($articleData->module->workspace->title??"", 50)}}</a>
                            </div>
                        </li>
                        <li class="inline-flex items-center">
                            <div class="flex items-center"><svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                                </svg> <a href="{{route('articles.articles', ['workspace_slug' => $articleData->module->workspace->slug, 'module_slug' => $articleData->module->slug])}}" class="breadcrumb-link truncate max-w-xs ms-1 text-sm font-medium text-gray-700 md:ms-2 dark:text-gray-400 dark:hover:text-white hover:underline">{{getShortTitle($articleData->module->title??'', 50)}}</a></div>
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
                    <p
                        class="mt-1 ml-1 text-center text-sm text-gray-500 truncate sm:flex sm:items-center sm:justify-center">
                        {{$articleData->createdBy->name}} added this article on {{$articleData->created_at}}
                    </p>
                    <div class="quillHeader flex flex-col h-full mx-4" style="--link-color: {{ $color }};">
                        @auth    
                            <div class="mx-auto my-4 px-4 sticky top-12 z-10 flex flex-col md:flex-row rounded-full md:h-11 md:w-max items-center gap-1 py-3 md:py-0 bg-zinc-200 md:w-min ql-toolbar ql-snow" id="toolbar">
                            
                                <div class="flex items-center gap-2 w-full md:w-auto justify-center md:justify-center">
                                    <div class="flex items-center gap-2">
                                        <button onclick="viewMode()" type="button" class="custom-quill-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" height="24" width="24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                            </svg>
                                        </button>

                                        <label for="toggle" class="inline-flex items-center cursor-pointer" aria-label="Toggle editing mode">
                                            <input id="toggle" class="sr-only peer" type="checkbox" onchange="toggleEditorMode()">
                                            <div id="toggle-div" class="relative w-11 h-6 bg-gray-400 peer-focus:outline-hidden rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-{{$color}}-700"></div>
                                        </label>

                                        <button onclick="editMode()" type="button" class="custom-quill-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon" height="24" width="24">
                                                <path d="m2.695 14.762-1.262 3.155a.5.5 0 0 0 .65.65l3.155-1.262a4 4 0 0 0 1.343-.886L17.5 5.501a2.121 2.121 0 0 0-3-3L3.58 13.419a4 4 0 0 0-.885 1.343Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="w-full h-px bg-white md:hidden"></div>

                                <div id="toolbar-div" class="items-center w-full md:w-auto justify-center md:border-l-2 md:border-l-white gap-1 px-2 md:mx-2 hidden md:border-r-2 md:border-r-white ">
                                    <span class="ql-formats" style="margin: 0px;">
                                        <select class="ql-header" defaultValue="3">
                                            <option value="1">Heading 1</option>
                                            <option value="2">Heading 2</option>
                                            <option value="3" selected="">Normal</option>
                                        </select>
                                    </span>
                                        
                                        
                                    <span class="ql-formats" >
                                        <button type="button" class="ql-bold" ></button>
                                        <button type="button" class="ql-italic" ></button>
                                        <button type="button" class="ql-blockquote" ></button>
                                        <button type="button" class="ql-code-block" ></button>
                                        <button type="button" class="ql-link" ></button>
                                        <button type="button" class="ql-list" value="bullet" ></button>
                                        <button type="button" class="ql-list" value="ordered" ></button>
                                        <button type="button" class="ql-strike" ></button>
                                        <button type="button" class="ql-underline" ></button>
                                        <button type="button" class="ql-image" ></button>
                                    </span>
                                </div>
                           
                            </div>
                        @endauth
                        <div class="grow relative" style="--link-color: {{ $color }};">
                            <div class="quill h-full mb-12" style="line-height: 2rem;">
                                <div id ="editor" ></div>
                            </div>
                        </div>
                    </div>

                    <button onclick="updateArticle(1)" id="submit-btn" type="submit" class="hidden fixed bottom-4 right-4 rounded-full bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:bg-gray-500" >
                        Save & Publish
                    </button>
                </form>
                
                <button onclick="updateArticle(2)" id="draft-btn" type="button" class="hidden fixed bottom-4 left-4 rounded-full bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:bg-gray-500">
                    Save as Draft
                </button>
            </div>
        </div>
    </main>

    <!-- Footer -->
     @if(!Auth::check())
     <footer class="bg-white dark:bg-gray-800">
        <div class="p-4 mx-auto max-w-screen-xl sm:p-8 lg:p-10">
            <p class="text-xl font-bold leading-tight text-center dark:text-white">
                Did this article help you in any way?
            </p> 
            <div class="flex justify-center items-center my-6">
                <div class="flex items-center" id="like-article">
                    <svg onclick="likeArticle(1)" class="w-8 h-8 ms-3 @if($articleData->average_rating >= 1) text-yellow-300 @else text-gray-300 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg> 
                    <svg onclick="likeArticle(2)" class="w-8 h-8 ms-3 @if($articleData->average_rating >= 2) text-yellow-300 @else text-gray-300 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg> 
                    <svg onclick="likeArticle(3)" class="w-8 h-8 ms-3 @if($articleData->average_rating >= 3) text-yellow-300 @else text-gray-300 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg> 
                    <svg onclick="likeArticle(4)" class="w-8 h-8 ms-3 @if($articleData->average_rating >= 4) text-yellow-300 @else text-gray-300 @endif" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg> 
                    <svg onclick="likeArticle(5)" class="w-8 h-8 ms-3 @if($articleData->average_rating >= 5) text-yellow-300 @else text-gray-300 @endif dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"></path>
                    </svg>

                    <p id="average-rating" class="ms-3 mt-1 text-md font-medium text-gray-500 dark:text-gray-400">( {{$articleData->average_rating}} out of 5)</p>

                </div>
            </div>
        </div>
    </footer>
     @endif
    
    <!-- Footer -->

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Disable Editing Initially
            function disabledQuill(){
                // Disable Editing Initially
                setTimeout(() => {
                    if (typeof quill.enable === "function") {
                        quill.enable(false);

                        // Load the content from the hidden input field
                        const articleContent = document.getElementById("article-content")?.value || "";

                        if (articleContent.trim() !== "") {
                            quill.root.dataset.placeholder = "";
                            quill.root.innerHTML = articleContent;
                        }
                    } else {
                        console.error("Quill is not initialized properly!");
                    }
                }, 500);


                
            }

            disabledQuill();
            
        });


        // Function to enable/disable the editor
        function toggleEditorMode() {
            const checkbox = document.getElementById("toggle");

            if(checkbox.checked){
                document.querySelector('#toolbar').classList.remove('bg-zinc-200', 'md:w-min');
                document.querySelector('#toolbar').classList.add('bg-{{$color}}-100');

                document.querySelector('#toolbar-div').classList.remove('hidden');
                document.querySelector('#toolbar-div').classList.add('flex');

                document.getElementById("submit-btn").classList.remove('hidden');
                document.getElementById("draft-btn").classList.remove('hidden');

                document.querySelector('#toggle-div').classList.remove('bg-gray-400');
                document.querySelector('#toggle-div').classList.add('bg-{{$color}}-700');
            }else{
                document.querySelector('#toolbar').classList.remove('bg-blue-100');
                document.querySelector('#toolbar').classList.add('bg-zinc-200', 'md:w-min');

                document.querySelector('#toolbar-div').classList.remove('flex');
                document.querySelector('#toolbar-div').classList.add('hidden');

                document.getElementById("submit-btn").classList.add('hidden');
                document.getElementById("draft-btn").classList.add('hidden');

                document.querySelector('#toggle-div').classList.remove('bg-{{$color}}-700');
                document.querySelector('#toggle-div').classList.add('bg-gray-400');
            }
            
            document.getElementById("article-title").readOnly = !checkbox.checked;
            const isChecked = checkbox.checked;
            quill.enable(isChecked); // Enable or disable editor


        }

        function viewMode(){
            document.getElementById("toggle").checked = false;
            toggleEditorMode();
        }

        function editMode(){
            document.getElementById("toggle").checked = true;
            toggleEditorMode();
        }


        document.getElementById('article-form').addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission
        });

        function updateArticle(status){

            const articleId = document.getElementById("article-id").value;

            // Check if editor is empty (excluding HTML tags)
            const quillText = window.quill.getText().trim();
            if (quillText === "") {
                toastify.error("Please add some content.");
                return;
            }
            const title = document.getElementById("article-title").value.trim();
            if (title === "") {
                toastify.error("Please enter a title.");
                return;
            }

            const quillContent = quill.root.innerHTML; // Get Quill editor content

            // Prepare form data
            const formData = new FormData();
            formData.append("title", title);
            formData.append("content", quillContent);
            formData.append("article_id", articleId);
            formData.append("status", status);

            // Send data via fetch API
            fetch("{{ route('articles.update', ['article_id' => ':article_id']) }}".replace(':article_id', articleId), {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    toastify.success(data.message);
                    document.getElementById("toggle").checked = false;
                    toggleEditorMode();
                } else {
                    // Error handling
                    if (data.errors) {
                        if(typeof data.errors === 'object') {
                            Object.entries(data.errors).forEach(([key, messages])  => {
                                messages.forEach(message => {
                                    toastify.error(message);
                                });
                                
                            });
                        } else {
                            toastify.error(data.errors);
                        }

                    } else {
                        console.log(data);
                    }
                }
            })
            .catch(error => {
                toastify.error("Something went wrong.");
                console.error('Error:', error);
            });
        }



        function likeArticle(rating){
            const articleId = document.getElementById("article-id").value;
            const stars = document.querySelectorAll('#like-article svg');
        
            stars.forEach((star, index) => {
                console.log(index, rating);
                if (index < rating) {
                    star.classList.remove('text-gray-300', 'dark:text-gray-500');
                    star.classList.add('text-yellow-300');
                } else {
                    star.classList.remove('text-yellow-300');
                    star.classList.add('text-gray-300', 'dark:text-gray-500');
                }
            });

            const formData = new FormData();
            formData.append('rating', rating);
            formData.append('article_id', articleId);

            fetch("{{route('articles.like')}}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data.data);
                    toastify.success(data.message);
                    document.getElementById("average-rating").textContent = '(' + data.data.average_rating + ' out of 5)';
                } else {
                    toastify.error(data.errors);
                }
            })
            .catch(error => {
                toastify.error("Something went wrong.");
                console.error('Error:', error);
            });
        }
    </script>

@endsection