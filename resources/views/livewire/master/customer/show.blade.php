
<div class="w-full">
    
    @push('styles')
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">
    @endpush

    @include('component.alert')
    <div class="w-full flex flex-wrap">
        <div class="w-full p-2 flex flex-wrap">
                <!-- MAP HERE -->
                <div class="w-full bg-white p-4 mb-2 shadow order-last sm:order-none">
                    <div id='map' class="w-full" style='height: 300px;' wire:ignore></div>
                    <div class="mt-3">
                        <a class="px-2 py-1 rounded border border-gray-500 text-gray-500 hover:bg-gray-700 hover:text-white transition-all" href="https://maps.google.com/?q={{$result->latitude}},{{$result->longitude}}" target="_blank"><i class="fas fa-map-marked-alt"></i> Google Maps</a>
                        <a class="px-2 py-1 rounded border border-gray-500 text-gray-500 hover:bg-gray-700 hover:text-white transition-all cursor-pointer" onclick="copyToClipboard()"><i class="far fa-clipboard"></i> Copy To Clipboard</a>
                    </div>
                </div>
                <!-- END OF MAP -->

                <!-- CUSTOMER DATA -->
                <div class="w-full md:w-2/5 lg:w-2/5 bg-white p-4 mb-2 shadow">
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
                    <p>PIC :</p>
                    <p class="font-normal text-lg">{{$result->pic}}</p>
                </div>
                <div class="mb-3">
                    <p>Phone :</p>
                    <p class="font-normal text-lg">{{$result->phone ? '0'.$result->phone : ''}}</p>
                </div>
                <div class="mb-3">
                    <p>Address :</p>
                    <p class="font-normal text-lg">{{$result->address}}</p>
                    <p class="font-normal text-lg">{{$result->province->name}}</p>
                </div>
                <div class="mb-3">
                    <p>Note :</p>
                    <p class="font-normal text-lg">{{$result->note ? $result->note : '-'}}</p>
                </div>
            </div>
            <!-- END OF CUSTOMER DATA -->


            <!-- INTERACTION GROUP -->
            <div class="w-full  md:w-3/5 lg:w-3/5 p-2">
                @livewire('master.customer.interactiongroup.index',[
                    'customer_id' => $result->id,    
                ],key('interactiongroup-1'))
            </div>
            <!-- End Of Interaction Group -->

            

            
        </div>
        <div class="w-full p-2 flex flex-wrap">
           

            

            <!-- INTERACTION -->
            <div class="w-full mt-3 p-2 shadow bg-white">
                @livewire('master.customer.interaction.index',[
                    'customer_id' => $result->id,    
                ],key('interaction-1'))
            </div>
            <!-- End Of Interaction -->
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

    <script>
        function copyToClipboard() {
            var link = "https://maps.google.com/?q={{$result->latitude}},{{$result->longitude}}";
            /* Copy the text inside the text field */
            navigator.clipboard.writeText(link);

            /* Alert the copied text */
            alert("Copied the text: " + link);
            } 
    </script>

    @endpush
</div>