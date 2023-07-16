
<div class="w-full flex flex-wrap" x-data="{open : false}">
    <div class="w-full">
        <div class="formField h-10 bg-white flex flex-wrap rounded-t border border-gray-500 overflow-y-auto items-center" 
            x-bind:class="open ? '' : 'rounded-b'">
            <div class="w-full cursor-text flex flex-wrap content-start"  @click="open = true ;$nextTick(() => $refs.input.focus());" @click.away="open = false">
                @if($selectedItem && count($selectedItem) > 0)
                    <p class="flex-none ml-2 px-2 py-1 bg-white border border-gray-500 text-gray-800 rounded mr-2 text-xs">{{$selectedItem['label']}} <span class="cursor-pointer ml-2 text-xs text-gray-500 hover:text-gray-700" wire:click="deleteItem">x</span></p>
                @endif
                <input   x-ref="input" placeholder="Cari..." 
                class="flex-grow py-0 px-1 outline-none ring-0 border-0 focus:ring-0 focus:outline-none focus:border-0 rounded" 
                id="skills" type="text" wire:model.debounce.500ms="search" @click="open = true" >
            </div>
        </div>

        <div class="relative w-full" x-show="open">
            @if((!$search || ($search && strlen($search) < 3)))
                <div class="absolute w-full bg-white border border-gray-500 z-10 px-2 py-2"><p>Masukkan minimal 3 karakter</p></div>
            @else
                <div class="absolute w-full  bg-white max-h-48 z-10 overflow-y-auto shadow">
                    <ul class="w-full" wire:loading.remove  wire:target="search">
                        @if($rows)
                            @foreach($rows as $keyRow => $row)
                                <li class="text-sm text-black cursor-pointer bg-white hover:bg-blue-800 hover:text-white border-b border-l border-r border-gray-500 px-2 py-3"  wire:click="selectItem({{$keyRow}})">{{$row['label']}}</li>
                            @endforeach
                        @else
                            <li class="text-sm text-black cursor-pointer bg-white hover:bg-blue-800 hover:text-white border-b border-l border-r border-gray-500 px-2 py-3" >Data(s) Not Found</li>
                        @endif
                    </ul>
                    <div class="w-full" wire:loading.delay.shortest  wire:target="search">
                            <p class="text-sm text-black cursor-pointer bg-white hover:bg-blue-800 hover:text-white border-b border-l border-r border-gray-500 px-2 py-3">Loading...</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>