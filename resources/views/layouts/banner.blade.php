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
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">Quick KB</h2>
    </a>
    <p class="mt-2 text-lg text-pretty text-gray-700 sm:text-xl/8">
        Search through Quick KB's knowledge base to get the answer to your question.
    </p>

    <div class="mb-2">
        <input
            type="text"
            placeholder="What can we help you with? Search with for a topic or question..."
            class="bg-gray-50 mt-1 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            id="search-input" 
            value="{{ request()->get('search', '') }}"
        />
    </div>
    <div id="search-results"></div>
</div> 

<style>
    .draggable-ghost {
        background-color: #f3f4f6;
        border: 2px dashed #4f46e5;
        opacity: 0.5;
    }

    .dark .draggable-ghost {
        background-color: #374151;
        border-color: #6366f1;
    }

    .draggable-chosen {
        background-color: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .dark .draggable-chosen {
        background-color: #1f2937;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    }

    .draggable-drag {
        opacity: 0.8;
    }

    .drag-handle {
        cursor: move;
        cursor: -webkit-grabbing;   
    }

    /* Optional: Hover effect for drag handle */
    .drag-handle:hover {
        color: #4f46e5;
    }

    .dark .drag-handle:hover {
        color: #6366f1;
    }
</style>


<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results');

        searchInput.addEventListener('keypress', function(e) {
            const query = this.value.trim();
            const type = this.dataset.type;

            // Check if Enter key is pressed and query length is at least 3
            if (e.key === 'Enter') {
                e.preventDefault();

                // Get current URL and create URL object
                const currentUrl = new URL(window.location.href);
                
                // Set or update the search parameter
                if(query.length >= 3) {
                    if (query) {
                        currentUrl.searchParams.set('search', query);
                    } else {
                        currentUrl.searchParams.delete('search');
                    }
                } else {
                    currentUrl.searchParams.delete('search');
                }
                
                
                // Navigate to the new URL
                window.location.href = currentUrl.toString();
            }
        });


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
    
    
</script>
    