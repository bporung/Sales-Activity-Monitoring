<div class="w-full flex flex-wrap p-2">
    <div class="w-full md:w-1/2 lg:w-1/3 p-2">
        <div class="w-full shadow bg-white rounded p-2">@livewire('component.chart.interaction.stage')</div>
    </div>
    <div class="w-full md:w-1/2 lg:w-1/3 p-2">
        <div class="w-full shadow bg-white rounded p-2">@livewire('component.chart.user.top5interaction')</div>
    </div>
    <div class="w-full p-2">
        <div class="w-full shadow bg-white rounded p-2">@livewire('component.chart.interaction.monthlyreach')</div>
    </div>
</div>

@push('scripts')
    @livewireChartsScripts
@endpush