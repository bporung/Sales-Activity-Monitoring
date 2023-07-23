
<div class="w-full">
    @include('component.alert')

    <div class="w-full flex flex-wrap">
        <div class="w-full md:w-1/2 lg:w-3/5 p-2">
            <div class="bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Code :</p>
                    <p class="font-normal text-lg">{{$result->code}}</p>
                </div>
                <div class="mb-3">
                    <p>Name :</p>
                    <p class="font-normal text-lg">{{$result->name}}</p>
                </div>
                <div class="mb-3">
                    <p>Description :</p>
                    <p class="font-normal text-lg whitespace-pre-line">{{$result->description}}</p>
                </div>
                <div class="mb-3">
                    <p>Brand :</p>
                    <p class="font-normal text-lg">{{$result->brand->name}}</p>
                </div>
                <div class="mb-3">
                    <p>Unit Price :</p>
                    <p class="font-normal text-lg">{{number_format($result->unit_price,0)}}</p>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2 lg:w-2/5 p-2">
            <div class="bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Registered by :</p>
                    <p class="font-normal text-lg whitespace-pre-line">{{$result->registered ? $result->registered->name : '-'}}</p>
                </div>
                <div class="mb-3">
                    <p>Status :</p>
                    <p class="font-normal text-lg">{{$result->is_active ? 'Active' : 'Not Active'}}</p>
                </div>
                <div class="mb-3">
                    <p>Type :</p>
                    <p class="font-normal text-lg">{{$result->type ? $result->type->name : ''}}</p>
                </div>
                <div class="mb-3">
                    <p>Categories :</p>
                    <div class="mt-2">
                        @foreach($result->itemcategories as $cat)
                        <span class="mr-2 px-2 py-1 rounded bg-green-500 text-white">{{$cat->category->name}}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</div>