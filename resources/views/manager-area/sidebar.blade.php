<aside class="w-52 bg-white">
    <div class="text-center text-lg font-bold text-[#0E4A64] pt-2 -mb-3">
        <span class="block">LKE ZI</span>
        <span class="block">Poliwangi</span>
    </div>
    <nav class="space-y-2 font-medium text-sm p-6">
        {{-- Dashboard --}}
        <a href="{{ route('manager-area.dashboard') }}"
            class="flex cursor-pointer items-center space-x-2 rounded-lg py-2 w-full px-2
                {{ request()->routeIs('manager-area.dashboard') ? 'bg-[#146082] text-white' : 'text-[#374957]' }}
                transition-all hover:bg-[#146082] hover:text-white">

            <svg width="18" height="18" viewBox="0 0 26 26" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_160_663)">
                    <path
                        d="M25.0478 9.82454L16.8307 1.60638C15.8137 0.592366 14.4361 0.0229492 13 0.0229492C11.5639 0.0229492 10.1863 0.592366 9.16935 1.60638L0.952263 9.82454C0.649391 10.1255 0.409264 10.4835 0.245802 10.878C0.0823412 11.2724 -0.00120293 11.6953 1.30861e-05 12.1223V22.7574C1.30861e-05 23.6193 0.342423 24.446 0.951916 25.0555C1.56141 25.665 2.38806 26.0074 3.25001 26.0074H22.75C23.612 26.0074 24.4386 25.665 25.0481 25.0555C25.6576 24.446 26 23.6193 26 22.7574V12.1223C26.0012 11.6953 25.9177 11.2724 25.7542 10.878C25.5908 10.4835 25.3506 10.1255 25.0478 9.82454ZM16.25 23.8407H9.75001V19.5789C9.75001 18.7169 10.0924 17.8903 10.7019 17.2808C11.3114 16.6713 12.1381 16.3289 13 16.3289C13.862 16.3289 14.6886 16.6713 15.2981 17.2808C15.9076 17.8903 16.25 18.7169 16.25 19.5789V23.8407ZM23.8333 22.7574C23.8333 23.0447 23.7192 23.3202 23.516 23.5234C23.3129 23.7266 23.0373 23.8407 22.75 23.8407H18.4167V19.5789C18.4167 18.1423 17.846 16.7645 16.8302 15.7487C15.8144 14.7329 14.4366 14.1622 13 14.1622C11.5634 14.1622 10.1857 14.7329 9.16985 15.7487C8.15403 16.7645 7.58335 18.1423 7.58335 19.5789V23.8407H3.25001C2.9627 23.8407 2.68715 23.7266 2.48398 23.5234C2.28082 23.3202 2.16668 23.0447 2.16668 22.7574V12.1223C2.16768 11.8352 2.28172 11.56 2.4841 11.3564L10.7012 3.14146C11.3119 2.53363 12.1384 2.1924 13 2.1924C13.8616 2.1924 14.6882 2.53363 15.2988 3.14146L23.5159 11.3596C23.7175 11.5625 23.8315 11.8363 23.8333 12.1223V22.7574Z"
                        fill="currentColor" />
                </g>
                <defs>
                    <clipPath id="clip0_160_663">
                        <rect width="26" height="26" fill="white" />
                    </clipPath>
                </defs>
            </svg>
            <span class="font-semibold mt-1">Dashboard</span>
        </a>

        {{-- Area Sidebar --}}
        @includeIf('components.sidebar.sidebar-area' . $areaId)

        {{-- Hasil --}}
        @include('components.sidebar.hasil')

        {{-- Validasi --}}
        @include('components.sidebar.validasi')
    </nav>
</aside>
