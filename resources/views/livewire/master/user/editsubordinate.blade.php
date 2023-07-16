
<div class="w-full px-2">

<form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

    <div class="w-full grid grid-cols-none md:grid-cols-2 gap-y-4 gap-x-10">
        <div class="">
            <div class="formFieldWrapper">
                <label class="formFieldName" for="name">Name * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="name" type="text" wire:model.defer.lazy="state.name" readonly>
                </div>
                @error('name') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="email">Email * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="email" type="text" wire:model.defer.lazy="state.email" readonly>
                </div>
                @error('email') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="username">Username * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="username" type="text" wire:model.defer.lazy="state.username" readonly>
                </div>
                @error('username') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>

            
        </div>

        <div class="">
            <div class="formFieldWrapper">
                <label class="formFieldName" for="subordinates">Subordinates :</label>
                <div class="w-full">
                    @livewire('component.form.selector.multiselector',[
                        'groupComponentName' => 'SubordinateMultiSelector',
                        'componentName' => 'SubordinateMultiSelector',
                        'modelName' => 'App\Models\User',
                        'searchColumns' => ['name'],
                        'selectedItem' => $selectedSubordinates ,
                        'selectedItemId' => $state['subordinates'],
                        'exclusionItemId' => isset($groupFlatten['SubordinateMultiSelector']) ? $groupFlatten['SubordinateMultiSelector'] : [],
                    ], key('subordinate-multi-selector-1'))
                    @error('subordinates') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
            </div>
        </div>

    </div>


    <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5">
        <button class="btnSave" type="submit">Save</button>
    </div>
</form>
    
</div>