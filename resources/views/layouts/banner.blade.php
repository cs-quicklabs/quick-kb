<div class="fixed top-4 right-4">
    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        @if(Auth::check())
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
                src="{{ asset('/images/2606517_5856.jpg') }}"
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
        @else
        <a href="{{ route('login') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
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
                    src="{{ asset('/images/2606517_5856.jpg') }}"
                    alt="user photo" />
            </button>
        </a>
        @endif
        

    </div>
</div>
<div class="max-w-3xl px-4 mx-auto lg:px-6 sm:py-8 lg:py-12">
    <a href="{{ url('/') }}">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{getKnowledgeBase()}}</h2>
    </a>
    <p class="mt-2 text-lg text-pretty text-gray-700 sm:text-xl/8">
        Search through {{getKnowledgeBase()}}'s knowledge base to get the answer to your question.
    </p>

    <div class="mb-2">
        <input
            type="text"
            placeholder="What can we help you with? Search with for a topic or question..."
            class="bg-gray-50 mt-1 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            id="search-input" 
            value="{{ request()->get('search', '') }}"
            autocomplete="off"
        />

        <div id="search-list-div" class="bg-white relative border border-gray-300 rounded hidden" id="search-results-container">
    
            <div class="p-4">
                <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Search Results:</h2>
                <ul id="search-list-ul" class="space-y-1 text-gray-500 list-none list-inside dark:text-gray-400">
                    <li class="text-sm ">
                        No results found.
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div id="search-results"></div>
</div> 



<script>
    document.addEventListener('DOMContentLoaded', function() {

        //Drag and drop modules
        const modulesList = document.getElementById('draggable-list');
        
        Sortable.create(modulesList, {
            animation: 150,
            ghostClass: 'draggable-ghost',
            chosenClass: 'draggable-chosen',
            dragClass: 'draggable-drag',
            handle: '.drag-handle', // if you want to use a specific handle
            onEnd: function(evt) {
                updateDraggableListOrder();
            }
        });

    });
    
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const resultsList = document.getElementById('search-list-ul');
        const searchListDiv = document.getElementById("search-list-div");

        let searchTimeout;

        let pathSegments = window.location.pathname.split('/').filter(segment => segment);
        let firstSegment = pathSegments.length > 0 ? pathSegments[0] : null;



        searchInput.addEventListener('keyup', function(e) {
            const query = this.value.trim();

            // Clear previous timeout
            clearTimeout(searchTimeout);

            // Fetch results only if the query length is more than 3 characters
            if (query.length > 2) {
                searchTimeout = setTimeout(() => {
                    fetchData(query, firstSegment);
                }, 300); // Delay request to prevent too many calls
            } else if(query.length === 0) {
                searchListDiv.classList.add("hidden");
                resultsList.innerHTML = `<li id="noResults" class="text-sm">No results found.</li>`;
                return;
            } else{
                searchListDiv.classList.remove("hidden");
                resultsList.innerHTML = `<li id="noResults" class="text-sm">Enter atleast 3 characters to search.</li>`;
                return;
            }
        });


        function fetchData(query, type) {
        
            fetch('{{route("search.content")}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    search: query,
                    type: type
                })
            })
            .then(response => response.json())
            .then(data => {
                displaySearchList(data.data);
            })
            .catch(error => console.error('Error fetching data:', error));
        }

        function displaySearchList(lists) {
            const routes = {
                modules: '{{ route("modules.modules", ":workspaceSlug") }}',
                articles: '{{ route("articles.articles", [":workspaceSlug", ":moduleSlug"]) }}', // Updated for two slugs
                //workspaces: '{{ route("workspaces.workspaces", ":slug") }}',
            };

            resultsList.innerHTML = ''; // Clear previous results

            if (lists.length === 0) {
                resultsList.innerHTML = `<li id="noResults" class="text-sm">No results found.</li>`;
                return;
            }

            searchListDiv.classList.remove("hidden");

            console.log(lists);
            
            lists.forEach((list, index) => {
                console.log(list);
                const li = document.createElement('li');
                const link = document.createElement('a'); // Create an anchor element
                if(list.parent !== null){
                    link.innerHTML = `<strong>${list.parent.title}</strong> > ${list.title}`; 
                } else {
                    link.textContent = list.title; // Set the text content to the title
                }
                
                
                link.href = list.link;

                link.className = 'block text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700'; // Add classes for styling

                // Append the link to the list item
                li.appendChild(link);

                if((index + 1) == lists.length){
                    li.classList.add('text-sm', 'cursor-pointer', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
                } else {
                    li.classList.add('text-sm', 'border-b', 'border-gray-300', 'pb-2', 'cursor-pointer', 'hover:bg-gray-100', 'dark:hover:bg-gray-700');
                }

                resultsList.appendChild(li);
            });
        }
    });
</script>
    