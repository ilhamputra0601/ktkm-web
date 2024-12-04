<div>

    <!-- component -->
    @forelse ($posts as $post)
<div class="bg-gray-100 h-screen flex items-center justify-center">
	<div class="bg-white p-8 rounded-lg shadow-md max-w-md">
		<!-- User Info with Three-Dot Menu -->
		<div class="flex items-center justify-between mb-4">
			<div class="flex items-center space-x-2">
				<img src="{{ $post->user->division->logo_url }}" alt="User Avatar" class="w-8 h-8 rounded-full">
					<p class="text-gray-800 font-semibold">{{ $post->user->division->name  }}</p>
			</div>
			<div class="text-gray-500 cursor-pointer">
				<!-- Three-dot menu icon -->
				<button class="hover:bg-gray-50 rounded-full p-1">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="7" r="1" />
						<circle cx="12" cy="12" r="1" />
						<circle cx="12" cy="17" r="1" />
					</svg>
				</button>
			</div>
		</div>
		<!-- Image -->
		<div class="mb-4">
                <div id="default-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        @foreach ($post->images as $item)
                        <!-- Item  -->
                        <div class="hidden duration-700 ease-in-out" data-carousel-item>
                            <img src="{{ $item }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                        </div>
                        @endforeach
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
                    </div>
                    <!-- Slider controls -->
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                </div>
		</div>
        <!-- User Info with Three-Dot Menu -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <img src="{{ $post->user->avatar_url }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                <div>
                    <p class="text-gray-800 font-semibold">{{ $post->user->name }}</p>
                    <p class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

        </div>
        <!-- Message -->
        <div class="mb-4">
            <p class="text-gray-800">{!! $post->content !!}</p>
        </div>


		<!-- Like and Comment Section -->
		<div class="flex items-center justify-between text-gray-500">
			<div class="flex items-center space-x-2">
				<button class="flex justify-center items-center gap-2 px-2 hover:bg-gray-50 rounded-full p-1">
					<svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
						<path d="M12 21.35l-1.45-1.32C6.11 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-4.11 6.86-8.55 11.54L12 21.35z" />
					</svg>
					<span>42 Likes</span>
				</button>
			</div>
			<button class="flex justify-center items-center gap-2 px-2 hover:bg-gray-50 rounded-full p-1">
				<svg width="22px" height="22px" viewBox="0 0 24 24" class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg">
					<g id="SVGRepo_bgCarrier" stroke-width="0"></g>
					<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
					<g id="SVGRepo_iconCarrier">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22ZM8 13.25C7.58579 13.25 7.25 13.5858 7.25 14C7.25 14.4142 7.58579 14.75 8 14.75H13.5C13.9142 14.75 14.25 14.4142 14.25 14C14.25 13.5858 13.9142 13.25 13.5 13.25H8ZM7.25 10.5C7.25 10.0858 7.58579 9.75 8 9.75H16C16.4142 9.75 16.75 10.0858 16.75 10.5C16.75 10.9142 16.4142 11.25 16 11.25H8C7.58579 11.25 7.25 10.9142 7.25 10.5Z"></path>
					</g>
				</svg>
				<span>3 Comment</span>
			</button>
		</div>
		<hr class="mt-2 mb-2">
		<p class="text-gray-800 font-semibold">Comment</p>
		<hr class="mt-2 mb-2">
		<div class="mt-4">
			<!-- Comment 1 -->
			<div class="flex items-center space-x-2">
				<img src="https://placekitten.com/32/32" alt="User Avatar" class="w-6 h-6 rounded-full">
				<div>
					<p class="text-gray-800 font-semibold">Jane Smith</p>
					<p class="text-gray-500 text-sm">Lovely shot! 📸</p>
				</div>
			</div>
			<!-- Comment 2 -->
			<div class="flex items-center space-x-2 mt-2">
				<img src="https://placekitten.com/32/32" alt="User Avatar" class="w-6 h-6 rounded-full">
				<div>
					<p class="text-gray-800 font-semibold">Bob Johnson</p>
					<p class="text-gray-500 text-sm">I can't handle the cuteness! Where can I get one?</p>
				</div>
			</div>
			<!-- Reply from John Doe with indentation -->
			<div class="flex items-center space-x-2 mt-2 ml-6">
				<img src="https://placekitten.com/40/40" alt="User Avatar" class="w-6 h-6 rounded-full">
				<div>
					<p class="text-gray-800 font-semibold">John Doe</p>
					<p class="text-gray-500 text-sm">That little furball is from a local shelter. You should check it out! 🏠😺</p>
				</div>
			</div>
			<!-- Add more comments and replies as needed -->
		</div>
	</div>
</div>
@empty
<h1>tidak ada postingan</h1>
@endforelse
</div>
