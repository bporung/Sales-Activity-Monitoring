
<div class="w-full px-2">
    @push('styles')


    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">
    @endpush

    @push('header')
    <div class="grid grid-cols-2">
            <div class="mt-5">
                <a href="/customer" class=" px-3 py-2 text-gray-500 hover:text-blue-700 hover:border-blue-700 transition-all mr-2">All</a>
                <a  class="font-bold px-3 py-2 text-gray-500 hover:text-blue-700 hover:border-blue-700 transition-all mr-2">Create New</a>
            </div>
            <div class="mt-2 flex"></div>
    </div>
    @endpush
    

    <!-- <div class="w-full border-b border-gray-300 mb-5 pt-2 pb-3"><p>Create new customer</p></div> -->
    <form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

        <div class="w-full grid grid-cols-none md:grid-cols-2 gap-y-4 gap-x-10">
            <div class="">
                <div class="w-full">
                    <label for="name">Name * :</label>
                    <div class="w-full grid grid-cols-4 gap-x-2">
                        <select class="col-span-1 rounded" type="text" wire:model.defer.lazy="state.title_id">
                                <option></option>
                            @foreach($customertitles as $customertitle)
                                <option value="{{$customertitle['id']}}">{{$customertitle['label']}}</option>
                            @endforeach
                        </select>
                        <input class="col-span-3 rounded" id="name" type="text" wire:model.defer.lazy="state.name">
                    </div>
                    @error('title_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                    @error('name') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="w-full">
                    <label for="category">Category * :</label>
                    @livewire('component.form.selector',
                    [
                        'componentName' => 'categories',
                        'selectorType' => 'multiple',
                        'rows' => $categories,
                        'exclutionMode' => true,
                        'exclutionTarget' => 'self',
                        'items' => $selectedCategories,
                    ], key('categorieselection0'))
                    @error('categories') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>

                <div class="w-full border-b border-gray-300 mb-5 pt-5 pb-3 font-semibold"><p>Contact</p></div>
                <div class="w-full">
                    <label for="contact_name">Name * :</label>
                    <div class="w-full grid grid-cols-4 gap-x-2">
                        <select class="col-span-1 rounded" type="text" wire:model.defer.lazy="state.contact.title_id">
                            <option></option>
                            @foreach($contacttitles as $contacttitle)
                            <option value="{{$contacttitle['id']}}">{{$contacttitle['label']}}</option>
                            @endforeach
                        </select>
                        <input class="col-span-3 rounded" id="contact_name" type="text" wire:model.defer.lazy="state.contact.name">
                    </div>
                    @error('contact.title_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                    @error('contact.name') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="w-full">
                    <label for="contact_phone">Phone * :</label>
                    <div class="w-full flex">
                        <span class="flex-none px-5 py-2">+62</span>
                        <input class="flex-grow rounded" id="contact_phone" type="text" wire:model.defer.lazy="state.contact.phone">
                    </div>
                    @error('contact.phone') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="w-full">
                    <label for="contact_email">Email :</label>
                    <input class="w-full rounded" id="contact_email" type="text" wire:model.defer.lazy="state.contact.email">
                    @error('contact.email') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="w-full">
                    <label for="contact_description">Description :</label>
                    <textarea class="w-full rounded" id="contact_description"  wire:model.defer.lazy="state.contact.description"></textarea>
                    @error('contact.description') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="" x-data="{openMap:false}">
                
                <div class="w-full border-b border-gray-300 mb-5 pt-5 pb-3 font-semibold"><p>Location</p></div>
                <div class="w-full mb-3">
                    <label for="address">Address *:</label>
                    <textarea class="w-full rounded" id="address"  wire:model.defer.lazy="state.address"></textarea>
                    @error('address') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                
                <div class="w-full mb-3">
                    <label for="village">Province / City / District / Village * :</label>
                    @livewire('component.form.selector',
                    [
                        'componentName' => 'locations',
                        'selectorType' => 'single',
                        'fetchFunctionName' => 'getLocations',
                        'items' => [$selectedLocation],
                    ], key('locationselection0'))
                    @error('location') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="w-full grid grid-cols-2 gap-y-4 gap-x-10 mb-3">
                    <div class="w-full">
                        <label for="zipcode">Zipcode:</label>
                        <input class="w-full rounded" id="zipcode" type="text" wire:model.defer.lazy="state.zipcode">
                        @error('zipcode') <div class="error"><span>{{ $message }}</span></div> @enderror
                    </div>
                    <div class="w-full">
                        <label for="coordinate">Coordinate Lat/Lng * <button type="button" class="bg-green-500 text-white rounded px-2 text-xs" @click="openMap = !openMap">Open Map</button>:</label>
                        <input class="w-full rounded" id="coordinate" type="text" wire:model.defer.lazy="coordinate">
                        @error('coordinate') <div class="error"><span>{{ $message }}</span></div> @enderror
                    </div>
                </div>
                
                <div class="w-full mb-3" x-show="openMap">
                    <button class="px-2 py-1 bg-blue-500 rounded text-white"  type="button" id="findLocation">Find My Location</button>
                    <div id='map' class="w-full" style='height: 300px;' wire:ignore></div>
                </div>
            </div>

        </div>

        <div class="w-full mt-5">
            <label for="note">Notes :</label>
            <textarea class="w-full rounded" id="note"  wire:model.defer.lazy="state.note"></textarea>
            @error('note') <div class="error"><span>{{ $message }}</span></div> @enderror
            
        </div>

        <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5">
            <button class="px-2 py-1 bg-blue-500 rounded text-white" type="submit">Save</button>
        </div>

    </form>
        
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

                const geocoder = new MapboxGeocoder({ accessToken: mapboxgl.accessToken,mapboxgl: mapboxgl,marker: false });
                map.addControl(geocoder);
                map.addControl(new mapboxgl.NavigationControl())

                const marker1 = new mapboxgl.Marker().setLngLat(defaultLocation).addTo(map);

                map.on('click',(e) => {
                    marker1.setLngLat([e.lngLat.lng,e.lngLat.lat])
                    @this.coordinate = e.lngLat.lat + '/' + e.lngLat.lng
                })

                document.getElementById("findLocation").onclick = function() {
                    if(!navigator.geolocation) {
                        console.log('Geolocation is not supported by your browser');
                    } else {
                        console.log('Locating…');
                        navigator.geolocation.getCurrentPosition(position => {
                            @this.coordinate = position.coords.latitude + '/' + position.coords.longitude
                            marker1.setLngLat([position.coords.longitude , position.coords.latitude])
                            map.flyTo({center: [position.coords.longitude , position.coords.latitude]});
                        })
                    }
                };

                map.on('idle',function(){map.resize()})
    })
    </script>
    @endpush
</div>