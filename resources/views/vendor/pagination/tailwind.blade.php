@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        {{-- MODE MOBILE (Tampilan HP) --}}
        <div class="flex gap-2 items-center justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-stone-400 bg-[#F7F1E6]/20 backdrop-blur-md border border-[#E0D2AE]/30 cursor-not-allowed leading-5 rounded-xl">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#3D2E1F] bg-[#F7F1E6]/40 backdrop-blur-md border border-[#E0D2AE]/30 leading-5 rounded-xl hover:bg-[#A9842E]/10 hover:text-[#A9842E] transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#3D2E1F] bg-[#F7F1E6]/40 backdrop-blur-md border border-[#E0D2AE]/30 leading-5 rounded-xl hover:bg-[#A9842E]/10 hover:text-[#A9842E] transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-stone-400 bg-[#F7F1E6]/20 backdrop-blur-md border border-[#E0D2AE]/30 cursor-not-allowed leading-5 rounded-xl">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- MODE DESKTOP --}}
        <div class="hidden sm:flex-1 sm:flex sm:gap-4 sm:items-center sm:justify-between">

            {{-- Info teks di sebelah kiri ("Showing x to y...") --}}
            <div>
                <p class="text-sm text-stone-500/90 leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-bold text-[#3D2E1F]">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-bold text-[#3D2E1F]">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-bold text-[#3D2E1F]">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            {{-- Kotak Navigasi Utama Ber-efek Kaca --}}
            <div>
                <span class="inline-flex rtl:flex-row-reverse rounded-xl bg-[#F7F1E6]/40 backdrop-blur-md border border-[#E0D2AE]/30 overflow-hidden shadow-xs">

                    {{-- Tombol Panah Kiri (Previous) --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-stone-400 cursor-not-allowed leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#3D2E1F] leading-5 hover:bg-[#A9842E]/10 hover:text-[#A9842E] border-r border-[#E0D2AE]/20 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Loop Angka Halaman --}}
                    @foreach ($elements as $element)
                        {{-- Separator Titik Tiga (...) --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-stone-400 border-r border-[#E0D2AE]/20 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Tombol Angka --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    {{-- Halaman AKTIF (Emas Solid, Teks Putih) --}}
                                    <span aria-current="page">
                                        <span class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-[#A9842E] border-r border-[#E0D2AE]/20 cursor-default leading-5 shadow-inner">{{ $page }}</span>
                                    </span>
                                @else
                                    {{-- Halaman Tidak Aktif (Transparan, Cokelat Tema, Hover Emas) --}}
                                    <a href="{{ $url }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-[#3D2E1F] leading-5 hover:bg-[#A9842E]/10 hover:text-[#A9842E] border-r border-[#E0D2AE]/20 transition ease-in-out duration-150" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Panah Kanan (Next) --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#3D2E1F] leading-5 hover:bg-[#A9842E]/10 hover:text-[#A9842E] transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-stone-400 cursor-not-allowed leading-5" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif