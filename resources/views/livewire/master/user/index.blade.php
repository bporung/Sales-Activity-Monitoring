<div class="">
    @push('header')
        @livewire('component.search.search-v1',
        [
            'parentComponent' => 'master.user.index',
            'exportExcel' => true,
            'exportPDF' => true,
        ],key('search-1'))
    @endpush

    <div class="tableDataWrapper">
        <table class="tableData">
            <thead>
                <tr>
                    <th><span>Name</span><span class="sm:hidden">/Username/Email/Role</span></th>
                    <th class="hidden sm:table-cell">Username</th>
                    <th class="hidden sm:table-cell">Email</th>
                    <th class="hidden sm:table-cell">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td>
                        <div>
                            <a href="/user/{{$result['id']}}"><p><b>{{$result['name']}}</b></p></a>
                            <div class="sm:hidden">
                                <p>{{$result['username']}}</p>
                                <p>{{$result['email']}}</p>
                            </div>
                            <p>Created At : {{date("d-m-Y",strtotime($result['created_at']))}}</p>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell">{{$result['username']}}</td>
                    <td class="hidden sm:table-cell">{{$result['email']}}</td>
                    <td class="hidden sm:table-cell">{{$result['roles'][0]['name']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="grid justify-items-end">
        @include('component.pagination.pagination-v1')
    </div>
</div>
