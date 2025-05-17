<div>
    @if($showModal)
        <div class="fixed inset-0 z-[1999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-data="{ show: @entangle('showModal') }" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                {{-- Background overlay --}}
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 dark:bg-gray-900/75" aria-hidden="true" @click="show = false; $wire.call('closeModal')"></div>

                {{-- Modal panel --}}
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
                <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">
                            {{ __('Send Invitation') }} - {{ \App\Enums\InvitationGroupType::tryFrom($groupType)?->getLabel() ?? $groupType }}
                        </h3>
                        <button @click="show = false; $wire.call('closeModal')" type="button" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="mt-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{-- UI Hint Instructions from the image --}}
                            {{ __('You can send an invitation through the following template') }}<br>
                            - {{ __('The system send the details of survey to email for evaluation') }}<br>
                            - {{ __('The system notify you when the user open the link of survey') }}<br>
                            - {{ __('The status of invitation appear next to it') }}<br>
                            - {{ __('If the user did not response to invitation, the system will remind him 3 times for 6 days') }} (Reminder not implemented in this guide)
                        </p>
                    </div>

                    <form wire:submit.prevent="sendInvitation" class="mt-4 space-y-4">
                        <div>
                            <label for="modal_email_input" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Email Address') }}</label>
                            <input wire:model.defer="email" type="email" id="modal_email_input" name="email" required
                                   class="block w-full mt-1 text-gray-900 bg-white border-gray-300 rounded-md shadow-sm fi-input focus:ring-primary-500 focus:border-primary-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                   placeholder="{{ __('Please enter email here') }}">
                            @error('email') <span class="mt-1 text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2 mt-5 sm:flex sm:flex-row-reverse">
                            <button type="submit" wire:loading.attr="disabled" wire:target="sendInvitation"
                                    class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm fi-btn-primary bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <span wire:loading wire:target="sendInvitation" class="mr-2">
                                <svg class="w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                  </svg>
                            </span>
                                {{ __('Send Invitation') }}
                            </button>
                            <button @click="show = false; $wire.call('closeModal')" type="button"
                                    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm fi-btn-secondary hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-600">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
