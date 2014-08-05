var ipCatMap = new Class({

    Implements: [Events, Chain, Options],

    Binds: ['googleCallback', 'requestComplete', 'createMarker'],

    options: {
        ipbaseurl: '',
        Itemid: 99999,
        showPreview: 1,
        noLimit: 0,
        startPage: 1,
        currencySeparator: ',',
        currencySymbol: '$',
        currencyPosition: 1,
        marker: '/components/com_iproperty/assets/images/map/icon56.png',
        token: '',
        thumbnail: '',
        mapPreviewIcon: '/components/com_iproperty/assets/images/map/map_preview.png',
        propPreviewIcon: '/components/com_iproperty/assets/images/map/prop_preview.png',
        map: {
            zoom: 12,
            maxZoom: 12,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            lat: '47.6725282',
            lng: '-116.7679661'
        },
        templates:{
            infoWindow: '<div class="bubble">' +
                            '{thumb}' +
                            '<h4><a href="{proplink}">{street_address}, {city}</a></h4>' +
                            '<div class="bubble_info"><strong>{pid}: </strong>{mls_id} | <strong>{price}: </strong>{formattedprice}</div>' +
                            '<div class="bubble_desc">{short_description}<div class="bubble_cats">{cat_icons}</div><a href="{proplink}">({more})</a></div>' +
                        '</div>'
        }
    },

    initialize: function(options, data){
        this.setOptions(options);
        this.element = $('ip_catmap');
        this.markers = {};

        this.mapElement = new Element('div', {
            id: 'property_map'
        });

        this.element.adopt([this.mapElement]);

        this.createMap();
        this.requestComplete(data);
    },

    requestComplete: function(data){
        this.fireEvent('requestComplete');
        this.results = data;
        this.updateMap(data);
        this.mapSpinner.hide();
    },

    createMap: function(){
        this.options.map.center = new google.maps.LatLng(this.options.map.lat, this.options.map.lng);
        this.mapInstance = new google.maps.Map(this.mapElement, this.options.map);
        this.infoWindow = new google.maps.InfoWindow({ maxWidth: 450 });
        this.mapSpinner = new Element('div',{id:'loading_div'}).inject(this.mapElement);
        this.mapSpinner.show();
    },

    createMarker: function(house) {
        if(house.lat_pos && house.long_pos && (house.show_map == 1)){
            var latlong = new google.maps.LatLng(house.lat_pos.toFloat(), house.long_pos.toFloat()),
                marker = new google.maps.Marker({
                    position: latlong,
                    map: this.mapInstance,
                    icon: this.options.ipbaseurl+this.options.marker
                }),
                html = this.getMarkerHtml(house);
            this.markers[house.id] = [marker, html];
            google.maps.event.addListener(marker, 'click', function() {
                this.openInfoWindow(house.id);
            }.bind(this));
            this.bounds.extend(latlong);
            return marker;
        }
        else return false;
    },

    getMarkerHtml: function(house) {
        return this.options.templates.infoWindow.substitute(
            $merge(house, {
                street_address: house.street_address.clean(),
                city: house.city.clean(),
                short_description: house.short_description.slice(0,185).trim() + '...',
                thumb: ('<div class="bubble_image"><a href="{proplink}">{thumb}</a>{banner}</div>').substitute(house),
                pid: this.options.text.pid,
                price: this.options.text.price,
                more: this.options.text.more
            })
        );
    },

    updateMap: function(data){
        this.bounds = new google.maps.LatLngBounds();
        data.each(this.createMarker);
        this.mapInstance.fitBounds(this.bounds);

        return this;
    },

    openInfoWindow: function(id) {
        var marker = this.markers[id];
        this.infoWindow.setContent(marker[1])
        this.infoWindow.open(this.mapInstance, marker[0]);
    }
});

function addSlashes(str) {
    str=str.replace(/\"/g,'\'');
    str=str.replace(/\\/g,'\\\\');
    str=str.replace(/\'/g,'\\\'');
    str=str.replace(/\"/g,'\\"');
    str=str.replace(/\0/g,'\\0');
    return str;
}

var tooltip = function(){
    var id = 'tt';
    var top = 3;
    var left = 3;
    var maxw = 300;
    var speed = 10;
    var timer = 20;
    var endalpha = 95;
    var alpha = 0;
    var tt,t,c,b,h;
    var ie = document.all ? true : false;
    return{
        show:function(v,w){
            if(tt == null){
                tt = document.createElement('div');
                tt.setAttribute('id',id);
                t = document.createElement('div');
                t.setAttribute('id',id + 'top');
                c = document.createElement('div');
                c.setAttribute('id',id + 'cont');
                b = document.createElement('div');
                b.setAttribute('id',id + 'bot');
                tt.appendChild(t);
                tt.appendChild(c);
                tt.appendChild(b);
                document.body.appendChild(tt);
                tt.style.opacity = 0;
                tt.style.filter = 'alpha(opacity=0)';
                document.onmousemove = this.pos;
            }
            tt.style.display = 'block';
            c.innerHTML = v;
            tt.style.width = w ? w + 'px' : 'auto';
            if(!w && ie){
                t.style.display = 'none';
                b.style.display = 'none';
                tt.style.width = tt.offsetWidth;
                t.style.display = 'block';
                b.style.display = 'block';
            }
            if(tt.offsetWidth > maxw){tt.style.width = maxw + 'px'}
            h = parseInt(tt.offsetHeight) + top;
            clearInterval(tt.timer);
            tt.timer = setInterval(function(){tooltip.fade(1)},timer);
        },
        pos:function(e){
            var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
            var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
            tt.style.top = (u - h) + 'px';
            tt.style.left = (l + left) + 'px';
        },
        fade:function(d){
            var a = alpha;
            if((a != endalpha && d == 1) || (a != 0 && d == -1)){
                var i = speed;
                if(endalpha - a < speed && d == 1){
                    i = endalpha - a;
                }else if(alpha < speed && d == -1){
                    i = a;
                }
                alpha = a + (i * d);
                tt.style.opacity = alpha * .01;
                tt.style.filter = 'alpha(opacity=' + alpha + ')';
            }else{
                clearInterval(tt.timer);
                if(d == -1){tt.style.display = 'none'}
            }
        },
        hide:function(){
            clearInterval(tt.timer);
            tt.timer = setInterval(function(){tooltip.fade(-1)},timer);
        }
    };
}();
