<div class="flex items-stretch flex-none py-2 px-1">
    <div class="p-2 mr-1 h-10">{{$start_data_page}} to {{$end_data_page}} from {{$total}} item(s)</div>
    <button type="button" class="p-2 mr-1 w-10 border rounded border-gray-500 cursor-pointer h-10 text-center" wire:click="runFirstPage"><<</button>
    <button type="button" class="p-2 mr-1 w-10 border rounded border-gray-500 cursor-pointer h-10 text-center" wire:click="runPreviousPage"><</button>
    <input type="text" class=" mr-1 border rounded border-gray-500 w-10 h-10"  wire:model.lazy="current_page">
    <div class="p-2 mr-1  h-10">of {{$last_page}}</div>
    <button type="button" class="p-2 mr-1 w-10 border rounded border-gray-500 cursor-pointer h-10 text-center" wire:click="runNextPage">></button>
    <button type="button" class="p-2  w-10 border rounded border-gray-500 cursor-pointer h-10 text-center" wire:click="runLastPage">>></button>
</div>