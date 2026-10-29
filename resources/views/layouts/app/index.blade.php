<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-density="medium" data-overlayscrollbars-initialize>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    <script>
        const theme = localStorage.getItem('app-theme') || 'braunish';
        const accent = localStorage.getItem('app-accent') || 'natur';

        document.documentElement.setAttribute('data-theme', theme);
        document.documentElement.setAttribute('data-accent', accent);
    </script>
    <script>
        window.applyTheme = () => {
            const theme = localStorage.getItem('theme') || 'system';
            const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)')
                .matches);

            // 1. Создаем стиль для мгновенной заморозки всех транзиций
            const disableTransitions = document.createElement('style');
            disableTransitions.innerHTML = `
        *, *::before, *::after {
            -webkit-transition: none !important;
            -moz-transition: none !important;
            -o-transition: none !important;
            -ms-transition: none !important;
            transition: none !important;
        }
    `;
            document.head.appendChild(disableTransitions);

            // 2. Меняем класс темы
            document.documentElement.classList.toggle('dark', isDark);

            // 3. Принудительный Reflow, чтобы браузер применил цвета немедленно
            window.getComputedStyle(document.documentElement).opacity;

            // 4. Удаляем заморозку в следующем кадре анимации
            requestAnimationFrame(() => {
                // Дополнительная микро-пауза гарантирует, что стили "устоялись"
                setTimeout(() => {
                    if (document.head.contains(disableTransitions)) {
                        document.head.removeChild(disableTransitions);
                    }
                }, 1);
            });
        };

        // Запуск при загрузке
        window.applyTheme();

        document.addEventListener('alpine:init', () => {
            // Перехватываем установку темы в Alpine
            // Мы создаем обертку вокруг функций твоего объекта $theme
            const themeStore = Alpine.store('theme') || {};

            // Если у тебя используется глобальный магический объект $theme,
            // нам нужно слушать изменение класса на html
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        // Как только класс изменился (тема переключилась)
                        // вызываем applyTheme, чтобы она прогнала цикл блокировки
                        // Но чтобы не было бесконечного цикла, делаем это аккуратно
                        window.applyTheme();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Твоя логика размеров сайдбара
        (function() {
            const isMobile = window.matchMedia('(max-width: 767px)').matches;
            const isTablet = window.matchMedia('(min-width: 768px) and (max-width: 1023px)').matches;
            const savedCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            const collapsed = isMobile ? false : (isTablet ? true : savedCollapsed);
            document.documentElement.style.setProperty(
                '--sidebar-initial-width',
                isMobile ? '0px' : (collapsed ? '4rem' : '20rem')
            );
            if (collapsed) {
                document.documentElement.setAttribute('data-sidebar-collapsed', '');
            }
            document.documentElement.style.setProperty('--header-height', '90px');
        })();
    </script>

    @livewireStyles
</head>

<body class="bg-(--color-neutral-100) dark:bg-(--color-neutral-900) subpixel-antialiased">
    {{ $slot }}

    <x-ui.toast />
    {{-- @livewireScripts --}}
</body>

</html>
