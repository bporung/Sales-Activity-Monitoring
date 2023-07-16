<div class="flex flex-wrap bg-white">
    <div class="flex-grow md:flex-none mr-0 ml-auto p-2">
        <input type="text" class="rounded border-gray-500 mr-2" wire:model.debounce.500ms="search" placeholder="Search...">
        <!-- @if($exportExcel)
        <button class="bg-green-500 px-3 py-2 text-white rounded mr-2" wire:click="exportedExcel">Excel</button>
        @endif
        @if($exportPDF)
        <button class="bg-red-500 px-3 py-2 text-white rounded" wire:click="exportedPDF">PDF</button>
        @endif -->
    </div>
    @if($readStatusCheckbox)
    <div class="flex-none p-2">
        <div class="bg-gray-200 rounded p-2 relative">
        <div class="inline mx-2"><input type="checkbox" wire:model="readstatus.is_read" class="mr-1" id="isread"><label for="isread">Is Read</label></div>
        <div class="inline mx-2"><input type="checkbox" wire:model="readstatus.is_not_read" class="mr-1" id="notread"><label for="notread">Not Read</label></div>
        </div>
    </div>
    @endif
    @if($created_date_field)
    <div class="flex-none p-2">
        <div class=" bg-gray-200 rounded pt-2 relative">
            <!-- <label class="absolute -top-1 left-1 text-gray-500" style="font-size:7px;">Created Date</label> -->
            <div class="inline-block mx-2"><i class="far fa-calendar-alt text-lg"></i> <input type="date" wire:model="created_date.start" class="h-8 border-b border-t-0 border-l-0 border-r-0 text-xs 
                {{!$created_date['start'] && $created_date['end'] ? 'bg-red-400' : 'bg-transparent'}}" ></div>
            <div class="inline-block mx-2"><i class="fas fa-calendar-alt text-lg"></i> <input type="date" wire:model="created_date.end" class="h-8 border-b border-t-0 border-l-0 border-r-0 text-xs  
                {{($created_date['start'] && !$created_date['end']) || ($created_date['end'] < $created_date['start']) ? 'bg-red-400' : 'bg-transparent'}}" ></div>
        </div>
    </div>
    @endif




    @if($users)
    <div x-data="{ show: @entangle('showAdvancedSearch') }">
        <div class="flex-none p-2 items-center">
                <button class="px-2 py-1 bg-blue-500 rounded h-10" x-on:click="show = true"><i class="fas fa-search-plus"></i> Advanced Search</button>
        </div>

    <div 
        x-show="show"
        x-on:keydown.escape.window="show = false"
        class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="show"  class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="show"  x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all 
                    sm:my-8 sm:align-middle max-w-full sm:max-w-xl md:max-w-3xl lg:max-w-5xl w-full sm:w-full">
                    <div class="border-b p-2 bg-gray-300">Advanced Search</div>
                    <div class="bg-gray-100 p-1">
                        <div class="w-full p-2 flex flex-wrap">
                            @if($users)
                            <div class="w-full">
                                <div class="formFieldWrapper">
                                    <label class="formFieldName" for="users">User *:</label>
                                    @livewire('component.form.selector.multiselector',[
                                                'groupComponentName' => 'UserMultiSelector',
                                                'componentName' => 'UserMultiSelector',
                                                'modelName' => 'App\Models\User',
                                                'searchColumns' => ['name','username','email'],
                                                'selectedItem' => isset($advSearch['selectedUsers']) ? $advSearch['selectedUsers'] : [] ,
                                                'selectedItemId' => isset($groupFlatten['UserMultiSelector']) ? $groupFlatten['UserMultiSelector'] : [],
                                                'exclusionItemId' => isset($groupFlatten['UserMultiSelector']) ? $groupFlatten['UserMultiSelector'] : [],
                                            ], key('item-multiple-selector-1'))
                                </div>
                            </div>
                            @endif
                            <div class="w-full">
                                <button type="button" class="mt-3 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm " wire:click="runAdvancedSearch">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3  flex flex-row-reverse">
                        <button x-on:click="show = false" type="button" class="mt-3 inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-0 ml-3 w-auto text-sm">
                        Close
                        </button>
                    </div>
                </div>
            </div>
    </div>
    </div>

    @endif
</div>