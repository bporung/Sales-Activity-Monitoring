
<div class="w-full px-2">

<form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

    <div class="w-full grid grid-cols-none md:grid-cols-2 gap-y-4 gap-x-10">
        <div class="">
            <div class="formFieldWrapper">
                <label class="formFieldName" for="name">Sales Target * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="name" type="text" wire:model.defer.lazy="state.sales_target">
                </div>
                @error('sales_target') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="name">Interaction Target * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="name" type="text" wire:model.defer.lazy="state.interaction_target">
                </div>
                @error('interaction_target') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="name">Customer Target * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="name" type="text" wire:model.defer.lazy="state.customer_target">
                </div>
                @error('customer_target') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            
        </div>


    </div>


    <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5">
        <button class="btnSave" type="submit">Save</button>
    </div>
</form>
    
</div>