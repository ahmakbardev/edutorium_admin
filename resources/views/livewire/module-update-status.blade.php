<div class="block relative">
    <img src="{{ $module->image ? asset('storage/' . $module->image) : asset('assets/images/blog/blog-img-1.jpg') }}"
        class="h-32 max-h-32 w-full object-cover" alt="">
    <div class="dropdown absolute top-2 right-2">
        <button
            class="btn dropdown-toggle gap-x-2 bg-green-200 px-2 py-1 text-green-700 text-xs font-medium rounded-full inline-block whitespace-nowrap text-center"
            type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ $status }}
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item text-xs h-[unset] py-1.5" href="#"
                    wire:click.prevent="updateStatus('draft')">Draft</a></li>
            <li><a class="dropdown-item text-xs h-[unset] py-1.5" href="#"
                    wire:click.prevent="updateStatus('publish')">Publish</a></li>
        </ul>
    </div>
</div>
