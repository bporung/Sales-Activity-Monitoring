<div>
    <div class="p-2 bg-blue-700  mb-1 text-white flex justify-between items-center">
            <span>Group(s) Interaction</span>
            <a class="bg-white px-3 py-2 text-black rounded shadow hover:bg-yellow-200 transition-all" href="/customer/{{$customer_id}}/interactiongroup/create"> <i class="fas fa-object-ungroup"></i>  New Group</a>
    </div>
    <div class="p-2  flex justify-end items-center">
            <div>
                @livewire('component.search.search-v1',
                [
                    'parentComponent' => 'master.customer.interactiongroup.index',
                ],key('search-interactiongroup-1'))
            </div>
            <div class="m-1 flex items-center"><input type="checkbox" wire:model="isActive" wire:change="changedStatus"><label>Active</label></div>
            <div class="m-1 flex items-center"><input type="checkbox" wire:model="notActive" wire:change="changedStatus"><label>Close</label></div>
    </div>
    <div class="tableDataWrapper" style="height:250px !important;">
    <table class="tableData">
        <thead>
            <tr>
                <th>Name / Last Interaction</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $group)
            <tr>
                <td>
                    <p class="font-semibold capitalize flex justify-between"><a >{{$group->name}}</a><span class="rounded p-1 text-xs ml-3 {{$group->status == '1' ? 'bg-green-500' : 'bg-gray-300'}}">{{$group->status == '1' ? 'Active' : 'Close'}}</span></p>
                    @if($group->last_interaction)
                    <p class="capitalize">{{$group->last_interaction ? $group->last_interaction->stage->name : ''}}</p>
                    <p class="capitalize">{{$group->last_interaction ? substr($group->last_interaction->description,0,65).'...' : '[Empty]'}}</p>
                    <p class="capitalize text-xs">{{$group->last_interaction ? date("d M Y",strtotime($group->last_interaction->created_at)) : ''}} / {{$group->last_interaction ? $group->last_interaction->registered->name : ''}}</p>
                    @else
                        <span>[No Interaction Yet]</span>
                    @endif
                    <div class="text-left mt-3"><a href="/customer/{{$customer_id}}/interactiongroup/{{$group->id}}" class="px-2 py-1 rounded bg-blue-500 text-xs text-white transition-all hover:bg-white hover:text-black"><i class="far fa-eye"></i> </a></div>
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
