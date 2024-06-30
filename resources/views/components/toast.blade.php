<div id="toast-container" class="fixed top-4 right-4 flex flex-col space-y-2 z-[200]">
    @if (session('success'))
        <div
            class="own-toast bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-lg rounded transform transition-transform duration-300 translate-y-[-10px] opacity-0">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div
            class="own-toast bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-lg rounded transform transition-transform duration-300 translate-y-[-10px] opacity-0">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div
            class="own-toast bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 shadow-lg rounded transform transition-transform duration-300 translate-y-[-10px] opacity-0">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="text-sm">{{ session('warning') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('info'))
        <div
            class="own-toast bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 shadow-lg rounded transform transition-transform duration-300 translate-y-[-10px] opacity-0">
            <div class="flex items-center">
                <div class="ml-3">
                    <p class="text-sm">{{ session('info') }}</p>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('.own-toast').each(function(index) {
            $(this).delay(index * 300).queue(function(next) {
                $(this).removeClass('translate-y-[-10px] opacity-0').addClass(
                    'translate-y-0 opacity-100');
                next();
            }).delay(3000).queue(function(next) {
                $(this).removeClass('translate-y-0 opacity-100').addClass(
                    'translate-y-[-10px] opacity-0');
                next();
            }).delay(300).queue(function(next) {
                $(this).remove();
                next();
            });
        });
    });
</script>
