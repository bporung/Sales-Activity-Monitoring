<div>
<div class="w-full flex flex-wrap pb-1" x-data="{open : false}">
    <div class="w-full bg-gray-200">
        <div class="formField h-24 bg-white flex flex-wrap rounded-t border border-gray-500 p-1 overflow-y-auto" 
            x-bind:class="open ? '' : 'rounded-b'">
            <div class="w-full cursor-text flex flex-wrap content-start"  @click="open = true ;$nextTick(() => $refs.input.focus());" @click.away="open = false">
                @if($items)
                    @foreach($items as $key => $item)
                    <p class="flex-none px-2 py-1 bg-white border border-gray-500 text-gray-800 rounded mr-2 text-xs">{{$item['label']}} <span class="cursor-pointer ml-2 text-xs text-gray-500 hover:text-gray-700" wire:click="deleteItem({{$key}})">x</span></p>
                    @endforeach
                @endif
                <input   x-ref="input" placeholder="Cari..." 
                class="flex-grow py-0 px-1 outline-none ring-0 border-0 focus:ring-0 focus:outline-none focus:border-0 rounded" 
                id="skills" type="text" wire:model.debounce.500ms="search" @click="open = true" >
            </div>
        </div>

        <div class="relative w-full" x-show="open">
            @if((!$search || ($search && strlen($search) < 3)) && $fetchFunctionName)
                <div class="absolute w-full bg-white border border-gray-500 z-10 px-2 py-2"><p>Masukkan minimal 3 karakter</p></div>
            @else
                <div class="absolute w-full  bg-white max-h-32 z-10 overflow-y-auto">
                    <ul class="w-full" wire:loading.remove  wire:target="search">
                        @if($rows)
                            @foreach($rows as $keyRow => $row)
                                @if($exclutionMode && $exclutionMode == 'self')
                                        @php
                                            if($selectedItems){
                                                if(in_array($row['id'],$selectedItems)){
                                                    continue;
                                                }
                                            }
                                        @endphp
                                @endif
                                @if($search && !$fetchFunctionName)
                                        @php 
                                            if(strpos(strtolower($row['label']),strtolower($search)) === false){
                                                continue;
                                            }
                                        @endphp
                                @endif
                                <li class="text-xs text-gray-900 cursor-pointer bg-white hover:bg-gray-100 border-b border-l border-r border-gray-500 px-2 py-2"  wire:click="addItem({{$keyRow}})">{{$row['label']}}</li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="w-full" wire:loading.delay.shortest  wire:target="search">
                            <p>Loading...</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>