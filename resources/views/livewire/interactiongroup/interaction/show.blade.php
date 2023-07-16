<div>
    <x-modal wire:model="show">
        <div>
            <div class="w-full mb-2">
                <div class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div class="w-full flex justify-between">
                        <div>
                            <p class="font-bold">Interaction(s) Data</p>
                            <p class="text-sm">Quick View for Interaction Data.</p>
                        </div>
                        <div class="flex items-end">
                        @if($result)
                            <a class="py-1 px-2 text-xs border text-gray-600 border-gray-400 hover:text-black transition-all 
                            hover:border-blue-400 hover:bg-blue-400" href="/customer/{{$result['customer_id']}}/interaction/{{$result['id']}}">
                                <i class="fas fa-eye"></i> Show More...
                            </a>
                        @endif    
                        </div>
                    </div>
                </div>
                </div>
            </div>
        
            <div class="w-full flex flex-wrap">
                @if($result)
                    <div class="w-full grid gap-2 grid-cols-1 md:grid-cols-2 mb-2">
                    <div class="bg-white shadow p-2">
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">Description</label>
                            <p class="pl-2">{{$result['description']}}</p>
                        </div>
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">Group</label>
                            <p class="pl-2">{{$result['group']['name']}}</p>
                        </div>
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">Stage</label>
                            <p class="pl-2">{{$result['stage']['name']}}</p>
                        </div>
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">Type</label>
                            <p class="pl-2">{{$result['type']['name']}}</p>
                        </div>
                        
                    </div>
                    <div class="bg-white shadow p-2">
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">Customer</label>
                            <p class="pl-2">{{$result['customer']['id']}} - {{$result['customer']['name']}}</p>
                        </div>
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">PIC</label>
                            <p class="pl-2">{{$result['contact']['name']}} - {{$result['contact']['phone_number']}}</p>
                        </div>
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">Created At</label>
                            <p class="pl-2">{{date("d/m/Y",strtotime($result['created_at']))}}</p>
                        </div>
                        <div class="w-full py-1">
                            <label class="font-semibold text-xs">Registered By</label>
                            <p class="pl-2">{{$result['registered']['name']}}</p>
                        </div>
                    </div>
                    </div>

                    @if($result['details'])
                    <div class="w-full bg-white shadow">
                        <div class="tableDataWrapper" style="height:250px !important;">
                        <table class="tableData">
                            <thead>
                                <tr>
                                    <th>Item(s)</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result['details'] as $detail)
                                <tr>
                                    <td>
                                        <p class="capitalize">{{$detail['item']['code']}}</p>
                                        <p class="capitalize">{{$detail['item']['name']}}</p>
                                    </td>
                                    <td>
                                        {{$detail['qty']}}
                                    </td>
                                    <td>
                                        {{$detail['unit_price']}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </x-modal>
</div>