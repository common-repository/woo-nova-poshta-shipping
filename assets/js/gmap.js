var script = document.createElement('script');
script.src = "//maps.googleapis.com/maps/api/js?sensor=false&callback=initMap";
document.body.appendChild(script);

var map;
var markers = [];
var warehouse;
var warehouse_count;



function initMap() {

    var haightAshbury = {lat: 48.3794, lng: 31.1656};

    map = new google.maps.Map(document.getElementById('map_canvas'), {
        zoom: 14,
        center: haightAshbury,
        mapTypeId: 'roadmap'
    });

    jQuery(function ($) {
        $('.wnps_city').on('change', function (e) {
            var selected = $(".wnps_city option:selected").text();
            $.ajax({
                type: "GET",
                data: "city=" + selected + "&action=wnps_get_warehouses",
                async: false, // # makes request synchronous
                url: ajaxurl.url,
                success: function (resp) {
                    response = JSON.parse(resp);
                    clearMarkers();
                    moveToMarker();
                    placeMarker();

                }
            })

        });

    });

    // var t =  document.getElementById("total_int");
    // document.querySelector("#firstname").addEventListener("change", function(event) {
    //     document.getElementById("demo").innerHTML = "Hello World";
    //     event.preventDefault();
    // }, false);



}


function placeMarker() {

    var options = response;
    var weight_lim = document.getElementById("total_int").textContent;
    var num = parseFloat(weight_lim);

    let arr;


    if ( num <= 30 ||  response.length < 3 ) {
        arr = options.filter(word => word.PlaceMaxWeightAllowed);
    } else {
        arr = options.filter(word => word.PlaceMaxWeightAllowed > 30);
    }


    for (var i = 0; i < arr.length; i++) {
        var wh_data = arr;

        latitude = arr[i].Latitude;
        longitude = arr[i].Longitude;
        if( latitude > 0 && longitude > 0 ){
            var position = {lat: Number(latitude), lng: Number(longitude)};
        }

        var marker = new google.maps.Marker({
            position: position,
            icon: 'https://novaposhta.ua/uploads/misc/img/google/cargo.png', // null = default icon
            map: map
        });

        markers.push(marker);

        var infowindow = new google.maps.InfoWindow({
            maxWidth: 150
        });

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent('<h5 id="warehouse_num">' + wh_data[i]['Description'] + '</h5>' +
                    '<div id="warehouse_time">' + '<span class="wnps_open">' + wh_data[i]['Phone'] + '</span>' + '<span class="wnps_close">' + '' + '</span>' + '</div>' + '<div id="warehouse_weight">' + '' + '</div>' + '</div>')
                infowindow.open(map, marker);
            }
        })(marker, i));


    }

}


function moveToMarker() {
    warehouse_count = Object.keys(response).length;
    for (var i = 0; i < warehouse_count; i++) {


        latitude = 48.3794;
        longitude = 31.1656;

        if( latitude > 0 && longitude > 0 ){
            latitude = response[i].Latitude;
            longitude = response[i].Longitude;
        }

        map.panTo(new google.maps.LatLng( Number(latitude),Number(longitude)));
    }
}


function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
    setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}