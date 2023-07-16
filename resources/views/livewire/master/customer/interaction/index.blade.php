<div>
    <div class="p-2 bg-green-700  mb-1 text-white flex justify-between items-center">
            <span>Interaction Data</span>
            <a class="bg-white px-3 py-2 text-black rounded shadow hover:bg-yellow-200 transition-all" href="/customer/{{$customer_id}}/interaction/create"> <i class="fas fa-comments"></i>  New Interaction</a>
    </div>
    
    <div class="p-2  flex justify-end items-center">
        <div>
            @livewire('component.search.search-v1',
            [
                'parentComponent' => 'master.customer.interaction.index',
            ],key('search-interaction-1'))
        </div>
    </div>
    <div class="tableDataWrapper" style="height:250px !important;">
    <table class="tableData">
        <thead>
            <tr>
                <th>Interaction(s)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $interaction)
            <tr>
                <td>
                    <p class="font-semibold capitalize flex justify-between"><a>{{$interaction->group->name}}</a><span class="p-1 rounded text-xs bg-yellow-500">{{$interaction->stage->name}}</span></p>
                    <p class="capitalize">
                    <a href="/customer/{{$customer_id}}/interaction/{{$interaction->id}}">{{substr($interaction->description,0,45).'...'}}</a></p>
                    <div class="w-full flex justify-between">
                        <p class="capitalize text-xs">{{date("d M Y",strtotime($interaction->created_at))}} / {{$interaction->registered->name}}<p>
                        <span class="p-1 rounded text-xs {{$interaction->finalized_at ? 'bg-green-500 text-white' : 'bg-gray-300'}}">{{$interaction->finalized_at ? 'Finalized' : 'Waiting'}}</span>
                    </div>
                    <div class="text-left mt-3"><a href="/customer/{{$customer_id}}/interaction/{{$interaction->id}}" class="px-2 py-1 rounded bg-blue-500 text-xs text-white transition-all hover:bg-white hover:text-black"><i class="far fa-eye"></i> Explore</a></div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <div class="grid justify-items-end">
        @include('component.pagination.pagination-v1')
    </div>
</div>
