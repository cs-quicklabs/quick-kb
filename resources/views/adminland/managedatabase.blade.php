@extends('adminland.common.layout')
@section('content')
    <main class="max-w-xl pb-12 px-4 lg:col-span-6">
        <div>
            <h1 class="text-lg font-semibold dark:text-white">Manage Database</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Import/Export Database</p>

            <div>
                <h1 class="text-md font-semibold dark:text-white mt-6">Export Database</h1>
                <p class="text-gray-500 dark:text-gray-400 text-xs">
                    Export database to a .sqlite file. You can use this file to import the database in
                    another knowledge base or keep it as back to replace the current database in future.
                </p>
                <button onclick="exportDatabase()" class="btn-primary mt-2"> Export Database </button>
            </div>
            <div>
                <h1 class="text-md font-semibold dark:text-white mt-6">Import Database</h1>
                <p class="text-gray-500 dark:text-gray-400 text-xs">
                    Import an .sqlite file to replace the current database. This will delete all the current
                    data in the database and replace it with the data in the .sqlite file. Make sure to keep
                    a backup of the current database before importing a new one.
                </p>
                <button class="btn-secondary mt-2"> Import Database </button>
            </div>
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

    <script>
        function exportDatabase() {
            const url = "{{ route('adminland.exportDatabase') }}";
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.file;
                } else {
                    toastify.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastify.error('An error occurred while exporting the database.');
            });
        }
    </script>

@endsection