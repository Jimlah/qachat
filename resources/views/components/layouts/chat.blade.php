<div class="w-full h-full">
    <div class="flex items-start justify-start w-full h-full divide-x divide-slate-800">
        <div class="w-full h-full max-w-xs">
            @persist('channels')
            <livewire:pages.dashboard.chat />
            @endpersist
        </div>
        <div class="w-full h-full grow">
            {{ $slot }}
        </div>
    </div>
    <livewire:pages.dashboard.add-user />
</div>