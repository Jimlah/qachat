<?php

use App\Models\User;

use function Livewire\Volt\{state, computed};

state(['search' => '']);
state(['selectedUser']);

$users = computed(fn () => User::query()
    ->when($this->search, fn ($query, $search) => $query->where('name', 'like', "%{$search}%"))
    ->whereNotIn('id', [auth()->id()])
    ->get())
    ->persist();

?>


<div class="flex items-start justify-start w-full h-full divide-x divide-slate-800">
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
                    @foreach ($this->users as $user)
                    <label class="flex items-center justify-start w-full gap-4 py-2 cursor-pointer first:border-t-0 hover:bg-slate-900">
                        <input type="radio" wire:model.live='selectedUser' value="{{ $user->id }}" class="hidden">
                        <div class="rounded-full size-12 bg-slate-800 aspect-square"></div>
                        <div class="flex flex-col items-start justify-between w-full h-full gap-2 grow">
                            <p class="text-sm min-w-fit whitespace-nowrap">
                                {{ $user->name }}
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
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="w-full h-full grow">
        <livewire:pages.dashboard.chat-panel :user="$selectedUser" :key="$selectedUser" />
    </div>
</div>