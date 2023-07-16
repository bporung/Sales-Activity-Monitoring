
<div class="w-full px-2">
    @push('styles')


    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">
    @endpush

    

    <form class="w-full p-5" wire:submit.prevent="submit" onkeydown="return event.key != 'Enter';">

        <div class="w-full grid grid-cols-none md:grid-cols-2 gap-y-4 gap-x-10">
            <div class="">
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="name">Name * :</label>
                    <div class="w-full grid grid-cols-4 gap-x-2">
                        <select class="col-span-1 formField" type="text" wire:model.defer.lazy="state.title_id">
                                <option></option>
                            @foreach($customertitles as $customertitle)
                                <option value="{{$customertitle['code']}}">{{$customertitle['label']}}</option>
                            @endforeach
                        </select>
                        <input class="col-span-3 formField" id="name" type="text" wire:model.defer.lazy="state.name">
                    </div>
                    @error('title_id') <div class="error"><span>{{ $message }}</span></div> @enderror
                    @error('name') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>

                <div class="formFieldWrapper">
                    <label class="formFieldName" for="category">Category * :</label>
                    @livewire('component.form.selector.multiselector',[
                        'groupComponentName' => 'CategoryMultiSelector',
                        'componentName' => 'CategoryMultiSelector',
                        'modelName' => 'App\Models\Category',
                        'modelCondition' => array('group' => 'CustomerCategory'),
                        'searchColumns' => ['name'],
                        'selectedItem' => [] ,
                        'selectedItemId' => [],
                        'exclusionItemId' => isset($groupFlatten['CategoryMultiSelector']) ? $groupFlatten['CategoryMultiSelector'] : [],
                    ], key('category-multi-selector-1'))
                    @error('categories') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>

                <div class="w-full border-b border-gray-300 mb-5 pt-5 pb-3 font-semibold"><p>Contact</p></div>

                <div class="formFieldWrapper">
                    <label class="formFieldName" for="contact_name">Name :</label>
                    <div class="w-full grid grid-cols-4 gap-x-2">
                        <input class="col-span-3 formField" id="contact_name" type="text" wire:model.defer.lazy="state.pic">
                    </div>
                    @error('pic') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="contact_phone">Phone :</label>
                    <div class="w-full flex">
                        <span class="flex-none px-5 py-2">+62</span>
                        <input class="flex-grow formField" id="contact_phone" type="text" wire:model.defer.lazy="state.phone">
                    </div>
                    @error('phone') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
            </div>

            <div class="" x-data="{openMap:false}">
                
                <div class="w-full border-b border-gray-300 mb-5 pt-5 pb-3 font-semibold"><p>Location</p></div>
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="address">Address *:</label>
                    <textarea class="formField" id="address"  wire:model.defer.lazy="state.address"></textarea>
                    @error('address') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                
                <div class="formFieldWrapper">
                    <label class="formFieldName" for="village">Province / City / District / Village * :</label>
                    @livewire('component.form.selector.singleselector',[
                        'groupComponentName' => 'LocationSingleSelector',
                        'componentName' => 'LocationSingleSelector',
                        'modelName' => 'App\Models\Village',
                        'modelCondition' => [],
                        'searchColumns' => ['name'],
                        'scopeSearching' => TRUE,
                        'selectedItem' => [] ,
                        'selectedItemId' => '',
                        'exclusionItemId' => isset($groupFlatten['LocationSingleSelector']) ? $groupFlatten['LocationSingleSelector'] : [],
                    ], key('location-single-selector-1'))
                    @error('location') <div class="error"><span>{{ $message }}</span></div> @enderror
                </div>
                <div class="w-full grid grid-cols-2 gap-y-4 gap-x-10 mb-3">
                    <div class="formFieldWrapper">
                        <label class="formFieldName" for="zipcode">Zipcode:</label>
                        <input class="formField" id="zipcode" type="text" wire:model.defer.lazy="state.zipcode">
                        @error('zipcode') <div class="error"><span>{{ $message }}</span></div> @enderror
                    </div>
                    <div class="formFieldWrapper">
                        <label class="formFieldName" for="coordinate">Coordinate Lat/Lng * <button type="button" class="bg-green-500 text-white rounded px-2 text-xs" @click="openMap = !openMap">Open Map</button>:</label>
                        <input class="formField" id="coordinate" type="text" wire:model.defer.lazy="coordinate">
                        @error('coordinate') <div class="error"><span>{{ $message }}</span></div> @enderror
                    </div>
                </div>
                
                <div class="w-full mb-3 border border-gray-300 bg-gray-200 p-2" x-show="openMap">
                    <button class="px-2 py-1 bg-blue-500 rounded text-white"  type="button" id="findLocation">Find My Location</button>
                    <div id='map' class="w-full" style='height: 300px;' wire:ignore></div>
                </div>
            </div>

        </div>

        <div class="formFieldWrapper">
            <label class="formFieldName" for="note">Notes :</label>
            <textarea class="formField" id="note"  wire:model.defer.lazy="state.note"></textarea>
            @error('note') <div class="error"><span>{{ $message }}</span></div> @enderror
            
        </div>

        <div class="w-full mt-5 justify-end flex flex-wrap bg-white p-3 mb-5">
            <button class="btnSave" type="submit">Save</button>
        </div>
    </form>
        
    @push('scripts')

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
    <script>
        document.addEventListener('livewire:load',() => {

                var defaultLocation = [ 106.786492, -6.1253833 ]
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