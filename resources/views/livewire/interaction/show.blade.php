
<div class="w-full">
    
    @include('component.alert')

    <div class="w-full relative flex flex-wrap">

        <div class="w-full md:w-1/2 lg:w-3/5  p-2">
            
            <div class=" bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Status :</p>
                    @if($result && !$result->finalized_at)
                    <div class="flex border-t-4 shadow rounded border-gray-600 mt-2  p-3 justify-between">
                        <span class="text-gray-600 text-xl"><i class="fas fa-clock text-3xl"></i> Waiting</span>
                        @if($btnAction['finalize_interaction'])
                        <button type="button" class="text-black text-sm px-2 py-1 border border-black hover:bg-black hover:text-yellow-400 transition-all"  
                        x-data="{}" x-on:click="window.livewire.emitTo('interaction.method.finalizing','show',{{$result}})"> <i class="fas fa-exclamation-triangle"></i> Finalize Now <i class="fas fa-lock"></i></button>
                        @endif
                    </div>
                        @if($btnAction['finalize_interaction'])
                            @livewire('interaction.method.finalizing')
                        @endif
                    @else
                    <div class="flex border-t-4 shadow rounded border-green-600 mt-2  p-3 justify-between">
                        <div>
                        <span class="text-green-600 text-xl"><i class="fas fa-clipboard-check text-3xl"></i> Finalized </span>
                        <span>{{date("d/m/Y H:i",strtotime($result->finalized_at))}}<span>
                        <span>by {{$result->finalized->name}}<span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Group :</p>
                    <p class="font-normal text-lg">{{$result->group->name}}</p>
                </div>
                <div class="mb-3">
                    <p>Stage :</p>
                    <p class="font-normal text-lg">{{$result->stage ? $result->stage->name : '-'}}</p>
                </div>
                <div class="mb-3">
                    <p>Description :</p>
                    <p class="font-normal text-lg">{{$result->description ? $result->description : '-'}}</p>
                </div>
                <div class="mb-3">
                    <p>Total Price :</p>
                    <p class="font-normal text-lg">{{$result->total_price ? number_format($result->total_price,0) : '-'}}</p>
                </div>
            </div>
        </div>

        
        <div class="w-full md:w-1/2 lg:w-2/5 p-2 order-first md:order-none">
            <div class="bg-white border-t-4 border-green-500 p-4 shadow">
                <div class="mb-3">
                    <p>Created At :</p>
                    <p class="font-normal text-lg"><i class="fas fa-calendar-alt"></i> {{date("d/m/Y H:i",strtotime($result->created_at))}}</p>
                </div>
                <div class="mb-3">
                    <p>Type :</p>
                    <p class="font-normal text-lg">{{$result->type ? $result->type->name : '-'}}</p>
                </div>
                <div class="mb-3">
                    <p>Customer :</p>
                    <p class="font-normal text-lg">{{$result->customer_id}} -  {{$result->customer->full_name}}</p>
                </div>
                <div class="mb-3">
                    <p>PIC :</p>
                    <p class="font-normal text-lg">{{$result->customer->pic}} - {{$result->customer->phone}}</p>
                </div>
                <div class="mb-3">
                    <p>Registered By :</p>
                    <p class="font-normal text-lg">{{$result->registered->name}} - {{$result->registered->roles[0]->name}}</p>
                </div>
            </div>
        </div>

        

        @if($result->details && $result->details()->count())
        <div class="w-full p-2">
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
                        @foreach($result->details as $detail)
                        <tr>
                            <td>
                                <p class="capitalize">{{$detail->item->code}}</p>
                                <p class="capitalize">{{$detail->item->name}}</p>
                            </td>
                            <td>
                                {{$detail->qty}}
                            </td>
                            <td>
                                {{$detail->unit_price ? number_format($detail->unit_price,0) : '-'}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
        </div>
        @endif

        @if($result->images && $result->images()->count())
        <div class="w-full p-2">
                <div class="w-full p-1 bg-gray-700 text-white"><p>Image(s) Preview :</p></div>
                <div class="tableDataWrapper bg-white shadow" style="height:250px !important;">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 p-2">
                        @foreach($result->images as $image)
                        <div class="shadow"><img src="{{$image->image}}"></div>
                        @endforeach
                    </div>
                </div>
        </div>
        @endif
        @if($result->total_price )
        <div class="p-2 bg-white fixed bottom-0 right-0">
                <div class="p-2 text-xl text-white" style="border:2px solid red; background:red; font-weight:bolder; text-align:right;">
                            <label>Total Price : </label><label>{{$result->total_price ? number_format($result->total_price,0) : '-'}}</label>
                </div>
        </div>
        @endif

    </div>
        
    @push('scripts')
    
    @endpush
</div>