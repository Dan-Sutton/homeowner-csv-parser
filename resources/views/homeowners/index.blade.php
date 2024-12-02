<!DOCTYPE html>
<html>
<head>
    <title>Homeowner Names Parser</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Upload Homeowner CSV</h1>
        <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <input type="file" name="csv_file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Upload</button>
        </form>

        <form action="{{ route('reset') }}" method="POST">
            @csrf
            <button type="submit" class="mt-4 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Reset</button>
        </form>

        @if(isset($people))
            <h2 class="text-xl font-semibold mb-4">Parsed People</h2>
            <ul class="list-none pl-5 space-y-2">
                @foreach($people as $person)
                    <li class="bg-gray-50 p-4 rounded shadow">
                        <span class="font-semibold">Title:</span> {{ $person['title'] }}
                        <span class="font-semibold">First Name:</span> {{ $person['first_name'] ?? 'N/A' }}
                        <span class="font-semibold">Initial:</span> {{ $person['initial'] ?? 'N/A' }}
                        <span class="font-semibold">Last Name:</span> {{ $person['last_name'] }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>