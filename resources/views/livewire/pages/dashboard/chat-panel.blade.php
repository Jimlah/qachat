<?php

use App\Events\MessageSent;
use App\Models\Channel;
use App\Models\User;

use function Livewire\Volt\{computed, state, mount, rules, updated, on};

on([
    'refresh' => '$refresh',
    "echo:message.id,MessageSent" => 'messageSent',
]);
state(['content']);
state(['channel']);


$user = computed(
    fn () => $this->channel
        ->subscribers()
        ->where('user_id', '!=', auth()->id())
        ->firstOrFail()
);

$chatMessages = computed(fn () =>
$this->channel
    ->load([
        'messages' => fn ($query) => $query->latest()->limit(50),
        'messages.user'
    ])->messages);

rules(['content' => 'required|string']);

$submit = function () {
    $this->validate();
    $this->channel->messages()->create([
        'user_id' => auth()->id(),
        'content' => $this->content
    ]);
    MessageSent::dispatch($this->channel);
    $this->reset('content');
};

?>

<div class="flex items-start justify-start w-full h-full">
    <div class="relative flex items-start justify-start w-full h-full">
        <div class="flex flex-col items-start justify-start w-full h-full divide-y grow divide-slate-800/50">
            <div class="flex items-center justify-start gap-5 p-5">
                <div class="relative rounded-full size-12 aspect-square bg-slate-800">
                    <div class="absolute bottom-0 right-0 bg-green-500 rounded-full size-4 aspect-square" x-init="
                    Echo.join(`chat.{{$this->channel->id}}`)
    .here((users) => {
        console.log(users, 'here');
    })
    .joining((user) => {
        console.log(user.name, 'joining');
    })
    .leaving((user) => {
        console.log(user.name, 'leaving');
    })
    .error((error) => {
        console.error(error.error);
    });
                    "></div>
                </div>
                <div class="flex flex-col items-start justify-between w-full gap-2">
                    <p class="text-sm">{{ $this->user->name }}</p>
                    <p class="text-xs text-slate-500">{{ now()->format('h:ia') }}</p>
                </div>
            </div>
            <div class="w-full h-full overflow-hidden grow">
                <div class="flex flex-col-reverse w-full h-full gap-4 p-5 pb-32 overflow-y-auto grow">
                    @foreach ($this->chatMessages as $message)
                    @if ($message->user_id !== auth()->id())
                    <div class="w-full group">
                        <div class="flex items-start justify-start gap-2">
                            <div class="rounded-full size-8 aspect-square bg-slate-800"></div>
                            <div class="flex flex-col items-start justify-start w-full gap-2">
                                <span class="flex items-center justify-start gap-2">
                                    <span class="text-xs font-semibold">{{ $message->user->name }}</span>
                                    <span class="text-xs text-slate-500">{{ $message->created_at->format('h:ia') }}</span>
                                </span>
                                <div class="w-full max-w-xs p-2 overflow-hidden text-sm rounded-tl-none rounded-xl bg-slate-800">
                                    {{ $message->content }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="w-full">
                        <div class="flex items-start justify-end gap-2">
                            <div class="flex flex-col items-end justify-start w-full gap-2">
                                <span class="flex items-center justify-end gap-2">
                                    <span class="text-xs font-semibold">{{ $message->user->name }}</span>
                                    <span class="text-xs text-slate-500">{{ $message->created_at->format('h:ia') }}</span>
                                </span>
                                <div class="w-full max-w-xs p-2 overflow-hidden text-sm text-white bg-purple-800 rounded-tr-none rounded-xl">
                                    {{ $message->content }}
                                </div>
                            </div>
                            <div class="rounded-full size-8 aspect-square bg-slate-800"></div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="absolute bottom-0 left-0 flex items-start justify-start w-full px-5">
                    <label class="flex items-center justify-start w-full gap-2 p-2 mt-4 mb-5 rounded-md bg-slate-700">
                        <button class="border-none w-fit focus:outline-none focus:ring-0">
                            <x-heroicon-s-paper-clip class="w-5 h-5 " />
                        </button>
                        <textarea wire:model='content' wire:keydown.enter.prevent="submit" rows="1" class="w-full text-sm bg-transparent border-none outline-none resize-none focus:border-none focus:ring-0 focus:outline-none" placeholder="Type something"></textarea>
                        <button class="border-none w-fit focus:outline-none focus:ring-0">
                            <x-heroicon-s-microphone class="w-5 h-5 " />
                        </button>
                        <button class="border-none w-fit focus:outline-none focus:ring-0" wire:click.prevent="submit">
                            <x-heroicon-s-paper-airplane class="w-5 h-5 -rotate-45" />
                        </button>
                    </label>
                </div>
            </div>
        </div>
        <div>
        </div>
    </div>
</div>