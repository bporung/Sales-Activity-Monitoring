<div class="w-full flex flex-wrap pb-1" x-data="{open : false}">
    <div class="w-full bg-gray-200">
        <div class="w-full h-24 bg-white flex flex-wrap rounded-t border border-gray-500 p-1 overflow-y-auto" 
            x-bind:class="open ? '' : 'rounded-b'">
            <div class="w-full cursor-text flex flex-wrap content-start"  @click="open = true ;$nextTick(() => $refs.input.focus());" @click.away="open = false">
                @if($items)
                    @foreach($items as $key => $item)
                    <p class="flex-none px-2 py-1 bg-yellow-100 border border-yellow-300 text-yellow-700 rounded mr-2 text-xs">{{$item['label']}} <span class="cursor-pointer ml-2 text-xs text-yellow-500 hover:text-yellow-700" wire:click="deleteItem({{$key}})">x</span></p>
                    @endforeach
                @endif
                <input   x-ref="input" placeholder="Cari..." class="flex-grow py-0 px-1 outline-none ring-0 border-0 focus:ring-0 focus:outline-none focus:border-0 rounded" id="skills" type="text" wire:model.debounce.500ms="search" @click="open = true" >
            </div>
        </div>

        <div class="relative w-full" x-show="open">
            @if(!$search || ($search && strlen($search) < 3))
                <div class="absolute w-full bg-white border border-gray-500 z-10 px-2 py-2"><p>Masukkan minimal 3 karakter</p></div>
            @else
                <div class="relative px-2"><small class="text-xs">Pilih Dari Daftar Dibawah : </small></div>
                <div class="absolute w-full  bg-white h-32 z-10 overflow-y-auto">
                    <ul class="w-full" wire:loading.remove  wire:target="search,updateRows">
                        @if($rows)
                            @foreach($rows as $keyRow => $row)
                                <li class="text-xs cursor-pointer bg-yellow-100 border-b border-l border-r border-yellow-300 px-2 py-2"  wire:click="addItem({{$keyRow}})">{{($keyRow + 1).".".$row['label']}}</li>
                            @endforeach
                        @else
                        <li class="cursor-pointer px-2 py-2 border-b border-gray-700">Tidak Ditemukan</li>
                        @endif
                    </ul>
                    <div class="w-full" wire:loading.delay.shortest  wire:target="search,updateRows">
                            <p>Loading...</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>