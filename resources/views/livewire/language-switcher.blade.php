<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" type="button" class="flex items-center p-2 text-sm font-medium text-gray-500 rounded-md hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
        <x-heroicon-o-language class="w-5 h-5 mr-1 rtl:ml-1 rtl:mr-0"/>
        <span>{{ strtoupper($currentLocale) }}</span>
        <x-heroicon-m-chevron-down class="w-4 h-4 ml-1 rtl:mr-1 rtl:ml-0"/>
    </button>

    <div x-show="open" @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 z-50 mt-2 w-32 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800 dark:ring-gray-700"
         style="display: none;">
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            @foreach($availableLocales as $localeCode)
                @if($localeCode !== $currentLocale)
                    <button wire:click="switchLocale('{{ $localeCode }}')"
                            class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
                            role="menuitem">
                        {{-- You can use a helper to get locale names e.g., English, العربية --}}
                        {{ strtoupper($localeCode) }}
                    </button>
                @endif
            @endforeach
        </div>
    </div>
</div>
