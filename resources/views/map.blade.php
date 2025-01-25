// Updated resources/views/infrastructure/map.blade.php
@php
    $visJsLoaded = false;
    $visCssLoaded = false;

    if (isset($__data['__env'])) {
        $visJsLoaded = str_contains($__data['__env']->yieldContent('scripts'), 'vis.min.js');
        $visCssLoaded = str_contains($__data['__env']->yieldContent('styles'), 'vis.min.css');
    }
@endphp

@if(config('infrastructure.view.standalone'))
    <!DOCTYPE html>
<html>
<head>
    <title>Infrastructure Map</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.css" rel="stylesheet">
    <style>
        #infrastructure-map {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>
<body>
@else
    @pushOnce('styles')
        @unless($visCssLoaded)
            <link href="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.css" rel="stylesheet">
        @endunless
    @endPushOnce

    @pushOnce('scripts')
        @unless($visJsLoaded)
            <script src="https://cdnjs.cloudflare.com/ajax/libs/vis/4.21.0/vis.min.js"></script>
        @endunless
    @endPushOnce
    @extends(config('infrastructure.view.layout'))

    @section(config('infrastructure.view.section'))
        @endif

        <div id="infrastructure-map"></div>

        <script>
            const nodes = new vis.DataSet({!! json_encode($nodes) !!});
            const edges = new vis.DataSet({!! json_encode($edges) !!});
            const container = document.getElementById('infrastructure-map');
            const data = { nodes, edges };
            const options = {!! json_encode(config('infrastructure.layout')) !!};
            new vis.Network(container, data, options);
        </script>

        @if(config('infrastructure.view.standalone'))
</body>
</html>
@else
    @endsection
@endif
