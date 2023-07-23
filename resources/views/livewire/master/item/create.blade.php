
<div class="w-full px-2">

<form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

    <div class="w-full grid grid-cols-none md:grid-cols-2 gap-y-4 gap-x-10">
        <div class="">
            <div class="formFieldWrapper">
                <label class="formFieldName" for="name">Code * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="code" type="text" wire:model.defer.lazy="state.code">
                </div>
                @error('code') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="name">Name * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="name" type="text" wire:model.defer.lazy="state.name">
                </div>
                @error('name') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="brand_id">Brand * :</label>
                <div class="w-full">
                    <select class="col-span-3 formField" id="brand_id" type="text" wire:model.defer.lazy="state.brand_id">
                        <option value=''>Choose Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand['id']}}">{{$brand['name']}}</option>
                        @endforeach
                    </select>
                </div>
                @error('brand_id') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="type_id">Type * :</label>
                <div class="w-full">
                    <select class="col-span-3 formField" id="type_id" type="text" wire:model.defer.lazy="state.type_id">
                        <option value=''>Choose Type</option>
                        @foreach($types as $type)
                            <option value="{{$type['id']}}">{{$type['label']}}</option>
                        @endforeach
                    </select>
                </div>
                @error('type_id') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="unit_price">Unit Price * :</label>
                <div class="w-full">
                    <input class="col-span-3 formField" id="unit_price" type="text" wire:model.defer.lazy="state.unit_price">
                </div>
                @error('unit_price') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>

            
        </div>

        <div class="">
            <div class="formFieldWrapper">
                        @php 
                            $categories = '\App\Models\ItemCategory'::all();
                            $countCats = count($categories);
                            $i = 1;
                        @endphp
                    <label class="formFieldName" for="category">Categories * (
                    
                        @foreach($categories as $cat)
                        <span class="mr-2">{{$cat->name}} {{$i < $countCats ? ',' : ' '}}</span>
                        @php $i++ @endphp
                        @endforeach
                        ):</label>
                <div class="w-full">
                    @livewire('component.form.selector.multiselector',[
                        'groupComponentName' => 'CategoryMultiSelector',
                        'componentName' => 'CategoryMultiSelector',
                        'modelName' => 'App\Models\ItemCategory',
                        'searchColumns' => ['name'],
                        'selectedItem' => [] ,
                        'selectedItemId' => [],
                        'exclusionItemId' => isset($groupFlatten['CategoryMultiSelector']) ? $groupFlatten['CategoryMultiSelector'] : [],
                    ], key('category-multi-selector'))
                </div>
                @error('categories') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            <div class="formFieldWrapper">
                <label class="formFieldName" for="description">Description :</label>
                <div class="w-full">
                    <textarea class="col-span-3 formField" id="description" type="text" wire:model.defer.lazy="state.description"></textarea>
                </div>
                @error('description') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
            
            <div class="formFieldWrapper">
                <label class="formFieldName" for="is_active">Status * :</label>
                <div class="w-full">
                    <select class="col-span-3 formField" id="is_active" type="text" wire:model.defer.lazy="state.is_active">
                        <option value=''>Choose Status</option>
                            <option value="1">Active</option>
                            <option value="0">Not Active</option>
                    </select>
                </div>
                @error('is_active') <div class="error"><span>{{ $message }}</span></div> @enderror
            </div>
        </div>

    </div>
                                        


    <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5">
        <button class="btnSave" type="submit">Save</button>
    </div>
</form>
    
</div>