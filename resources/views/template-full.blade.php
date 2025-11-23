<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'My App' }}</title>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    {{-- Tailwind via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Optional: Tailwind Custom Config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        manrope: ['Manrope', 'sans-serif'],
                    },
                    colors: {
                        background: '#F9FAFB',
                        card: '#FFFFFF',
                    },
                    boxShadow: {
                        'mobile': '0 6px 15px rgba(0, 0, 0, 0.08)',
                    },
                    borderRadius: {
                        'xl': '20px',
                    },
                },
            },
        };
    </script>

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }
    </style>
</head>

<body class="bg-background flex items-center justify-center min-h-screen">

    <div class="bg-card w-full max-w-[390px] h-[854px] rounded-xl shadow-mobile overflow-hidden">
        @yield('content')
    </div>

</body>

</html>
