<div class="w-full flex flex-wrap p-2">
    <div class="w-full bg-blue-100 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
        <p class="font-bold">User's Reports</p>
        <p class="text-sm">{{$result->name}} / {{$result->username}}</p>
    </div>

    <div class="w-full md:w-1/2 lg:w-1/3 p-2">
        <div class="w-full bg-indigo-900 text-center py-4 lg:px-4">
            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                <span class="font-semibold mr-2 text-left flex-auto">Interaction Stages</span>
            </div>
        </div>
        <div class="w-full shadow bg-white rounded p-2">@livewire('component.chart.base.user.interaction.stagecount',['users' => [$data_id] ])</div>
    </div>
    <div class="w-full md:w-1/2 lg:w-1/3 p-2">
        <div class="w-full bg-indigo-900 text-center py-4 lg:px-4">
            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                <span class="font-semibold mr-2 text-left flex-auto">Quotation : Sales Order Created</span>
            </div>
        </div>
        <div class="w-full shadow bg-white rounded p-2">@livewire('component.chart.base.user.ratio.quotation-salesorder',['users' => [$data_id] ])</div>
    </div>

    
    <div class="w-full md:w-1/2 lg:w-1/3 p-2">
        <div class="w-full bg-indigo-900 text-center py-4 lg:px-4">
            <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                <span class="font-semibold mr-2 text-left flex-auto">Daily Reach</span>
            </div>
        </div>
        <div class="w-full shadow bg-white rounded p-2">@livewire('component.chart.base.user.interaction.dailycount',['users' => [$data_id] ])</div>
    </div>
</div>

@push('scripts')
    @livewireChartsScripts
@endpush