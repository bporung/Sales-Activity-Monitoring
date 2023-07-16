<div class="">
    @push('header')
        @livewire('component.search.search-v1',
        [
            'parentComponent' => 'notification.index',
            'exportExcel' => false,
            'exportPDF' => false,
            'readStatusCheckbox' => true,
        ],key('search-1'))
    @endpush

    <div class="tableDataWrapper">
        <table class="tableData">
            <thead>
                <tr>
                    <th><span>Date</span><span class="sm:hidden">/Subject</span></th>
                    <th class="hidden sm:table-cell">Description</th>
                    <th class="hidden sm:table-cell">Link</th>
                    <th class="hidden sm:table-cell">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                <tr>
                    <td class="{{$result->is_read ? 'bg-gray-300' : ''}}">
                        <a href="">
                        <div class="">
                            <p class="mb-3">{{date("d/m/Y",strtotime($result->notification->created_at))}}</p>
                            <p class="">{{$result->notification->subject}}</p>
                        </div>

                        <div class="sm:hidden mt-2 sm:mt-0">
                            <p>{{$result->notification->description}}</p>
                            <p class="whitespace-nowrap"><a href="{{$result->notification->link}}"><i class="fas fa-link"></i> Link Here</a></p>
                            <p>Read</p>
                        </div>
                        </a>
                    </td>
                    <td class="hidden sm:table-cell {{$result->is_read ? 'bg-gray-300' : ''}}">
                        <div>
                            <p>{{$result->notification->description}}</p>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell {{$result->is_read ? 'bg-gray-300' : ''}}">
                        <div class="mb-2">
                            <p class="whitespace-nowrap"><a href="{{$result->notification->link}}"><i class="fas fa-link"></i> Link Here</a></p>
                        </div>
                    </td>
                    <td class="hidden sm:table-cell {{$result->is_read ? 'bg-gray-300' : ''}}">
                        <div class="mb-2">
                            <p>
                                @if($result->is_read)
                                    <a>Read</a>
                                @else
                                    <button class="text-xs px-2 py-1 rounded bg-blue-500 text-white" wire:click="markAsRead({{$result->id}})">Mark As Read</button>
                                @endif
                                
                            </p>
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
