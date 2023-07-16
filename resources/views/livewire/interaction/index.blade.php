<div class="">
    @push('header')
        @livewire('component.search.search-v1',
        [
            'parentComponent' => 'interaction.index',
            'exportExcel' => false,
            'exportPDF' => false,
            'created_date_field' => true,
        ],key('search-1'))
    @endpush

    <div class="tableDataWrapper">
        <table class="tableData">
            <thead>
                <tr>
                    <th><span>Stage</span><span class="sm:hidden">/Customer/Description</span></th>
                    <th class="hidden sm:table-cell">Customer</th>
                    <th class="hidden sm:table-cell">Description</th>
                    <th class="hidden sm:table-cell">Registered</th>
                    <th class="hidden sm:table-cell">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td class="sm:bg-yellow-300">
                        <div class="">
                            <span class="">{{$result['stage']['name']}}</span>
                        </div>

                        <div class="sm:hidden mt-2 sm:mt-0">
                            <div class="mb-2">
                                <p>{{$result['registered']['name']}} <small class="text-xs italic">at {{date("d/m/Y (H:i)",strtotime($result['created_at']))}}</small></p>
                            </div>
                            <p>{{$result['customer']['id']}} <b>{{$result['customer']['name']}}</b></p>
                            <p class="font-semibold">{{$result['group']['name']}}</p>
                            <p>{{$result['description']}}</p>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">
                        <div>
                            <a href="/customer/{{$result['customer_id']}}">
                                <p>{{$result['customer']['id']}}</p>
                                <p><b>{{$result['customer']['name']}}</b></p>
                            </a>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">
                        <div>
                            <a href="/customer/{{$result['customer_id']}}/interaction/{{$result['id']}}">
                                <p class="capitalize text-xs font-semibold">[{{$result['group']['name']}}]</p>
                                <p title="{{$result['description']}}" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">{{$result['description']}}</p>
                            </a>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">
                            <p>{{$result['registered']['name']}}</p>
                            <small class="text-xs italic">at {{date("d/m/Y (H:i)",strtotime($result['created_at']))}}</small>
                    </td>
                    <td class="hidden sm:table-cell">
                        <div>
                            @if($result['finalized_at'])
                                <span class="rounded bg-green-600 shadow text-white px-2 py-1"><i class="fas fa-user-check"></i> Finalized</span>
                            @else
                                <span class="rounded bg-gray-300 shadow px-2 py-1"><i class="far fa-clock"></i> Waiting</span>
                            @endif
                        </div>
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
