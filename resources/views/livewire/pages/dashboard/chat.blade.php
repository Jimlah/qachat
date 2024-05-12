<?php

use App\Models\Channel;
use App\Models\User;
use function Livewire\Volt\{state, computed,};

state(['search' => '']);

$channels = computed(
    fn () => Channel::query()
        ->whereHas('subscribers', fn ($query) =>
        $query->where('name', 'like', "%$this->search%"))
        ->withCount('subscribers')
        ->with('subscribers')
        ->get()
)
    ->persist();

?>



<div class="flex flex-col w-full h-full max-w-xs p-5">
    <div class="flex-none w-full">
        <span class="flex items-center justify-start gap-2 text-slate-500">
            <span>All Chats</span>
            <x-heroicon-o-chevron-down class="w-4 h-4" />
        </span>
        <h3 class="mt-2 text-2xl font-medium tracking-wide">
            Messages <span class="text-purple-700">(28)</span>
        </h3>
        <label class="flex items-center justify-start w-full p-2 mt-4 rounded-md bg-slate-700/50">
            <input type="text" wire:model.live='search' class="w-full h-10 bg-transparent border-none outline-none focus:border-none focus:ring-0 focus:outline-none" placeholder="Search for messages...">
            <x-heroicon-o-magnifying-glass class="w-5 h-5" />
        </label>
    </div>
    <div class="flex-grow w-full h-full mt-4 overflow-y-auto">
        <div class="w-full">
            <p class="text-xs text-slate-500">All Messages</p>
            <div class="w-full h-full divide-y divide-gray-800/50 scroll-smooth">
                @foreach ($this->channels as $channel)
                <a href="{{ route('dashboard.chat', ['channel' => $channel]) }}" class="flex items-center justify-start w-full gap-4 py-2 cursor-pointer first:border-t-0 hover:bg-slate-900" wire:navigate>
                    <div class="rounded-full size-12 bg-slate-800 aspect-square"></div>
                    <div class="flex flex-col items-start justify-between w-full h-full gap-2 grow">
                        <p class="text-sm min-w-fit whitespace-nowrap">
                            {{ $channel->subscribers->where('id', '!=', auth()->id())->first()->name }}
                        </p>
                        <div class="text-xs whitespace-nowrap text-ellipsis text-slate-700">What do you think
                        </div>
                    </div>
                    <div class="flex flex-col items-end justify-between w-full h-full gap-2">
                        <p class="text-xs text-gray-700 min-w-fit whitespace-nowrap">
                            {{ now()->subMinutes(rand(1, 59))->format('h:i A') }}
                        </p>
                        <div class="flex items-center justify-center text-xs bg-purple-800 rounded-full size-4 aspect-square">
                            <span>2</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>