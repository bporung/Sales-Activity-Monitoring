<div class="">
    @push('header')
        @livewire('component.search.search-v1',
        [
            'parentComponent' => 'master.customer.index',
            'exportExcel' => true,
            'exportPDF' => true,
        ],key('search-1'))
    @endpush

    <div class="tableDataWrapper">
        <table class="tableData">
            <thead>
                <tr>
                    <th><span>Name</span><span class="sm:hidden">/Category/Province/Address</span></th>
                    <th class="hidden sm:table-cell">Category</th>
                    <th class="hidden sm:table-cell">Province</th>
                    <th class="hidden sm:table-cell">Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>
                        <div>
                            <a href="/customer/{{$result['id']}}"><p><b>{{$result['full_name']}}</b></p>
                            <p><b>{{$result['id']}}</b></p></a>
                            <div class="sm:hidden">
                                <p>
                                    @foreach($result['categories'] as $category)
                                        <span class="px-2 py-1 border border-gray-500 mr-1 inline-block my-1 hover:border-blue-400 hover:text-blue-400 transition-all cursor-pointer">{{$category['name']}}</span>
                                    @endforeach
                                </p>
                                <p>{{$result['province']['name']}}</p>
                                <p>{{$result['address']}}</p>
                            </div>
                            <p>Created : {{date("d/m/Y H:i",strtotime($result['created_at']))}}</p>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">
                        <div>
                        @foreach($result['categories'] as $category)
                            <span class="px-2 py-1 border border-gray-500 mr-1 inline-block my-1 hover:border-blue-400 hover:text-blue-400 transition-all cursor-pointer">{{$category['name']}}</span>
                        @endforeach
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">{{$result['province']['name']}}</td>
                    <td class="hidden sm:table-cell">{{$result['address']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="grid justify-items-end">
        @include('component.pagination.pagination-v1')
    </div>
</div>
