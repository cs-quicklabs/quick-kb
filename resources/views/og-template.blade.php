<!DOCTYPE html>
<html class="h-full w-full">
<head>
  <meta charset="utf-8">
  @vite('resources/css/app.css') <!-- Tailwind CSS -->
  <style>
    body {
      width: 1200px;
      height: 630px;
    }
  </style>
</head>
<body class="flex items-center justify-center bg-gray-100 text-center">
  <div class="text-5xl font-bold text-gray-800">
    {{ $title }}
  </div>
</body>
</html>
