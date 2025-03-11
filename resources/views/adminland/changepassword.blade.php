@extends('adminland.common.layout')
@section('content')
<main class="max-w-xl pb-12 px-4 lg:col-span-6">
    <div>
        <h1 class="text-lg font-semibold dark:text-white">Change Password</h1> 
        <p class="text-gray-500 dark:text-gray-400 text-sm">Please change your password.</p> 
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif
        <form class="w-full mt-6" action="{{ route('adminland.updatepassword') }}" method="POST">
            @csrf
            <div class="mb-5 mt-6">
                <label for="old_password_or_recovery_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old Password or Recovery Code</label> 
                <input type="text" name="old_password_or_recovery_code" id="old_password_or_recovery_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required>
                @error('old_password_or_recovery_code')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> 
            <div class="mb-5">
                <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password</label> 
                <input type="password" name="new_password" id="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required>
                @error('new_password')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> 
            <div class="mb-5">
                <label for="new_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label> 
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required>
                @error('new_password_confirmation')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div> 
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
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