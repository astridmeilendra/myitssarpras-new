<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            overflow: hidden;
        }

        html {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-background flex items-center justify-center min-h-screen overflow-hidden">

    <div class="bg-card w-full max-w-[390px] h-[854px] rounded-xl shadow-mobile overflow-hidden">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.style.opacity = 1;
        });

        document.querySelectorAll('a[href]').forEach(link => {
            // Filter out external links, mailto, tel, and anchors
            if (link.hostname !== window.location.hostname ||
                link.protocol !== window.location.protocol ||
                link.href.startsWith('mailto:') ||
                link.href.startsWith('tel:') ||
                link.getAttribute('href').startsWith('#') ||
                link.getAttribute('target') === '_blank'
            ) {
                return;
            }

            link.addEventListener('click', e => {
                // Ignore clicks with modifier keys (e.g., Ctrl+Click, Cmd+Click)
                if (e.ctrlKey || e.metaKey) {
                    return;
                }

                e.preventDefault();
                const href = link.href;

                document.body.style.opacity = 0;

                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            });
        });
    </script>
</body>

</html>
