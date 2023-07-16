<div class="w-full px-2">
    @push('styles')
    @endpush

    @push('header')
    @endpush
    

    <div class="w-full">

        <form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">
            <div class="w-full flex flex-wrap justify-between">
                <div class="w-full md:w-2/3 p-3">
                    <div class="formFieldWrapper">
                        <label class="formFieldName" for="contact_name">Report Name * :</label>
                        <div class="w-full">
                            <input class="col-span-1 formField" id="name" type="text"  wire:model.defer.lazy="state.report_name">
                            @error('report_name') <div class="error"><span>{{ $message }}</span></div> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="formFieldWrapper">
                            <label class="formFieldName" for="contact">Start Date *:</label>
                            <input class="formField" id="customer_id" type="date"  wire:model.defer.lazy="state.start_date" >
                            @error('start_date') <div class="error"><span>{{ $message }}</span></div> @enderror
                        </div>
                        <div class="formFieldWrapper">
                            <label class="formFieldName" for="contact">End Date *:</label>
                            <input class="formField" id="customer_id" type="date"   wire:model.defer.lazy="state.end_date">
                            @error('end_date') <div class="error"><span>{{ $message }}</span></div> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5 order-last">
                <button class="btnSave" type="submit">Generate Report</button>
            </div>
        </form>
    </div>

    <div class="pb-5"><h5 class="text-lg">All Generated Sales Performance</h5></div>
    <div class="tableDataWrapper">
        <table class="tableData">
            <thead>
                <tr>
                    <th><span>Name</span><span class="sm:hidden">/Period/Created At/Registered By</span></th>
                    <th class="hidden sm:table-cell">Period</th>
                    <th class="hidden sm:table-cell">Created At</th>
                    <th class="hidden sm:table-cell">Registered By</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $row)
                    <tr>
                        <td class="sm:bg-yellow-300"><a href="/report/user/performances/{{$row->id}}">{{$row->report_name}}</a></td>
                        <td class="sm:table-cell">{{$row->start_date}} to {{$row->end_date}}</td>
                        <td class="sm:table-cell">{{$row->created_at}}</td>
                        <td class="sm:table-cell">{{$row->registered->name}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
