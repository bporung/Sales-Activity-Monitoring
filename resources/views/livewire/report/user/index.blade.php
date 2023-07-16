<div class="">
    @push('header')
        @livewire('component.search.search-v1',
        [
            'parentComponent' => 'report.user.index',
            'exportExcel' => false,
            'exportPDF' => false,
            'created_date_field' => true,
        ],key('search-1'))
    @endpush


    @if($created_date['start'] && $created_date['end'])
    <div><h5>Period : {{$created_date['start']}} to {{$created_date['end']}}</h5></div>
    <div class="tableDataWrapper">
        <table class="tableData">
            <thead>
                <tr>
                    <th><span>User</span><span class="sm:hidden">/Stage 1/Stage 2/Stage 3/Stage 4/Stage 5/Sales</span></th>
                    <th class="hidden sm:table-cell">Intro</th>
                    <th class="hidden sm:table-cell">Follow Up</th>
                    <th class="hidden sm:table-cell">Follow Up Item</th>
                    <th class="hidden sm:table-cell">Quotation</th>
                    <th class="hidden sm:table-cell">Sales Order</th>
                    <th class="hidden sm:table-cell">Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($interactionDatas as $interaction)
                    @if(array_key_exists('count_per_stage', $interaction))
                    <tr>
                        <td class="sm:bg-yellow-300">
                            <div class="">
                                <span class="">{{$interaction['data']->name}}</span>
                            </div>
                        </td>
                        <td class="sm:table-cell">
                            @if(array_key_exists(1, $interaction['count_per_stage']))
                            <div>
                                    <p>{{$interaction['count_per_stage'][1]}}</p>
                                </a>
                            </div>
                            @endif
                        </td>
                        <td class="sm:table-cell">
                            @if(array_key_exists(2, $interaction['count_per_stage']))
                            <div>
                                    <p>{{$interaction['count_per_stage'][2]}}</p>
                                </a>
                            </div>
                            @endif
                        </td>
                        <td class="sm:table-cell">
                            @if(array_key_exists(3, $interaction['count_per_stage']))
                            <div>
                                    <p>{{$interaction['count_per_stage'][3]}}</p>
                                </a>
                            </div>
                            @endif
                        </td>
                        <td class="sm:table-cell">
                            @if(array_key_exists(4, $interaction['count_per_stage']))
                            <div>
                                    <p>{{$interaction['count_per_stage'][4]}}</p>
                                </a>
                            </div>
                            @endif
                        </td>
                        <td class="sm:table-cell">
                            @if(array_key_exists(5, $interaction['count_per_stage']))
                            <div>
                                    <p>{{$interaction['count_per_stage'][5]}}</p>
                                </a>
                            </div>
                            @endif
                        </td>
                        <td class="sm:table-cell">
                            @if(array_key_exists('sales', $interaction))
                            <div>
                                    <p>{{number_format($interaction['sales'],0)}}</p>
                                </a>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
