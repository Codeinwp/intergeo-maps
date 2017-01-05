/* global downloadUrl  */
/* global google  */
/*  global ajaxurl */
/*  global alert */
/*  global igmp */
(function ($, igmp) {

    $(document).ready(function () {

        var win = window.dialogArguments || opener || parent || top;
        var opts = win.intergeo_maps;
        var mapID = null;
        var __map = win.intergeo_maps_current || window.intergeo_maps_maps || [];

        if (igmp.custom) {
            mapID = igmp.custom.mapID;
        }

        for (var i = 0; i < opts.length; i++) {
            var map;
            if (mapID != null && opts[i].container === 'intergeo_map' + mapID) {
                map = __map.map;
                doStuff(opts[i].options, map);
                break;
            } else {
                map = __map[opts[i].container];
                doStuff(opts[i].options, map);
            }
        }

        function doStuff(options, map) {
            console.log(options);
            if (!options.layer) {
                return;
            }

            if (options.layer.custom === true) {
                drawCustomOverlay(options, map);
            }
            if (options.layer.importcsv === true) {
                drawImportedMarkers(options, map);
            }
        }

        function drawImportedMarkers(options, map) {
            var infoWindow = new google.maps.InfoWindow();
            if (mapID != null) {
                google.maps.event.addListener(map, 'click', function () {
                    infoWindow.close();
                });
            }

            downloadUrl(options.xml, function (data) {
                var markers = data.documentElement.getElementsByTagName('marker');
                for (var i = 0; i < markers.length; i++) {
                    var latlng = new google.maps.LatLng(parseFloat(markers[i].getAttribute('lat')),
                        parseFloat(markers[i].getAttribute('lng')));
                    var name = markers[i].getAttribute('name');
                    var icon = markers[i].getAttribute('icon');
                    var marker = new google.maps.Marker({position: latlng, map: map});
                    marker.setIcon(icon);
                    bindInfoWindow(marker, map, infoWindow, name);
                }
            });
        }

        function bindInfoWindow(marker, map, infowindow, html) {
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent(html);
                infowindow.open(map, marker);
            });
        }

        function drawCustomOverlay(options, map) {
            var bounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(options.custom.latsw, options.custom.lonsw),
                new google.maps.LatLng(options.custom.latne, options.custom.lonne)
            );

            CustomOverlay.prototype = new google.maps.OverlayView();
            var overlay = new CustomOverlay(bounds, options.url, map);
        }

        function CustomOverlay(bounds, image, m) {

            // Initialize all properties.
            this.bounds_ = bounds;
            this.image_ = image;
            this.map_ = m;

            // Define a property to hold the image's div. We'll
            // actually create this div upon receipt of the onAdd()
            // method so we'll leave it null for now.
            this.div_ = null;

            // Explicitly call setMap on this overlay.
            this.setMap(m);
        }


        CustomOverlay.prototype.onAdd = function () {
            var div = document.createElement('div');
            div.style.borderStyle = 'none';
            div.style.borderWidth = '0px';
            div.style.position = 'absolute';

            // Create the img element and attach it to the div.
            var img = document.createElement('img');
            img.src = this.image_;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.position = 'absolute';
            div.appendChild(img);

            this.div_ = div;

            // Add the element to the 'overlayLayer' pane.
            var panes = this.getPanes();
            panes.overlayLayer.appendChild(div);
        };

        CustomOverlay.prototype.draw = function () {

            // We use the south-west and north-east
            // coordinates of the overlay to peg it to the correct position and size.
            // To do this, we need to retrieve the projection from the overlay.
            var overlayProjection = this.getProjection();

            // Retrieve the south-west and north-east coordinates of this overlay
            // in LatLngs and convert them to pixel coordinates.
            // We'll use these coordinates to resize the div.
            var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
            var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

            // Resize the image's div to fit the indicated dimensions.
            var div = this.div_;
            div.style.left = sw.x + 'px';
            div.style.top = ne.y + 'px';
            div.style.width = (ne.x - sw.x) + 'px';
            div.style.height = (sw.y - ne.y) + 'px';
        };

        // The onRemove() method will be called automatically from the API if
        // we ever set the overlay's map property to 'null'.
        CustomOverlay.prototype.onRemove = function () {
            this.div_.parentNode.removeChild(this.div_);
            this.div_ = null;
        };

        $('#csvfile').on('change', function () {
            changeFormType($(this));
        });

        $('#intergeo_export_csv').on('click', function (e) {
            e.preventDefault();
            if (mapID == null) {
                alert(igmp.messages.save_map);
                return;
            }
            $('body').css('cursor', 'progress');
            $.ajax({
                url: ajaxurl,
                method: 'post',
                data: {
                    id: mapID,
                    action: igmp.ajax['export'],
                    security: igmp.ajax.nonce
                },
                success: function (data) {
                    var a = document.createElement('a');
                    document.body.appendChild(a);
                    a.style = 'display: none';
                    var blob = new Blob([data.data.csv], {type: 'application/csv'}),
                        url = window.URL.createObjectURL(blob);
                    a.href = url;
                    a.download = data.data.name;
                    a.click();
                    window.URL.revokeObjectURL(url);
                },
                complete: function () {
                    $('body').css('cursor', 'default');
                }
            });
        });
    });


    function changeFormType(file) {
        var enctype = '';
        if ($(file).val().length > 0) {
            enctype = 'multipart/form-data';
            $('#layer_importcsv').val(1);
        } else {
            $('#layer_importcsv').val(0);
        }
        $('#intergeo_frm').attr('enctype', enctype);
    }


})(jQuery, igmp);

