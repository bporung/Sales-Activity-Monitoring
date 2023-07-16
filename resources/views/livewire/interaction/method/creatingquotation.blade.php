<div>
    <x-modal wire:model="show">
        <div class="p-1 rounded">
            <div class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                <p class="font-bold">Creating Quotation</p>
                <p class="text-sm">The form you'll make can't be reverted.</p>
                </div>
            </div>
            </div>
        </div>
        <div class="p-2 mt-2 bg-white shadow w-full flex flex-wrap">
            <div class="formFieldWrapper">
                <label class="formFieldName" for="due_date">Due Date * :</label>
                <input type="date" class="formField" id="due_date"  wire:model.defer.lazy="state.due_date">
                @error('due_date') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="description">Description :</label>
                <textarea class="formField" id="description"  wire:model.defer.lazy="state.description"></textarea>
                @error('description') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="term_condition">Terms and Conditions :</label>
                <textarea class="formField" id="term_condition"  wire:model.defer.lazy="state.term_condition"></textarea>
                @error('term_condition') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName">PPn 10% :</label>
                <div class="inline mx-2">
                    <input type="checkbox"  id="ppn" class="mr-2" wire:model.defer.lazy="state.ppn"><label for="ppn">Include PPn</label>
                </div>
                @error('ppn') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            
            <div class="w-full mt-2 justify-end flex flex-wrap bg-white p-3 mb-5 order-last">
                <button class="bg-white px-3 py-2 border border-gray-700 text-gray-700 hover:bg-black hover:text-white transition-all" type="button" wire:click="submitData"><i class="fas fa-exclamation-triangle"></i> Save</button>
            </div>
        </div>
    </x-modal>
</div>