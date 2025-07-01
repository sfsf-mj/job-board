{{--

    This component is used to display notifications to the user.
    It can show success, error, warning, or info messages with appropriate styling and icons.

    Valid types: 'success', 'error', 'warning', 'info'

    To use it:
    1. Include the component in your Blade view like this:
       <x-notification />
    2. Set the session variable 'notification' with the type and message you want to display.
        Example:
        session(['notification' => ['type' => 'success', 'message' => 'Your action was successful!']]);

        Example usage in a controller:
        public function index()
        {
            return redirect('/blog')->with('notification', [
                'title' => 'Success!',
                'type' => 'info',
                'message' => 'Comments are not listed separately. Please visit a post to view its comments.'
            ]);
        }

    The component will automatically handle the display and styling based on the type.

--}}


@if (session('notification'))
    <div
        id="notification"
        class="fixed top-[70px] left-1/2 transform -translate-x-1/2 z-50 w-max max-w-md rounded-xl shadow-lg p-4 flex items-center gap-6 transition-all duration-500 opacity-0 scale-90"
        data-type="{{ session('notification.type') }}">

        <!-- Icon -->
        <div id="notif-icon" class="text-green-600 shrink-0">
            <!-- سيتم استبداله بواسطة JS -->
        </div>

        <!-- Message Content -->
        <div class="flex-1 text-sm w-max">
            <p id="notif-title" class="font-bold text-green-800 mb-1">{{ session('notification.title') }}</p>
            <p class="text-green-800">{{ session('notification.message') }}</p>
        </div>

        <!-- Close Button -->
        <button id="close-btn" onclick="document.getElementById('notification').remove()" class="hover:text-gray-700 text-[20px] font-semibold">
            X
        </button>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const notification = document.getElementById("notification");
        if (notification) {
            const type = notification.dataset.type;

            const config = {
                success: {
                    bg: 'bg-green-100',
                    text: 'text-green-800',
                    icon: `
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        </svg>`,
                    title: 'success!',
                    cancel: 'text-green-600'
                },
                error: {
                    bg: 'bg-red-100',
                    text: 'text-red-800',
                    icon: `
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9l-6 6m0-6l6 6" />
                        </svg>`,
                    title: 'error!',
                    cancel: 'text-red-600'
                },
                warning: {
                    bg: 'bg-yellow-100',
                    text: 'text-yellow-800',
                    icon: `
                        <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
                        </svg>`,
                    title: 'warning!',
                    cancel: 'text-yellow-600'
                },
                info: {
                    bg: 'bg-blue-100',
                    text: 'text-blue-800',
                    icon: `
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8h.01M12 12v4" />
                        </svg>`,
                    title: 'info!',
                    cancel: 'text-blue-600'
                }
            };

            const selected = config[type] || config.info;

            // Apply classes and content
            notification.classList.add(selected.bg);
            notification.querySelector('#notif-title').textContent = selected.title;
            notification.querySelector('#notif-title').className = `font-bold mb-1 ${selected.text}`;
            notification.querySelector('p.text-green-800').className = selected.text;
            document.getElementById('notif-icon').innerHTML = selected.icon;
            document.getElementById('close-btn').classList.add(selected.cancel);

            // Animation In
            setTimeout(() => {
                notification.classList.remove('opacity-0', 'scale-90');
                notification.classList.add('opacity-100', 'scale-100');
            }, 100);

            // Auto remove
            setTimeout(() => {
                notification.classList.remove('opacity-100', 'scale-100');
                notification.classList.add('opacity-0', 'scale-90');
                setTimeout(() => {
                    notification.remove();
                }, 1000);
            }, 10000);
        }
    });
</script>
