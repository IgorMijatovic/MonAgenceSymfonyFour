import L from 'leaflet'
import 'leaflet/dist/leaflet.css'

export default class Map
{
    static init()
    {
        let map = document.querySelector('#map')
        if (map === null) {
            return
        }

        let icon =  L.icon({
            iconUrl: '/images/marker-icon.png',
            // iconSize:     [38, 95], // size of the icon
            // shadowSize:   [50, 64], // size of the shadow
            // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
            // shadowAnchor: [4, 62],  // the same for the shadow
            // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
        });

        let center = [map.dataset.lat, map.dataset.lng]
        map = L.map('map').setView(center, 13)
        //token od mapbox za apparence od karte
        let token = 'pk.eyJ1IjoiaW1pamF0b3ZpYyIsImEiOiJjam9uYm1reXEwNGd4M3FxeWt4bDRlZ2l3In0.ciC1m_M-DunFjdi-c6eR2Q'
        L.tileLayer(`https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=${token}`, {
            maxZoom: 18,
            minZoom: 12,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        }).addTo(map)
        L.marker(center, {icon:icon}).addTo(map)
    }
}