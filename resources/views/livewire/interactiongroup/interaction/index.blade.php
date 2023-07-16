<div>
    <div class="p-2 bg-green-700  mb-1 text-white flex justify-between items-center">
            <span>Interaction Data</span>
            @if($create_new_interaction)
            <a class="bg-white px-3 py-2 text-black rounded shadow hover:bg-yellow-200 transition-all" href="/customer/{{$customer_id}}/interaction/create?group_id={{$group_id}}"> <i class="fas fa-comments"></i>  New Interaction</a>
            @endif
    </div>
    
    <div class="p-2  flex justify-end items-center">
        <div>
            @livewire('component.search.search-v1',
            [
                'parentComponent' => 'interactiongroup.interaction.index',
            ],key('search-interaction-1'))
        </div>
    </div>
    <div class="tableDataWrapper" style="height:300px !important;">
        @foreach($results as $interaction)
        <div class="p-3 border border-gray-400 shadow mb-2">
            <p class="font-semibold capitalize flex justify-between"><a>{{$interaction->group->name}}</a><span class="p-1 rounded text-xs bg-yellow-500">{{$interaction->stage->name}}</span></p>
            <p class="capitalize py-1">{{$interaction->description}}</p>
            <div class="capitalize text-xs flex justify-between">
                <p class="flex-none">{{date("d M Y",strtotime($interaction->created_at))}} / {{$interaction->registered->name}}</p>
                <div class="flex-none">
                    <a class="text-xs border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition-all px-2 py-1" href="/customer/{{$customer_id}}/interaction/{{$interaction->id}}">Show More</a>
                    <button type="button" class="text-xs border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition-all px-2 py-1" 
                    x-data="{}" x-on:click="window.livewire.emitTo('interactiongroup.interaction.show','show',{{$interaction}})">Quick View</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="grid justify-items-end">
        @include('component.pagination.pagination-v1')
    </div>
    
    
</div>
