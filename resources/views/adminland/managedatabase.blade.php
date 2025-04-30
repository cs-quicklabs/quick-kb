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
                    another knowledge base or keep it as backup to replace the current database in future.
                </p>
                <button onclick="exportDatabase()" class="text-white bg-{{$color}}-700 hover:bg-{{$color}}-800 focus:ring-4 focus:outline-none focus:ring-{{$color}}-300 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-{{$color}}-600 dark:hover:bg-{{$color}}-700 dark:focus:ring-{{$color}}-800 mt-2"> Export Database </button>
            </div>
            <div>
                <h1 class="text-md font-semibold dark:text-white mt-6">Import Database</h1>
                <p class="text-gray-500 dark:text-gray-400 text-xs">
                    Import an .sqlite file to replace the current database. This will delete all the current
                    data in the database and replace it with the data in the .sqlite file. Make sure to keep
                    a backup of the current database before importing a new one.
                </p>
                <form id="importDatabaseForm" enctype="multipart/form-data">
                    @csrf
                    
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
                    <input class="block w-full text-xs text-{{$color}}-900 border border-{{$color}}-300 rounded-lg cursor-pointer bg-{{$color}}-50 dark:text-{{$color}}-400 focus:outline-none dark:bg-{{$color}}-700 dark:border-{{$color}}-600 dark:placeholder-{{$color}}-400" aria-describedby="file_input_help" id="file_input" type="file" name="database_file" accept=".sqlite" required>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Only sqlite files are allowed.</p>

                    @error('database_file')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="text-white bg-{{$color}}-700 hover:bg-{{$color}}-800 focus:ring-4 focus:outline-none focus:ring-{{$color}}-300 font-medium rounded text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-{{$color}}-600 dark:hover:bg-{{$color}}-700 dark:focus:ring-{{$color}}-800 mt-2"> Import Database </button>
                </form>
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
                    toastify.success(data.message);
                    window.open(data.data.path, '_blank');
                } else {
                    toastify.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastify.error('An error occurred while exporting the database.');
            });
        }


        document.getElementById('importDatabaseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const fileInput = document.getElementById('file_input');
            const formData = new FormData();
            formData.append('database_file', fileInput.files[0]);
            formData.append('_token', '{{ csrf_token() }}');
            const url = "{{ route('adminland.importDatabase') }}";
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastify.success(data.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastify.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastify.error('An error occurred while exporting the database.');
            });
        });
    </script>

@endsection