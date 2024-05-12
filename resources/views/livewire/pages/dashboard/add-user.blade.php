<?php

use App\Models\Channel;
use App\Models\User;

use function Livewire\Volt\{state, computed};

state(['search' => '']);

$users = computed(
    fn () => User::query()
        ->where('name', 'like', "%$this->search%")
        ->where('id', '!=', auth()->id())
        ->get()
);

$chat = function ($id) {
    $channel = Channel::query()
        ->whereHas('subscribers', fn ($query) => $query->whereIn('user_id', [auth()->id(), $id]), count: 2)
        ->firstOr(fn () => Channel::create()->sync('subscribers', [auth()->id(), $id]));
    $this->dispatch('close-modal');
    $this->redirect(route('dashboard.chat', ['channel' => $channel]), navigate: true);
};

?>

<div class="fixed top-0 left-0 z-50 flex items-center justify-center w-full h-screen overflow-hidden bg-slate-800/50 backdrop-blur-sm" x-data="{open: false}" @close-modal="open=false" x-show="open">
    <div class="flex flex-col w-full max-w-sm p-2 text-white rounded-md shadow-md bg-slate-950" @click.outside="open=false">
        <div class="w-full">
            <label class="flex items-center justify-start w-full p-1 rounded-md bg-slate-700/50">
                <input type="text" wire:model.live='search' class="w-full h-10 bg-transparent border-none outline-none focus:border-none focus:ring-0 focus:outline-none" placeholder="Search for messages...">
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
            </label>
        </div>
        <div class="w-full h-full py-2 divide-y divide-gray-800/50 scroll-smooth">
            @foreach ($this->users as $user)
            <button class="flex items-center justify-start w-full gap-4 py-2 cursor-pointer first:border-t-0 hover:bg-slate-900" wire:click.prevent="chat('{{ $user->id }}')">
                <div class="rounded-full size-8 bg-slate-800 aspect-square"></div>
                <div class="flex flex-col items-start justify-between w-full h-full gap-2 grow">
                    <p class="text-sm min-w-fit whitespace-nowrap">
                        {{ $user->name }}
                    </p>
                </div>
            </button>
            @endforeach
        </div>
    </div>
</div>