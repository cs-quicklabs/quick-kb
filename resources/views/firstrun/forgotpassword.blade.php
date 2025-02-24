@extends('layouts.firstrun_layout')
@section('content')  
<div
                class="w-full p-6 bg-white rounded-sm shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
                <h2
                    class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Forgot Password?
                </h2>
                <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" action="{{ route('validate.recovery.code') }}" method="POST">
                    @csrf
                    <div>
                        <label for="recovery_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Enter recovery code to recover password. Recovery code was created when you signed up.
                        </label>
                        <input
                            type="text"
                            name="recovery_code"
                            id="recovery_code"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter recovery code"
                            required />
                        @error('recovery_code')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-sm text-sm px-5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                        >Confirm recovery code and reset password</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                        <a
                            href="/login"
                            class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                            >Return Back to Login</a>
                    </p>
                </form>
            </div>
@endsection