

<div class="w-full px-2">
    @push('styles')
    @endpush

    @push('header')
    @endpush
    

    <form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">
        <div class="w-full flex flex-wrap justify-between">
            <div class="w-full md:w-2/3 p-3">
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="contact_name">Customer * :</label>
                    <div class="w-full grid grid-cols-4 gap-x-2">
                        <input class="col-span-1 formField" id="customer_id" type="text" value="{{$customer->id}}" readonly>
                        <input class="col-span-3 formField" id="customer_name" type="text" value="{{$customer->full_name}}" readonly>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="formFieldWrapper">
                        <label class="formFieldName" for="contact">Type *:</label>
                        <select class="formField" id="contact" type="text" wire:model.defer.lazy="state.type_id">
                            <option></option>
                            @foreach($interactiontypes as $interactiontype)
                            <option value="{{$interactiontype->code}}">{{$interactiontype->label}}</option>
                            @endforeach
                        </select>
                        @error('type_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                    </div>
                    <div class="formFieldWrapper">
                        <label class="formFieldName" for="contact">Stage *:</label>
                        <select class="formField" id="contact" type="text" wire:model.defer.lazy="state.stage_id">
                            <option></option>
                            @foreach($interactionstages as $interactionstage)
                            <option value="{{$interactionstage->id}}">{{$interactionstage->label}}</option>
                            @endforeach
                        </select>
                        @error('stage_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                    </div>
                </div>

                @if($groupselection)
                <div class="bg-gray-300 p-3 shadow border border-gray-400 mb-3" x-data="{createNew : false}">
                    <div class="formFieldWrapper">
                        <div class="flex items-center">
                        <input type="checkbox" id="createNewGroup" wire:model.defer.lazy="state.createNewGroup" x-model="createNew">
                        <label class="formFieldName ml-3" for="createNewGroup">Create New Group</label>
                        </div>
                        @error('email') <div class="error"><span>{{ $message }}</span></div> @enderror
                    </div>
                    <div>
                        <div class="formFieldWrapper transition-all">
                            <label class="formFieldName" for="contact">Group *:</label>
                                <input x-show="createNew" type="text"   class="formField" id="group_name" placeholder="Insert new group name to create..."  wire:model.defer.lazy="state.group_name">
                                <select x-show="!createNew" class="formField" id="group_id" type="text" wire:model.defer.lazy="state.group_id">
                                    <option></option>
                                    @foreach($customer->interactiongroups as $interactiongroup)
                                    <option value="{{$interactiongroup->id}}">{{$interactiongroup->label}}</option>
                                    @endforeach
                                </select>
                            @error('group_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                            @error('group_name') <div class="error"><span>{{ $message }}</span></div> @enderror
                        </div>
                    </div>
                </div>
                @endif
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="description">Description *:</label>
                    <textarea class="formField" id="description"  wire:model.defer.lazy="state.description"></textarea>
                    @error('description') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                
            </div>

            <div class="w-full p-3">
                
            <div class="formFieldWrapper bg-green-800 text-white py-2 px-2 rounded">
                <div class="flex items-center">
                <input type="checkbox" id="addDetailItems" wire:model="addDetailItems">
                <label class="formFieldName ml-3" for="addDetailItems">Show Item(s) Table</label>
                </div>
                @error('email') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div x-data="{addItems : @entangle('addDetailItems')}">
                <div x-show="addItems">
                    <div class="formFieldWrapper hidden md:block">
                        <label class="formFieldName" for="items">Item(s) :</label>
                        <div class="tableDataWrapper">
                            <table class="tableData">
                                <thead>
                                    <tr>
                                        <th class="w-3/5">Item</th>
                                        <th class="w-1/5">Qty</th>
                                        <th class="w-1/5">Unit Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($state['details'] as $keyDetail => $detail)
                                    <tr>
                                        <td>
                                        @livewire('component.form.selector.singleselector',[
                                            'groupComponentName' => 'ItemSingleSelector',
                                            'componentName' => 'ItemSingleSelector'.$keyDetail,
                                            'modelName' => 'App\Models\Item',
                                            'searchColumns' => ['name','code'],
                                            'selectedItem' => [] ,
                                            'selectedItemId' => '',
                                            'exclusionItemId' => isset($groupFlatten['ItemSingleSelector']) ? $groupFlatten['ItemSingleSelector'] : [],
                                        ], key('item-single-selector-'.$keyDetail))
                                        @error('details.'.$keyDetail.'.item_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                                        </td>
                                        <td>
                                            <input type="text" placeholder="" class="formField"  wire:model.defer.lazy="state.details.{{$keyDetail}}.qty">
                                            @error('details.'.$keyDetail.'.qty') <div class="error"><span>{{ $message }}</span></div> @enderror
                                        </td>
                                        <td>
                                            <input type="text" placeholder="" class="formField"  wire:model.defer.lazy="state.details.{{$keyDetail}}.unit_price">
                                            @error('details.'.$keyDetail.'.unit_price') <div class="error"><span>{{ $message }}</span></div> @enderror
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"><div class="text-center"><button type="button" wire:click="addItem" class="px-2 py-1 rounded bg-green-700 text-white">Add</button>
                                        <button type="button" wire:click="delItem" class="px-2 py-1 rounded bg-red-700 text-white">Del</button>
                                        </div></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    
                    </div>

                    <div class="formFieldWrapper block md:hidden">
                        <div>
                            @foreach($state['details'] as $key => $detail)
                                <div class="w-full mb-3 flex flex-wrap p-3 rounded bg-gray-200 border-gray-200 border">
                                    <div class="w-full flex items-center">
                                        <p class="whitespace-nowrap pr-2">Item : </p>
                                        @livewire('component.form.selector.singleselector',[
                                            'groupComponentName' => 'ItemSingleSelector',
                                            'componentName' => 'ItemSingleSelector'.$key,
                                            'modelName' => 'App\Models\Item',
                                            'searchColumns' => ['name','code'],
                                            'selectedItem' => [] ,
                                            'selectedItemId' => '',
                                            'exclusionItemId' => isset($groupFlatten['ItemSingleSelector']) ? $groupFlatten['ItemSingleSelector'] : [],
                                        ], key('mobileview-item-single-selector-'.$key))
                                        
                                    </div>
                                    <div class="w-full flex items-center">
                                        <p class="whitespace-nowrap pr-2">Unit Price : </p>
                                        <input type="text" placeholder="Rp." class="formField border-0"  wire:model.defer.lazy="state.details.{{$key}}.unit_price">
                                    </div>
                                    <div class="w-full flex py-2">
                                        <div class="flex-none items-center  justify-items-end mr-0 ml-auto" x-data="{qty : 0}">
                                            <button class="w-8 h-8 rounded bg-gray-400 p-1" type="button" @click="qty > 0 ? qty = qty - 1 : qty = 0"> < </button>
                                            <input type="text" class="w-24 h-10 mx-2 rounded" wire:model.defer.lazy="state.details.{{$key}}.qty" x-model="qty">
                                            <button class="w-8 h-8 rounded bg-gray-400 p-1" type="button" @click="qty = qty + 1"> > </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="w-full text-center">
                                <button type="button" wire:click="addItem" class="px-2 py-1 rounded bg-green-700 text-white">Add</button></div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
            <!-- Media File(s) -->
            <div class="w-full flex flex-wrap p-3 order-last md:order-none">
                <div class="p-1 w-full">
                <div class="w-full bg-gray-300 p-2" 
                    x-data="{ isUploading: false, progress: 0 }"
                    x-on:livewire-upload-start="isUploading = true"
                    x-on:livewire-upload-finish="isUploading = false"
                    x-on:livewire-upload-error="isUploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    >
                    <label class="formFieldName">Image:</label>
                    <input type="file" wire:model="state.images" multiple>
                    @error('images') <div class="error"><span>{{ $message }}</span></div> @enderror
                    <!-- Progress Bar -->
                    <div x-show="isUploading">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                    @if(isset($state['images']) && $state['images'])
                    <div class="p-2 w-full flex flex-wrap">
                        <div class="w-full py-1"><p>Image(s) Preview : </p></div>
                        @foreach($state['images'] as $image)
                        <div class="w-1/2 sm:w-1/2 md:w-1/2 lg:w-1/3 p-1 h-24 md:h-40 lg:h-40 shadow">
                            <img class="h-full w-full" src="{{ $image->temporaryUrl() }}" style="object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                </div>
            </div>
            <!-- Media File(s) -->

        </div>

        <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5 order-last">
            <button class="btnSave" type="submit">Save</button>
        </div>
    </form>
        
    @push('scripts')
    @endpush
</div>