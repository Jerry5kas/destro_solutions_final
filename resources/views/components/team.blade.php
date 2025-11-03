<!-- Slides Loop -->
<div class="w-full" data-reveal-scope data-reveal>
    <div
        class="w-full h-full flex items-center justify-center relative border-b border-gray-300"
    >
        <!-- White overlay -->
        {{--        <div class="absolute inset-0 bg-white/75 backdrop-blur-[1px] z-0"></div>--}}
        <!-- Grid lines - Hidden on mobile, visible on md+ -->
        <div class="absolute inset-0 z-10 hidden md:flex border-l border-r border-gray-300">
            <div class="basis-[10%] border-r border-blue-300"></div>
            <div class="basis-[25%] border-r border-blue-300"></div>
            <div class="basis-[30%] border-r border-blue-300"></div>
            <div class="basis-[25%] border-r border-blue-300"></div>
            <div class="basis-[10%]"></div>
        </div>
        <!-- Content -->
        @php
            $teamMembers = [
                [
                    'name' => 'Lorem Ipsum',
                    'role' => 'Founder',
                    'image' => asset('/images/foounder.png'),
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque, omnis!'
                ],
                [
                    'name' => 'John Doe',
                    'role' => 'Team Manager',
                    'image' => asset('/images/teammanager.png'),
                    'description' => 'Team Manager responsible for overall operations and management.'
                ],
                [
                    'name' => 'Jane Smith',
                    'role' => 'Marketing',
                    'image' => asset('/images/marketting.png'),
                    'description' => 'Marketing expert focused on campaigns and social media strategies.'
                ],
            ];
        @endphp

        <div class="w-full">
            <div class="w-full h-full flex items-center justify-center relative">
                <div class="bg-white w-full py-12 xs:py-16 sm:py-18 md:py-20">
                    <div class="max-w-xs xs:max-w-sm sm:max-w-2xl md:max-w-4xl lg:max-w-6xl xl:max-w-7xl mx-auto flex flex-col lg:flex-row justify-between items-center gap-6 xs:gap-8 sm:gap-10 px-3 xs:px-4 sm:px-6">
                        <div class="w-full lg:w-3/4 flex flex-col sm:flex-row justify-center lg:justify-evenly items-center gap-4 xs:gap-6 sm:gap-8">
                            <!-- Loop through team members -->
                            @foreach($teamMembers as $index => $member)
                                <div class="inset-0 z-20 w-48 xs:w-52 sm:w-56 md:w-60 lg:w-64 h-60 xs:h-64 sm:h-68 md:h-72 bg-white flex flex-row justify-start relative group overflow-hidden rounded-sm" data-reveal :class="'reveal-delay-' + Math.min($index, 7)">
                                    <div class="flex flex-col gap-y-1 xs:gap-y-2 relative w-full h-full">
                                        <!-- Image -->
                                        <img
                                            src="{{ $member['image'] }}"
                                            alt="{{ $member['name'] }}"
                                            class="h-full w-full object-contain transition-transform duration-700 ease-out transform group-hover:scale-110 group-hover:translate-y-2 xs:group-hover:translate-y-3">
                                        <!-- Bottom content -->
                                        <div class="bg-white w-full h-auto text-start space-y-1 xs:space-y-2 absolute -bottom-0 px-2">
                                            <!-- Always visible -->
                                            <div class="text-sm xs:text-base font-semibold">
                                                {{ $member['name'] }}
                                            </div>
                                            <div class="text-gray-600 text-xs xs:text-sm">
                                                {{ $member['role'] }}
                                            </div>
                                            <div class="bottom-0 w-6 xs:w-8 sm:w-9 border-b border-gray-200"></div>

                                            <!-- Description with staggered hover -->
                                            <div class="text-xs xs:text-sm text-gray-600 transform translate-y-3 xs:translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 delay-150 leading-relaxed">
                                                {{ $member['description'] }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Social Icons Panel -->
                                    <div class="absolute bg-white p-1.5 xs:p-2 rounded-md top-1/2 -right-8 xs:-right-10 flex flex-col justify-center items-center gap-2 xs:gap-3 transform transition-all duration-500 ease-out group-hover:right-0">
                                        <!-- Facebook -->
                                        <a href="#" class="w-3 xs:w-4 h-3 xs:h-4 text-gray-600 hover:text-blue-600 transform translate-x-3 xs:translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 delay-75">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M22.675 0h-21.35C.595 0 0 .595 0 1.325v21.351C0 23.405.595 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.894-4.788 4.659-4.788 1.325 0 2.463.099 2.796.143v3.243l-1.918.001c-1.504 0-1.795.715-1.795 1.762v2.313h3.587l-.467 3.622h-3.12V24h6.116c.729 0 1.324-.595 1.324-1.324V1.325C24 .595 23.405 0 22.675 0z"/>
                                            </svg>
                                        </a>
                                        <!-- Instagram -->
                                        <a href="#" class="w-3 xs:w-4 h-3 xs:h-4 text-gray-600 hover:text-pink-500 transform translate-x-3 xs:translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 delay-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M7.75 2C4.678 2 2 4.678 2 7.75v8.5C2 19.322 4.678 22 7.75 22h8.5c3.072 0 5.75-2.678 5.75-5.75v-8.5C22 4.678 19.322 2 16.25 2h-8.5zM12 7.25A4.75 4.75 0 1 1 7.25 12 4.755 4.755 0 0 1 12 7.25zm0 7.75a3 3 0 1 0-3-3 3 3 0 0 0 3 3zm4.75-7.75a1.25 1.25 0 1 1-1.25-1.25 1.251 1.251 0 0 1 1.25 1.25z"/>
                                            </svg>
                                        </a>
                                        <!-- Twitter -->
                                        <a href="#" class="w-3 xs:w-4 h-3 xs:h-4 text-gray-600 hover:text-sky-500 transform translate-x-3 xs:translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300 delay-225">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.954 4.569a10.04 10.04 0 0 1-2.825.775 4.932 4.932 0 0 0 2.163-2.724 9.868 9.868 0 0 1-3.127 1.195 4.918 4.918 0 0 0-8.384 4.482 13.948 13.948 0 0 1-10.125-5.14 4.822 4.822 0 0 0-.664 2.475 4.92 4.92 0 0 0 2.188 4.1 4.903 4.903 0 0 1-2.228-.616v.06a4.927 4.927 0 0 0 3.946 4.827 4.996 4.996 0 0 1-2.224.084 4.937 4.937 0 0 0 4.6 3.419 9.874 9.874 0 0 1-6.102 2.104c-.396 0-.79-.023-1.175-.069A13.978 13.978 0 0 0 7.548 21c9.057 0 14.009-7.514 14.009-14.01 0-.213-.004-.425-.014-.636A9.935 9.935 0 0 0 24 4.59z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Right Text Column -->
                        <div class="w-full lg:w-1/4 space-y-3 xs:space-y-4 sm:space-y-5 text-center lg:text-left">
                            <div data-reveal class="reveal-delay-2 font-roboto-slab font-semibold text-lg xs:text-xl sm:text-2xl">Our Amazing Team Members</div>
                            <div data-reveal class="reveal-delay-3 text-xs xs:text-sm text-blue-700 leading-relaxed px-2">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate deserunt doloribus enim error et in non tempora ut? Ea, similique...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
