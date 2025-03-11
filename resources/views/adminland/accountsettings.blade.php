@extends('adminland.common.layout')
@section('content')
<main class="max-w-xl pb-12 px-4 lg:col-span-6">
    <div>
        <h1 class="text-lg font-semibold dark:text-white">Account Settings</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Configure your account settings</p>
        <form id="accountSettingsForm" action="/adminland/accountsettings" method="POST">
            @csrf
            <div>
                <h1 class="text-md font-semibold dark:text-white mt-6">Theme Color</h1>
                <p class="text-gray-500 dark:text-gray-400 text-xs">
                    Change theme color to match your brand color
                </p>

                <div class="flex flex-wrap mt-2">
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["color"] == "red") checked @endif
                            id="red-radio"
                            type="radio"
                            value="red"
                            name="theme_color"  
                            class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="red-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Red</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["color"] == "green") checked @endif
                            id="green-radio"
                            type="radio"
                            value="green"
                            name="theme_color"
                            class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="green-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Green</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["color"] == "blue") checked @endif
                            id="blue-radio"
                            type="radio"
                            value="blue"
                            name="theme_color"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="blue-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Blue</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["color"] == "teal") checked @endif
                            id="teal-radio"
                            type="radio"
                            value="teal"
                            name="theme_color"
                            class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="teal-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Teal</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["color"] == "yellow") checked @endif
                            id="yellow-radio"
                            type="radio"
                            value="yellow"
                            name="theme_color"
                            class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="yellow-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yellow</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["color"] == "orange") checked @endif
                            id="orange-radio"
                            type="radio"
                            value="orange"
                            name="theme_color"
                            class="w-4 h-4 text-orange-500 bg-gray-100 border-gray-300 focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="orange-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Orange</label>
                    </div>
                </div>
            </div>
            
            <div>
                <h1 class="text-md font-semibold dark:text-white mt-8">Theme Spacing</h1>
                <p class="text-gray-500 dark:text-gray-400 text-xs">
                    Change how much space you want between elements
                </p>

                <div class="flex flex-wrap mt-2">
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["theme_spacing"] == "default") checked @endif
                            id="default-radio"
                            type="radio"
                            value="default"
                            name="theme_spacing"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="default-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Default</label>
                    </div>
                    <div class="flex items-center me-4">
                        <input
                            @if($userSettings["themeData"]["theme_spacing"] == "compact") checked @endif
                            id="compact-radio"
                            type="radio"
                            value="compact"
                            name="theme_spacing"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                        <label
                            for="compact-radio"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Compact</label>
                    </div>
                </div>
            </div>

            <div>
                <h1 class="text-md font-semibold dark:text-white mt-8">Knowledge Base Name</h1>
                <p class="text-gray-500 dark:text-gray-400 text-xs">
                    Change name of your knowledge base. It will be displayed in the header among other
                    public pages.
                </p>
                <div class="flex-row flex w-full">
                    <input
                        type="text"
                        id="knowledge_base_name"
                        name="knowledge_base_name"
                        class="bg-gray-50 mt-2 me-2 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{$userSettings['knowledgeBase']['knowledge_base_name']??''}}"
                        required />
                    <button
                        type="submit"
                        class="text-white mt-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm w-full sm:w-auto px-5 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >Save</button>
                </div>
            </div>
        </form>
    </div>
</main>

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
@endsection 