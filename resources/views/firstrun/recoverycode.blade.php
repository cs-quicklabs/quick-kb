@extends('layouts.firstrun_layout')
@section('content')  
<div
                class="w-full bg-white rounded-sm shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div
                    class="flex items-center p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <svg
                        class="w-4 h-4 me-3 text-green-800 dark:text-white shrink-0"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span class="sr-only">Info</span>
                    <div>
                        Your account has been created. Please save recovery code for future reference. These will
                        be needed to recovery your account if you forget your password.
                    </div>
                </div>
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Save Account Recovery Code
                    </h1>
                    <form class="space-y-4" action="{{ route('login') }}" method="GET">
                        <div>
                            <input
                                type="text"
                                name="recovery_code"
                                id="recovery_code"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-sm focus:ring-primary-600 focus:border-primary-600 block w-full p-1.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ $recoveryCode }}"
                                readonly />
                        </div>
                        <button
                            type="submit"
                            class="w-full mt-4 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-sm text-sm px-5 py-2 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            >Confirm and Login into account</button>
                    </form>
                </div>
            </div>
@endsection