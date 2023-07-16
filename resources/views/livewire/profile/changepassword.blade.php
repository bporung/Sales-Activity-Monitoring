
<div class="w-full px-2">

<form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

    <div class="w-full grid grid-cols-none md:grid-cols-2 gap-y-4 gap-x-10">

        <div class="">
            <div class="formFieldWrapper">
                <label class="formFieldName" for="password">Password * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="password" type="password" wire:model.defer.lazy="state.password">
                </div>
                @error('password') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="password_confirmation">Confirmation Password * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="password_confirmation" type="password" wire:model.defer.lazy="state.password_confirmation">
                </div>
                @error('password_confirmation') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
        </div>

    </div>


    <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5">
        <button class="btnSave" type="submit">Save</button>
    </div>
</form>
    
</div>