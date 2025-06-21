{{--

    This component is used to display a confirmation dialog before submitting forms.
    It can be used with any form that requires user confirmation.

    To use it:
    1. Add the class "confirm-dialog-form" to your form
    2. Set the data-confirm-message attribute with the message you want to display in the dialog.
    3. Add the <x-confirm-dialog /> component anywhere after the form(s) that use it, so that the DOM elements are available when the script runs.

    The dialog will automatically handle the confirmation and submission of the form.

    Example:
    <form method="POST" action="/your-action" class="confirm-dialog-form" data-confirm-message="Are you sure?">
         ...
    </form>

    <x-confirm-dialog />

--}}


<!-- Confirm Dialog -->
<div id="confirmOverlay" class="fixed inset-0 bg-black/50 items-center justify-center z-50 backdrop-blur-[1.5px] hidden">
    <div class="bg-white w-full max-w-md mx-4 p-6 rounded-xl shadow-lg text-left relative">
        <p id="confirmMessage" class="text-lg font-medium mb-6">هل أنت متأكد؟</p>
        <div class="flex justify-end gap-4">
            <button id="confirmYes"
                class="bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition">
                Confirm
            </button>
            <button id="confirmNo"
                class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition">
                Cancel
            </button>
        </div>
    </div>
</div>

<script defer>
    var overlay = document.getElementById('confirmOverlay');
    var messageEl = document.getElementById('confirmMessage');
    var confirmYes = document.getElementById('confirmYes');
    var confirmNo = document.getElementById('confirmNo');

    var confirmCallback = null;

    function showConfirm(message, onConfirm) {
        messageEl.textContent = message;
        confirmCallback = onConfirm;
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        // stop background scrolling
        document.body.style.overflow = 'hidden';
    }

    function closeConfirm() {
        overlay.classList.remove('flex');
        overlay.classList.add('hidden');
        confirmCallback = null;

        // allow background scrolling again
        document.body.style.overflow = '';
    }

    confirmYes.addEventListener('click', () => {
        if (typeof confirmCallback === 'function') confirmCallback();
        closeConfirm();
    });

    confirmNo.addEventListener('click', closeConfirm);

    // إغلاق عند الضغط خارج الصندوق
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeConfirm();
    });

    // عام لجميع الفورمات التي تستخدم كلاس confirm-dialog-form
    document.querySelectorAll('.confirm-dialog-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const message = form.dataset.confirmMessage || 'Are you sure you want to proceed?';
            e.preventDefault();
            showConfirm(message, () => {
                form.submit();
            });
        });
    });
</script>
