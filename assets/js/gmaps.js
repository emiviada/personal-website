// Google Maps functionality
var map;
function initMap() {
    const cba = {lat: -31.416667, lng: -64.183333};
    map = new google.maps.Map(document.getElementById('map'), {
      center: cba,
      zoom: 4
    });
    // Add marker
    var marker = new google.maps.Marker({
        position: cba,
        map: map,
        icon: 'assets/images/marker-icon.png',
    title: 'Emiliano Viada\'s location'
    });
}
