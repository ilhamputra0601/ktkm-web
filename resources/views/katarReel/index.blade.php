<x-app title="{{ __('navigation.nav-home') }}">
    <section class="">
                <!-- component -->
                <div class="overflow-x-auto max-w-xl mx-auto flex m-4 space-x-4">
                    @foreach ($divisions as $division)
                        <figure class="max-w-lg text-center">
                            <div class="w-20 h-20 m-1 rounded-full overflow-hidden ring-2 ring-gray-300 dark:ring-gray-500">
                                <img
                                    class="w-full h-full object-cover"
                                    src="{{ asset($division->logo_url) }}"
                                    alt="image description">
                            </div>
                            <figcaption class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                {{ $division->name }}
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
                <livewire:Components.Reels.Card.index-card>

    </section>
    {{-- Partials --}}
    {{-- <x-partials.pages.katarreel.BottomNavigation/> --}}
</x-app>
