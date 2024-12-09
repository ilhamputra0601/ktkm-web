<div id="mega-menu-full-dropdown" class="hidden mt-1 bg-white border-gray-200 shadow-sm border-y dark:bg-gray-800 dark:border-gray-600">
    <div class=" max-w-screen-xl px-4 py-5 mx-auto text-gray-900 dark:text-white sm:grid-cols-2 md:grid-cols-3 md:px-6">
        <ul class="flex flex-wrap" aria-labelledby="mega-menu-full-dropdown-button">
            @forelse ($divisions as $division)
            <li class="flex">
                <a href="#" class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                    <div class="font-semibold">{{ $division->name  }}</div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Connect with third-party tools that you're already using.</span>
                </a>
            </li>
            @empty
            <h1>empty</h1>
            @endforelse

        </ul>
    </div>
</div>
