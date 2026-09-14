@props(['title' => 'SUAPNE'])

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="icon" href="{{ asset('storage/img/logo-cnapne-sem-texto.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen bg-white font-sans text-black antialised flex flex-col w-full min-w-[min-content]">
    
    {{ $slot }}
    
    @livewireScripts
</body>

<script>
    Livewire.on('refresh-page', (status) => {
        location.reload();
    });
</script>

</html>
