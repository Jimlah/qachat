<?php

use App\Models\User;

use function Livewire\Volt\{computed, state, mount};

state(['user']);

mount(function ($user) {
    $this->user = User::query()->find($user);
});

?>

<div class="flex items-start justify-start w-full h-full">
    @if ($user)
    <div class="relative flex items-start justify-start w-full h-full">
        <div class="flex flex-col items-start justify-start w-full h-full divide-y grow divide-slate-800/50">
            <div class="flex items-center justify-start gap-5 p-5">
                <div class="rounded-full size-12 aspect-square bg-slate-800"></div>
                <div class="flex flex-col items-start justify-between w-full gap-2">
                    <p class="text-sm">{{ $user->name }}</p>
                    <p class="text-xs text-slate-500">{{ now()->format('h:ia') }}</p>
                </div>
            </div>
            <div class="w-full h-full overflow-hidden grow">
                <div class="flex flex-col-reverse w-full h-full gap-2 p-5 pb-32 overflow-y-auto grow">
                    <template x-for="message in 20" :key="message">
                        <div class="w-full">
                            <template x-if="message % 2 === 0">
                                <div class="flex items-start justify-start w-full gap-2">
                                    <div class="rounded-full size-8 aspect-square bg-slate-800"></div>
                                    <div class="w-full max-w-xs p-2 overflow-hidden text-sm rounded-tl-none rounded-xl bg-slate-800">
                                        Hello World!
                                    </div>
                                </div>
                            </template>
                            <template x-if="message % 2 !== 0">
                                <div class="flex items-start justify-end w-full gap-2">
                                    <div class="w-full max-w-xs p-2 overflow-hidden text-sm rounded-tr-none rounded-xl bg-slate-800">
                                        Hello World!
                                    </div>
                                    <div class="rounded-full size-8 aspect-square bg-slate-800"></div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
                <div class="absolute bottom-0 left-0 flex items-start justify-start w-full px-5">
                    <label class="flex items-center justify-start w-full gap-2 p-2 mt-4 mb-5 rounded-md bg-slate-700">
                        <button class="border-none w-fit focus:outline-none focus:ring-0">
                            <x-heroicon-s-paper-clip class="w-5 h-5 " />
                        </button>
                        <textarea wire:model.live='message' rows="1" class="w-full text-sm bg-transparent border-none outline-none resize-none focus:border-none focus:ring-0 focus:outline-none" placeholder="Type something"></textarea>
                        <button class="border-none w-fit focus:outline-none focus:ring-0">
                            <x-heroicon-s-microphone class="w-5 h-5 " />
                        </button>
                        <button class="border-none w-fit focus:outline-none focus:ring-0">
                            <x-heroicon-s-paper-airplane class="w-5 h-5 -rotate-45" />
                        </button>
                    </label>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>
    @else
    <div class="flex flex-col items-center justify-center w-full h-full text-purple-700">
        <x-heroicon-c-chat-bubble-left-right class="w-20 h-20" />
        <p class="text-xl text-center">Select a contact to start chating</p>
    </div>
    @endif
</div>