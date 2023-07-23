

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
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="name">Name *:</label>
                    <input type="text" class="formField" id="name"  wire:model.defer.lazy="state.name">
                    @error('name') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>

                <div class="formFieldWrapper">
                    <label class="formFieldName" for="description">Description *:</label>
                    <textarea class="formField" id="description"  wire:model.defer.lazy="state.description"></textarea>
                    @error('description') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                
            </div>
            <div class="w-full md:w-1/3 p-3">
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="users">User:</label>
                    @livewire('component.form.selector.multiselector',[
                                    'groupComponentName' => 'UserMultiSelector',
                                    'componentName' => 'UserMultiSelector',
                                    'modelName' => 'App\Models\User',
                                    'searchColumns' => ['name','username','email'],
                                    'selectedItem' => isset($state['users']) ? $state['users'] : [] ,
                                    'selectedItemId' => isset($groupFlatten['UserMultiSelector']) ? $groupFlatten['UserMultiSelector'] : [],
                                    'exclusionItemId' => isset($groupFlatten['UserMultiSelector']) ? $groupFlatten['UserMultiSelector'] : [],
                                ], key('item-multiple-selector-1'))
                    @error('hasusers') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
            </div>


        </div>

        <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5 order-last">
            <button class="btnSave" type="submit">Save</button>
        </div>
    </form>
        
    @push('scripts')
    @endpush
</div>