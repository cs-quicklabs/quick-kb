@extends('layouts.firstrun_layout')
@section('content')  
<div
                class="w-full bg-white rounded-sm shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign in to your account
                    </h1>
                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="space-y-4 md:space-y-6" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Your email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com"
                                required="" />
                            @error('email')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label
                                for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="" />
                            @error('password')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <a
                                href="/forgot-password"
                                class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
                                >Forgot password?</a>
                        </div>
                        <button
                            type="submit"
                            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-sm text-sm px-5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            >Sign in</button>
                    </form>

                    <p class="text-sm font-light text-gray-500 dark:text-gray-400 text-center">
                        <a
                            href="/signup"
                            class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                            >Don't have an account?</a>
                    </p>
                </div>
            </div>
@endsection