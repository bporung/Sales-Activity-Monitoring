<div class="">
    @push('header')
        @livewire('component.search.search-v1',
        [
            'parentComponent' => 'master.item.index',
            'exportExcel' => false,
            'exportPDF' => false,
        ],key('search-1'))
    @endpush

    <div class="tableDataWrapper">
        <table class="tableData">
            <thead>
                <tr>
                    <th><span>Code</span><span class="sm:hidden">/Name/Brand/Unit Price</span></th>
                    <th class="hidden sm:table-cell">Name</th>
                    <th class="hidden sm:table-cell">Brand</th>
                    <th class="hidden sm:table-cell">Unit Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>
                        <div>
                            <a href="/item/{{$result['id']}}"><p><b>{{$result['code']}}</b></p></a>
                            <div class="sm:hidden">
                                <p>{{$result['name']}}</p>
                                <p>{{$result['brand']['name']}}</p>
                            </div>
                            <p>Created At : {{date("d-m-Y",strtotime($result['created_at']))}}</p>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">{{$result['name']}}</td>
                    <td class="hidden sm:table-cell">{{$result['brand']['name']}}</td>
                    <td class="hidden sm:table-cell">{{number_format($result['unit_price'],0)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="grid justify-items-end">
        @include('component.pagination.pagination-v1')
    </div>
</div>
