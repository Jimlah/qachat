<x-app-layout>
    <x-layouts.chat>
        <div class="w-full h-full">
            <!-- Order your soul. Reduce your wants. - Augustine -->
            <livewire:pages.dashboard.chat-panel :channel="$channel" :key="$channel->id" />
        </div>
    </x-layouts.chat>
</x-app-layout>