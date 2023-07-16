
<div class="w-full">
    @include('component.alert')

    <div class="w-full flex flex-wrap">
        <div class="w-full md:w-1/2 lg:w-3/5 p-2">
            <div class=" bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Email :</p>
                    <p class="font-normal text-lg">{{$result->email}}</p>
                </div>
                <div class="mb-3">
                    <p>Username :</p>
                    <p class="font-normal text-lg">{{$result->username}}</p>
                </div>
                <div class="mb-3">
                    <p>Name :</p>
                    <p class="font-normal text-lg">{{$result->name}}</p>
                </div>
                <div class="mb-3">
                    <p>Role :</p>
                    <p class="font-normal text-lg">{{$result->roles()->first()->name}}</p>
                </div>
            </div>
        </div>

        <!-- <div class="w-full md:w-1/2 lg:w-2/5 p-2">
            <div class="bg-white p-4 mb-2 shadow">
                <div class="mb-3">
                    <p>Subordinate :</p>
                    <div class="mt-2">
                        @foreach($result->usersubordinates as $usub)
                        <span class="mr-2 px-2 py-1 rounded bg-green-500 text-white">{{$usub->subordinate->name}}</span>
                        @endforeach
                    </div>
                </div>

            </div>
        </div> -->
        
    </div>
        
</div>