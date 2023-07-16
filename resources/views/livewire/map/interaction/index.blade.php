@push('styles')
<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">
@endpush

<div class="flex">
    @push('header')
        @livewire('component.search.search-v1',
        [
            'parentComponent' => 'map.interaction.index',
            'exportExcel' => false,
            'exportPDF' => false,
            'created_date_field' => true,
            'users' => true,
        ],key('search-1'))
    @endpush

    <div class="w-full flex ">
        <div id='map' class="w-full" style="height:450px;" wire:ignore></div>
    </div>
</div>
@push('scripts')

    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
    <script>
        document.addEventListener('livewire:load',() => {
                renderMap();
        })
        
        window.addEventListener('contentChanged',() => {
                renderMap();
        });

        function renderMap(){
                var defaultLocation = [ 113.921327, -0.789275 ]
                var customers = @this.customers
                mapboxgl.accessToken = '{{env("MAPBOX_KEY")}}';
                const map = new mapboxgl.Map({
                    container: 'map',
                    center: defaultLocation,
                    zoom: 4.5,
                });
                const style = "dark-v10"
                map.setStyle(`mapbox://styles/mapbox/${style}`)

                const geocoder = new MapboxGeocoder({ accessToken: mapboxgl.accessToken,mapboxgl: mapboxgl,marker: false });
                map.addControl(new mapboxgl.NavigationControl())

                map.on('idle',function(){map.resize()})

                for(var i = 0 ; i < customers.length ; i++){
                    let latlng = [ customers[i]['longitude'] , customers[i]['latitude'] ]
                    new mapboxgl.Marker().setLngLat(latlng).addTo(map);
                }
        }
    </script>
    @endpush