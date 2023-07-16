
<div class="w-full text-black">
    
    @push('styles')


    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">
    @endpush

    
    <!-- MAIN INFO -->
    <div class="w-full flex flex-wrap p-2 border border-gray-500 drop-shadow bg-white font-light">
        <div class="w-full md:w-2/4 p-3">
            <div class="mb-3">
                <p>ID :</p>
                <p class="font-normal text-lg">{{$result->id}}</p>
            </div>
            <div class="mb-3">
                <p>Name :</p>
                <p class="font-normal text-lg">{{$result->full_name}}</p>
            </div>
            <div class="mb-3">
                <p>Categories :</p>
                <div class="font-normal text-lg">
                    @foreach($result->categories as $category)
                        <span class="mr-2 border border-blue-500 rounded px-2 py-1">{{$category->name}}</span>
                    @endforeach
                </div>
            </div>
            <div class="mb-3">
                <p>Default PIC :</p>
                <p class="font-normal text-lg">{{$result->defaultcontact->full_name}}</p>
            </div>
            <div class="mb-3">
                <p>Default Address :</p>
                <p class="font-normal text-lg">{{$result->defaultaddress->address}}</p>
                <p class="font-normal text-lg">{{$result->defaultaddress->province->name}}</p>
            </div>
            <div class="mb-3">
                <p>Note :</p>
                <p class="font-normal text-lg">{{$result->note ? $result->note : '-'}}</p>
            </div>
        </div>
        <div class="w-full md:w-2/4 p-3"> 
            <div id='map' class="w-full" style='height: 300px;' wire:ignore></div>
        </div>
    </div>

    <!-- DETAILS -->
    <div class="w-full flex flex-wrap font-light">
        <div class="w-full md:w-1/2 p-3">
            <div class="flex justify-content-beetween">
                <p class="flex-grow">Address List </p>
                <a class="flex-none" href="/customer/{{$result->id}}/address/create"><i class="far fa-edit"></i> Add New</a>
            </div>
            @foreach($result->addresses as $address)
            <div class="w-full rounded bg-gray-200 border border-gray-300 p-3 relative">
                    <a href="/customer/{{$result->id}}/address/{{$address->id}}/edit" class="absolute top-2 right-2"><i class="far fa-edit"></i> Edit</a>
                    <p>[ {{$address->status == '1' ? 'Default' : 'Additional'}} ]</p>
                    <p>{{$address->address}}</p>
                    <p>{{$address->province->name}},{{$address->city->name}},{{$address->district->name}},{{$address->village->name}} {{$address->zipcode}}</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{$address->latitude}} , {{$address->longitude}}</p>
            </div>
            @endforeach
        </div>
        <div class="w-full md:w-1/2 p-3">
            <div class="flex justify-content-beetween">
                <p class="flex-grow">Contact List </p>
                <a class="flex-none" href="/customer/{{$result->id}}/contact/create"><i class="far fa-edit"></i> Add New</a>
            </div>
            @foreach($result->contacts as $contact)
            <div class="w-full rounded bg-gray-200 border border-gray-300 p-3 relative">
                    <a href="/customer/{{$result->id}}/contact/{{$contact->id}}/edit" class="absolute top-2 right-2"><i class="far fa-edit"></i> Edit</a>
                    <p>[ {{$contact->status == '1' ? 'Default' : 'Additional'}} ]</p>
                    <p>{{$contact->full_name}}</p>
                    <p><i class="fas fa-phone-square"></i> {{$contact->phone_number}}</p>
                    <p>{{$contact->description}}</p>
            </div>
            @endforeach
        </div>
    </div>
        
    @push('scripts')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
    <script>
        document.addEventListener('livewire:load',() => {
                var coordinate = @this.coordinate
                var coor = coordinate.split('/').map(function(item) {
                    return parseFloat(item,10);
                });
                const defaultLocation = [coor[1],coor[0]]

                mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
                const map = new mapboxgl.Map({
                    container: 'map',
                    center: defaultLocation,
                    zoom: 14,
                });
                const style = "dark-v10"
                map.setStyle(`mapbox://styles/mapbox/${style}`)

                map.addControl(new mapboxgl.NavigationControl())
                const marker1 = new mapboxgl.Marker().setLngLat(defaultLocation).addTo(map);

                map.on('idle',function(){map.resize()})

    })
    </script>
    @endpush
</div>