var PropertyWidget = new Class({

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
        marker: '/components/com_iproperty/assets/images/map/marker_orange.png',
        token: '',
        thumbnail: '',
        slideColor: '#64992C',
        mapPreviewIcon: '/components/com_iproperty/assets/images/map/map_preview.png',
        propPreviewIcon: '/components/com_iproperty/assets/images/map/prop_preview.png',
        saveSearch: false,
        radiusSearch: false,
        advLayout: 'table',
        openCriteria: 0,
        nestedCats: 0,
        catCols: 3,
        isMobile: 0,
        text: {
            tprop: 'Results',
            price: 'Price',
            nolimit: 'No Limit',
            pid: 'Property ID',
            street: '<div>Street<span class="street_preview">(Click address to view listing)</span></div>',
            beds: 'Beds',
            baths: 'Baths',
            sqft: 'Ft<sup>2</sup>',
            preview: 'Preview',
            more: 'more',
            inputText: 'ID or Keyword',
            noRecords: 'Sorry, no records were found. Please try again.',
            previous: '&#706 Previous ',
            next: 'Next &#707',
            of: 'of',
            searchopt: 'More Criteria',
            savesearch: 'Save search',
            clearsearch: 'Clear search'
        },
        map: {
            zoom: 12,
            maxZoom: 12,
            streetViewControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            lat: '47.6725282',
            lng: '-116.7679661'
        },
        search: {
            city: '',
            locstate: '',
            province: '',
            region: '',
            country: '',
            stype: '',
            search: '',
            option:'com_iproperty',
            view: '',
            task:'ajax.googleMapAjaxSearch',
            ptype: '',
            waterfront: '',
            reo: '',
            hoa: '',
            format: 'raw'
        },
        inputs: {

        },
        sliders: {

        },
        templates:{
            slider: '<div class="property_slider">' +
                        '<div class="slider_labels">' +
                            '<span class="slider_label_min">{nolimit}</span>{title}<span class="slider_label_max">{nolimit}</span>' +
                        '</div>' +
                        '<div class="slider_element pressed">' +
                            '<div class="slider_knob slider_knob_start"></div>' +
                            '<div class="slider_knob slider_knob_end"></div>' +
                        '</div>' +
                    '</div>',
            infoWindow: '<div class="bubble">' +
                            '{thumb}' +
                            '<h4><a href="{proplink}">{title}</a></h4>' +
                            '<div>{street_address2}</div>' + 
                            '<div> - {city}, {state_code}</div>' +
                        '</div>',
            pager: '<li class="page_range">{pagecount}</li><li class="page_buttons">{previous}{next}</li>',
            pageButton: '<div class="page_button gradient-button {class}" style="display: {display};" />{value}</div>'
        }
    },

    initialize: function(element, options){
        // check if search cookie is set
        this.ipsearchCookie = new Hash.Cookie('ipAdvSearch'+options.Itemid);

        //if ( this.ipsearchCookie.getLength() ){
        //    this.setCookieOptions(this.ipsearchCookie, options);
        //}

        this.setOptions(options);
        this.element = $(element);
        this.markers = {};
        this.sliders = [];
        this.inputs = [];
        this.query = {};
        this.centerMarker = null;
        this.centerCircle = null;
        this.searchRadius = null;
        this.centerRad = null;
        this.centerLatLng = null;
        this.page = this.options.search.limitstart / this.options.search.limit || 1;
        this.scroll = new Fx.Scroll(window, { duration: 400, transition: 'quad:out', offset: { y: -2 } });
        this.catWrapper = new Array();
        // new stuff for shapes
        this.selectedShape = false;
        this.drawingManager = false;

        this.mapElement = new Element('div', {
            id: 'property_map'
        });

        // build the save search element in the toolbar
        this.ipSave = new Element('span', { id: 'ipSaveSearch' });

        this.slidersElement = new Element('div', { id: 'property_sliders' });

        // build div for "clear search" Button
        this.ipClearButton = new Element('div', { id: 'ipClearButton' }).inject(this.slidersElement);

        this.attributesPanel = new Element('div', {
            id: 'property_attributes',
            html: '<div class="property_attributes_wrap"><div id="property_attributes_inputs" class="property_attributes_inputs"></div></div><div id="property_attributes_button" class="property_attributes_button gradient-button">'+this.options.text.searchopt+'</div>',
            events: {
                'click:relay(div.property_attributes_button)': function(){
                    var inputs = this.getPrevious().getFirst();
                    if(!this.hasClass('pressed')) {
                        this.addClass('pressed');
                        inputs.reveal();
                    }
                    else{
                        this.removeClass('pressed');
                        inputs.dissolve();
                    }
                }
            }
        });
        this.attributesPanel.getFirst().getFirst().set('reveal', { duration: 250, transition: 'circ:out' });
        this.propertyList = new Element('div', {id: 'property_list'});
        //this.element.adopt([this.mapElement, this.slidersElement, this.attributesPanel, this.propertyList]);
        this.element.adopt([this.mapElement]);

        $each(this.options.inputs, function(v, k){
            this.addInput(k, v);
        }, this)

        $each(this.options.sliders, function(v, k){
            this.addSlider(k, v);
        }, this)

        this.createMap();
        // build searchtools
        if(this.options.shapetools) this.buildTools();

        this.request = new Request.JSON({
            method: 'get',
            url: this.options.ipbaseurl + 'index.php?'+this.options.token+'=1',
            onComplete: this.requestComplete,
            onError: function(text, error){
                console.log('Error -  Error: '+error+' Response: '+text);
            },
            onFailure: function() {
                console.log('Failure - '+this.getHeader('Status'));
            },
            onException: function(headerName, value) {
                console.log('Exception - '+headerName+': '+value);
            }
        });

        //if (Object.keys(this.options.sliders).length == 0 || this.options.openCriteria){
        //    $('property_attributes_button').addClass('pressed');
        //    $('property_attributes_inputs').reveal();
        //}

        this.search();

    },

    createMap: function(){
        this.options.map.center = new google.maps.LatLng(this.options.map.lat, this.options.map.lng);
        this.mapInstance = new google.maps.Map(this.mapElement, this.options.map);
        this.infoWindow = new google.maps.InfoWindow({ maxWidth: 250 });
        this.mapSpinner = new Element('div',{id:'loading_div'}).inject(this.mapElement);
        this.mapCounter = new Element('span', { id: 'property_counter' }).inject(this.mapElement);
        this.ipSave.inject(document.getElementById('ip_toolbar'));
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
                short_description: house.short_description.slice(0,185).trim().replace(/(<([^>]+)>)/ig,"") + '...',
                thumb: ('<div class="property_thumb_holder advsearch_thumb bubble_image"><a href="{proplink}"><img src="{thumb}" alt="" class="adv_thumbnail" /></a>{banner}</div>').substitute(house),
                pid: this.options.text.pid,
                price: this.options.text.price,
                more: this.options.text.more,
                nolimit: this.options.text.nolimit,
                cat_icons: house.caticons.slice(1)
            })
        );
    },

    addInput: function(title, options){
        var self = this,
            inputWrap = this.attributesPanel.getFirst().getFirst(),
            change = function(){
            if(self.request){
                self.page = 1;
                self.search();
            }
            },
            input = new Element(options.tag, $merge({ id: 'input'+options.value, 'class': 'inputparent'+options.parent, 'title': options.title }, options, {
                'events': $H(options.events || {}).map(function(fn){ return function(e){ fn.call(self, e, this) }; })
            })).inject(
                (options.group) ? ($('property_fieldset_' + options.group) || new Element('fieldset', { id: 'property_fieldset_' + options.group }).inject(inputWrap)) : inputWrap
            );

        if(options.type == 'checkbox' && Browser.Engine.trident);
        else input.addEvent('change', change);

        switch(options.type || options.tag){
            case 'select':
                [options.title, $H(options.value).getKeys()].flatten().each(function(option){
                    iptempinput = new Element('option', {
                        'text': option,
                        'value': (options.value[option]) ? options.value[option] : ''
                    });
                    if (options.selected == options.value[option]) {
                        iptempinput.set('selected', 'selected');
                    }
                    iptempinput.inject(input)
                });
            break;
            case 'checkbox':
                title = options.title ? options.title : title;
                iptempinput = new Element('label', {
                    text: title,
                    value: options.value,
                    'class': (options.parent == 0 && this.options.nestedCats == 1) ? 'ipmaincat' : (options.parent && this.options.nestedCats == 1) ? 'ipsubcat' : 'ipcat', //new 2.0.1
                    events: {
                        'mouseup': function(){
                            if(Browser.Engine.trident){
                                input.checked = !input.checked;
                                change();
                                input.checked = !input.checked;
                    }
                        }
                    }
                });
                if (options.selected){
                    input.checked = true;
                }
                iptempinput.wraps(input)

                
                // New 2.0.1 - wrap subcats in parent category container and if parent category
                // is selected, child options are disabled
                if(options.group == 'ptypes'){
                    var catCols = (this.options.isMobile) ? 2 : this.options.catCols;
                    this.catWrapper[options.value] = new Element('div', {
                        id: 'catwrap'+options.value,
                        'class': 'ipcatwrap col'+catCols
                    }).inject(inputWrap);

                    if(this.options.nestedCats == 1){
                        if(options.parent){
                            iptempinput.inject(this.catWrapper[options.parent]);
                        }else{
                            iptempinput.inject(this.catWrapper[options.value]);
                        }
                        input.addEvent('change', function(){
                            $$('.inputparent'+options.value).each(function(tmp){
                                tmp.disabled = (input.checked) ? true : false;
                            });
                        });
                    }else{
                        iptempinput.inject(this.catWrapper[options.value]);
                    }
                }
                
            break;
        }

        this.inputs.push(input);

        return this;
    },

    addSlider: function(title, options){
        var elements = Elements.from(this.options.templates.slider.substitute({title: options.title}))[0].inject(this.slidersElement),
            slider = new Slider.Extra(elements.getElement('.slider_element'),{rangeBackground: this.options.slideColor}),
            minLabel = elements.getElement('.slider_label_min'),
            maxLabel = elements.getElement('.slider_label_max');

        slider.addRange($merge({
            start: {
                knob: elements.getElement('.slider_knob_start'),
                onChange: function(step){
                    var opt = this.options;
                    var labTxt = (opt.labelFormat) ? formatCurrency(step, opt.labelUnit, opt.labelPos, opt.labelFormat) : ((opt.labelUnit && opt.labelPos == 1) ? addCommas(step) + ' ' + (opt.labelUnit || '') : (opt.labelUnit || '') + ' ' + addCommas(step));
					minLabel.set('text', (opt.noLimit && opt.range.contains(this.previousChange)) ? window.langOptions.nolimit : labTxt);
                }
            },
            end: {
                knob: elements.getElement('.slider_knob_end'),
                onChange: function(step){
                    var opt = this.options;
                    var labTxt = (opt.labelFormat) ? formatCurrency(step, opt.labelUnit, opt.labelPos, opt.labelFormat) : ((opt.labelUnit && opt.labelPos == 1) ? addCommas(step) + ' ' + (opt.labelUnit || '') : (opt.labelUnit || '') + ' ' + addCommas(step));
					maxLabel.set('text', (opt.noLimit && opt.range.contains(this.previousChange)) ? window.langOptions.nolimit : labTxt);
                }
            },
            onComplete: function(){
                if(this.request){
                    this.page = 1;
                    this.search();
                }
            }.bind(this)
        }, options));

        this.sliders.push(slider);

        return this;
    },

    createTable: function(data) {           
        if(this.options.advLayout == 'table' && !this.options.isMobile){
            var tableHeaders = [];
            
            ['price', 'pid', 'street', 'beds', 'baths', 'sqft', 'preview'].each(function(e){
                tableHeaders.push({ content: this.options.text[e] });
            }, this);

            this.table = new HtmlTable({
                properties: {
                    'id': 'prop_table'
                },
                headers: tableHeaders,
                parsers: ['floatLax', 'string', 'string', 'number', 'float', 'number']
            }).enableSort();
        }else{
            this.table = new HtmlTable({
                properties: {
                    'id': 'prop_table',
                    'class': 'ptable adv_overview',
                    'style': 'border: 0px !important;'
                }
            });           
        }
        
        var infoOpener = function(e){
            this.openInfoWindow(e.target.get('resultid'))
        }.bind(this);

        this.table.toElement().addEvents({
            'mouseover:relay(img[preview=mouseover])': infoOpener,
            'mouseover:relay(a[preview=mouseover])': infoOpener,
            'click:relay(img[preview=click])': function(e){
                this.scroll.toElement(this.element).chain(function(){ infoOpener(e) });
            }.bind(this),
            'click:relay(a[preview=click])': function(e){
                this.scroll.toElement(this.element).chain(function(){ infoOpener(e) });
            }.bind(this)
        }).inject(this.propertyList);

        this.createPaging();

        return this;
    },

    createPaging: function(){
        var pagingClick = {
                'mousedown:relay(div.page_button)': function(){
                    this.addClass('pressed');
                },
                'mouseup:relay(div.page_button)': function(){
                    this.removeClass('pressed');
                },
                'click:relay(div.previous_page)': function(e){
                    if(this.page > 1){
                        this.page--;
                        this.search();
                    }
                }.bind(this),
                'click:relay(div.next_page)': function(e){
                    if(this.checkLimit(this.page + 1)){
                        this.page++;
                        this.search();
                    }
                }.bind(this)
            },
            table = this.table.toElement();

        this.pagers = [
            new Element('ul', {
                'class': 'property_pager',
                'events': pagingClick
            }).inject(table, 'before')
        ];

        this.pagers.push(this.pagers[0].clone().addEvents(pagingClick).inject(table, 'after'));

        return this;
    },
    
    checkLimit: function(page){
        var limit = this.options.search.limit,
            max = page * limit;

        // ATTEMPT TO FIX PAGINATION PROBLEM DEPENDING ON LIMIT AND NUMBER OF LISTINGS
        // --> ORIGINAL LINE 
        //return (page > 0 && this.totalCount >= max - limit &&  max >= this.totalCount) ? true : false;
        // -->POSSIBLE SOLUTION? MAX <= THIS.TOTALCOUNT
        //return (page > 0 && this.totalCount >= max - limit &&  max <= this.totalCount) ? true : false;
        // -->SOLUTION? NEW CODE MINUS MAX >= THIS.TOTALCOUNT
        return (page > 0 && this.totalCount >= max - limit) ? true : false;
    },

    getSliderValues: function(){
        var query = {};
        this.slidersElement.getElements('div.slider_knob').retrieve('slider').each(function(slider){
            var opt = slider.options;
            query[opt.parameter] = (opt.noLimit && opt.range.contains(slider.previousChange)) ? '' : slider.previousChange;
        });
        return query;
    },

    getInputValues: function(){
        var query = {};
        this.attributesPanel.getElements('[parameter]').each(function(input){
            var param = input.get('parameter'),
                type = input.get('type')
                isCustom = !!input.get('custom'),
                value = (isCustom) ? ((query[param]) ? ',' : '') + input.value : (type == 'checkbox') ? 1 : input.value,
                blank = (isCustom) ? '' : 0;
                // unset the value of the select list if it's the same as the title/default
            // The following line is way more hard-coded that it should be; required to accomodate specific API choices for ptype parameter values
            query[param] = (query[param] || '') + ((type == 'checkbox') ? ((input.checked) ? value : blank) : value);
        });
        return query;
    },

    saveSearch: function(){
        var ipSearchData = new Hash.Cookie('ipAdvSearch'+this.options.Itemid);
        if(ipSearchData.getLength()){
            // add clear button
            this.addClearButton();
            // create save drawer
            var saveSlide = (document.getElementById('save-panel')) ? new Fx.Slide('save-panel').hide() : null;
            if(saveSlide && (this.options.saveSearch == 1)){
                this.ipSave.set('html', '<a href="javascript:(0)">'+this.options.text.savesearch+'</a>');
                document.id('ipsavesearchstring').set('value', ipSearchData.toQueryString());
                this.ipSave.addEvent('click', function(e){
                    document.id('save-panel').setStyle('display', 'block');
                    e = new Event(e);
                    (saveSlide.open) ? saveSlide.slideOut() : saveSlide.slideIn();
                    e.stop();
                });
            } else {
                //console.log(document.getElementById('save-panel'));
            }
        }
    },

    search: function(){
        this.mapSpinner.show();
        
        this.query = this.options.search;
        
        // add maptools search vars
        if (mapOptions.geopoint){
            this.query.geopoint = JSON.encode(mapOptions.geopoint);
        }

        // remove unused query params to compress cookie size
        var cleanQuery = Object.filter(this.query, function(value, key){
          if (value == 0) return;
          return value;
        });

        // delete unnecessary items from cookie to compress further
        delete cleanQuery.limit;
        delete cleanQuery.limitstart;
        delete cleanQuery.task;
        delete cleanQuery.view;
        delete cleanQuery.option;
        delete cleanQuery.format;

        // set the current search vars as cookie
        this.ipsearchCookie.empty(); // clean out the cookie
        var searchCookie = new Hash.Cookie('ipAdvSearch'+this.options.Itemid);
        searchCookie.extend(cleanQuery);

        this.request.send({data: this.query});
    },

    requestComplete: function(data){
    	
        this.fireEvent('requestComplete');
        this.results = data;
        this.totalCount = data[0].totalcount;
        this.mapCounter.set('html', this.totalCount || 0);
        this.updateMap(data);
        //this.updateTable(data);
        //this.updatePaging(data);
        this.mapSpinner.hide();
        this.saveSearch();
    },

    updateMap: function(data){
        $each(this.markers, function(marker, id, markers){
            marker[0].setMap(null);
            delete markers[id];
        });

        this.bounds = new google.maps.LatLngBounds();
        data.each(this.createMarker);
        if(this.totalCount > 0 && !this.centerLatLng) this.mapInstance.fitBounds(this.bounds);
        
        // check if we have a valid center of map and it's not 0 - 180
		var center = this.bounds.getCenter();
		if((center.lat() === 0) && (center.lng() === -180)) this.mapInstance.setCenter(this.options.map.center);		
        return this;
    },

    updateTable: function(data){
        if(!this.table) this.createTable(data); 
        this.table.push(['']); // add new dummy row to workaround mootools bug
        this.table.empty();

        var tableRows = [];
        var colspan = (this.options.advLayout == 'table') ? 7 : 2;
        
        if (this.totalCount > 0) {
            data.each(function(e, i){
                var hasMarker = this.markers[e.id];
                var row;
                if(this.options.isMobile){
                    row = [
                            '<div class="adv_mobile_wrapper">'+
                                (( hasMarker ) ? '<div class="adv_map_preview"><img src="' + this.options.ipbaseurl + this.options.mapPreviewIcon+'" alt="' + this.options.text.preview + '" resultid="' + e.id + '" href="#preview_'+ e.id +'" preview="click" style="cursor: pointer;" />&nbsp;</div>' : '')+
                                '<div class="property_thumb_holder advsearch_thumb"><a href="' + e.proplink + '"><img src="'+e.thumb+'" alt="" class="adv_thumbnail" /></a></div>' +
                                '<div class="prop_overview_price" align="right">' + e.formattedprice + '</div>'+
                                '<div class="property_overview_title advsearch_overview">' +
                                    '<a resultid="' + e.id + '" href="' + e.proplink + '" ' + ((this.options.showPreview == 1 && hasMarker) ? 'preview="mouseover"' : '') + '>'+e.street_address.clean()+'</a>' +

                                    (( e.city ) ? ' - '+e.city : '') +
                                    (( e.locstate ) ? ', '+e.locstate : '') +
                                    (( e.province ) ? ', '+e.province : '') +
                                    '<br />' +

                                    '<em>' +
                                        (( e.beds ) ? '<strong>'+this.options.text.beds+':</strong> '+e.beds+' &nbsp;&nbsp;' : '') +
                                        (( e.baths && e.baths != '0.00' ) ? '<strong>'+this.options.text.baths+':</strong> '+e.baths+' &nbsp;&nbsp;' : '') +
                                        (( e.sqft ) ? '<strong>'+this.options.text.sqft+':</strong> '+e.sqft+' &nbsp;&nbsp;' : '') +
                                        (( e.lotsize ) ? '<strong>'+this.options.text.lotsize+':</strong> '+e.lotsize+' &nbsp;&nbsp;' : '') +
                                        (( e.lot_acres ) ? '<strong>'+this.options.text.lotacres+':</strong> '+e.lot_acres+' &nbsp;&nbsp;' : '') +
                                        (( e.county ) ? '<strong>'+this.options.text.county+':</strong> '+e.county+' &nbsp;&nbsp;' : '') +
                                        (( e.region ) ? '<strong>'+this.options.text.region+':</strong> '+e.region+' &nbsp;&nbsp;' : '') +
                                    '</em>' +
                                '</div>'+                            
                                //(( e.short_description ) ? '<p>'+e.short_description.replace(/(<([^>]+)>)/ig,"")+'...</p>' : '') +                            
                            '</div>'
                       ]; 
                }else if(this.options.advLayout == 'table'){ //original table layout
                    row = [
                            '<div class="ip_left price">' + e.formattedprice + '</div>',
                            '<div class="ip_centered mls">' + e.mls_id + '</div>',
                            '<a resultid="' + e.id + '" href="' + e.proplink + '" ' + ((this.options.showPreview == 1 && hasMarker) ? 'preview="mouseover"' : '') + '>' + e.street_address.clean() + ', ' + e.city.clean() + '</a>',
                            '<div class="ip_centered beds">' + e.beds + '</div>',
                            '<div class="ip_centered baths">' + e.baths + '</div>',
                            '<div class="ip_centered sqft">' + e.sqft + '</div>',
                            '<div class="ip_centered preview">' +
                            //show marker if available
                            ((hasMarker) ? '<img src="' + this.options.ipbaseurl + this.options.mapPreviewIcon+'" alt="' + this.options.text.preview + '" resultid="' + e.id + '" href="#preview_'+ e.id +'" preview="click" style="cursor: pointer;" />&nbsp;' : '') +
                            //show thumbnail if enabled and available
                            ((this.options.thumbnail && !e.thumb.match('nopic.png')) ? '<img src="' + this.options.ipbaseurl + this.options.propPreviewIcon+'" alt="' + this.options.text.preview + '" onmouseover="tooltip.show(\''+addSlashes('<img src="'+e.thumb+'" alt="" />')+'\');" onmouseout="tooltip.hide();" style="cursor: pointer;" />&nbsp;' : '') +
                            //no marker and no thumbnail - display '--'
                            (((!hasMarker && !this.options.thumbnail) || (!hasMarker && (this.options.thumbnail && e.thumb.match('nopic.png')))) ? '--' : '') +
                            '</div>'
                        ];
                }else{ // new overview layout with thumbnail and description
                    row = [
                            '<div class="property_thumb_holder advsearch_thumb"><a href="' + e.proplink + '"><img src="'+e.thumb+'" alt="" class="adv_thumbnail" /></a></div>' +
                            '<div class="prop_overview_price" align="right">' + e.formattedprice + '</div>',
                            '<div class="property_overview_title advsearch_overview">' +
                                '<a resultid="' + e.id + '" href="' + e.proplink + '" ' + ((this.options.showPreview == 1 && hasMarker) ? 'preview="mouseover"' : '') + '>'+e.street_address.clean()+'</a>' +

                                (( e.city ) ? ' - '+e.city : '') +
                                (( e.locstate ) ? ', '+e.locstate : '') +
                                (( e.province ) ? ', '+e.province : '') +
                                '<br />' +

                                '<em>' +
                                    (( e.beds ) ? '<strong>'+this.options.text.beds+':</strong> '+e.beds+' &nbsp;&nbsp;' : '') +
                                    (( e.baths && e.baths != '0.00' ) ? '<strong>'+this.options.text.baths+':</strong> '+e.baths+' &nbsp;&nbsp;' : '') +
                                    (( e.sqft ) ? '<strong>'+this.options.text.sqft+':</strong> '+e.sqft+' &nbsp;&nbsp;' : '') +
                                    (( e.lotsize ) ? '<strong>'+this.options.text.lotsize+':</strong> '+e.lotsize+' &nbsp;&nbsp;' : '') +
                                    (( e.lot_acres ) ? '<strong>'+this.options.text.lotacres+':</strong> '+e.lot_acres+' &nbsp;&nbsp;' : '') +
                                    (( e.county ) ? '<strong>'+this.options.text.county+':</strong> '+e.county+' &nbsp;&nbsp;' : '') +
                                    (( e.region ) ? '<strong>'+this.options.text.region+':</strong> '+e.region+' &nbsp;&nbsp;' : '') +
                                '</em>' +
                            '</div>' +
                            (( e.short_description ) ? '<p>'+e.short_description.replace(/(<([^>]+)>)/ig,"")+'...</p>' : '') +
                            (( hasMarker ) ? '<div align="right"><img src="' + this.options.ipbaseurl + this.options.mapPreviewIcon+'" alt="' + this.options.text.preview + '" resultid="' + e.id + '" href="#preview_'+ e.id +'" preview="click" style="cursor: pointer;" />&nbsp;</div>' : '')
                       ];                   
                }
                tableRows.push(row);
            }, this);
        }
        else {
            tableRows.push([{
                content: this.options.text.noRecords,
                properties: {
                    'colspan': colspan,
                    'align': 'center'
                }
            }]);
        }
        tableRows.each(function(row){ this.table.push(row) }, this);

        return this;
    },

    updatePaging: function(data){
        /* Thanks to Holzrichter for pagination offset fix - no longer 0-5, but 1-5... */
        var options = this.options.search,
            prevLimit = (this.page * options.limit - options.limit + 1).limit(1, this.totalCount),
            nextLimit = (this.page * options.limit).limit(1, this.totalCount),
            pagingData = {
                pagecount: (nextLimit) ? this.options.text.tprop + ': ' + prevLimit + ' - ' + nextLimit + ' ' + this.options.text.of + ' ' + this.totalCount : '',
                previous: this.options.templates.pageButton.substitute({
                'class': 'previous_page',
                'value': this.options.text.previous,
                'display': (prevLimit <= 1) ? 'none' : 'block'
            }),
            next: this.options.templates.pageButton.substitute({
                'class': 'next_page',
                'value': this.options.text.next,
                'display': (nextLimit >= this.totalCount) ? 'none' : 'block'
            })
        };

        this.pagers.each(function(pager){
            pager.set('html', this.options.templates.pager.substitute(pagingData));
        }, this);

        return this;
    },

    openInfoWindow: function(id) {
        var marker = this.markers[id];
        this.infoWindow.setContent(marker[1])
        this.infoWindow.open(this.mapInstance, marker[0]);
    },

    addClearButton: function(){
        var self = this;
        if(!$('ipClearSearch')){
            var ipClearSearch = new Element('a', {
                id: 'ipClearSearch',
                html: this.options.text.clearsearch,
                href: 'javascript:void(0);',
                styles: {
                    display: 'block'
                },
                events: {
                    click: function(){
                        self.ipsearchCookie.empty();
                        //Cookie.dispose('ipAdvSearch');
                        this.dissolve();
                        window.location.reload(); // works but it's not elegant
                    }
                }
            }).inject(this.ipClearButton);
        }
    },

    setCookieOptions: function(ipsearchCookie, options){
        if(ipsearchCookie.has('beds_low')) options.sliders.beds.start.initialStep = ipsearchCookie.get('beds_low');
        if(ipsearchCookie.has('beds_high')) options.sliders.beds.end.initialStep = ipsearchCookie.get('beds_high');
        if(ipsearchCookie.has('baths_low')) options.sliders.baths.start.initialStep = ipsearchCookie.get('baths_low');
        if(ipsearchCookie.has('baths_high')) options.sliders.baths.end.initialStep = ipsearchCookie.get('baths_high');
        if(ipsearchCookie.has('price_low')) options.sliders.price.start.initialStep = ipsearchCookie.get('price_low');
        if(ipsearchCookie.has('price_high')) options.sliders.price.end.initialStep = ipsearchCookie.get('price_high');
        if(ipsearchCookie.has('sqft_low')) options.sliders.sqft.start.initialStep = ipsearchCookie.get('sqft_low');
        if(ipsearchCookie.has('sqft_high')) options.sliders.sqft.end.initialStep = ipsearchCookie.get('sqft_high');
        if(ipsearchCookie.has('province')) options.inputs.province.selected = ipsearchCookie.get('province');
        if(ipsearchCookie.has('region')) options.inputs.region.selected = ipsearchCookie.get('region');
        if(ipsearchCookie.has('city')) options.inputs.city.selected = ipsearchCookie.get('city');
        if(ipsearchCookie.has('county')) options.inputs.county.selected = ipsearchCookie.get('county');
        if(ipsearchCookie.has('locstate')) options.inputs.locstate.selected = ipsearchCookie.get('locstate');
        if(ipsearchCookie.has('country')) options.inputs.country.selected = ipsearchCookie.get('country');
        if(ipsearchCookie.has('reo')) options.inputs.reo.selected = true;
        if(ipsearchCookie.has('hoa')) options.inputs.hoa.selected = true;
        if(ipsearchCookie.has('waterfront')) options.inputs.waterfront.selected = true;
        if(ipsearchCookie.has('stype')) options.inputs.stype.selected = ipsearchCookie.get('stype');
        if(ipsearchCookie.has('ptype')){
            ipsearchCookie.get('ptype').split(',').each(function(e){
                options.inputs['cat'+e].selected = true;
            });
        }
        if(ipsearchCookie.search) options.search['search'] = ipsearchCookie.search;

        return options;
    },
        
    buildTools: function(){
        var polyOptions = {
            strokeWeight: 0,
            fillOpacity: 0.45,
            fillColor: '#1E90FF',
            editable: true
        };
        // initialize drawingmanager object
        this.drawingManager = new google.maps.drawing.DrawingManager({
            // drawing controls options
            drawingControlOptions: {
            drawingModes: [
                google.maps.drawing.OverlayType.CIRCLE,
                //google.maps.drawing.OverlayType.POLYGON,
                google.maps.drawing.OverlayType.RECTANGLE
            ]
            },
            rectangleOptions: polyOptions,
            circleOptions: polyOptions,
            //polygonOptions: polyOptions,
            map: this.mapInstance
        }); 
        google.maps.event.addListener(this.drawingManager, 'overlaycomplete', function(e) {           
            if (e.type !== google.maps.drawing.OverlayType.MARKER) {
                // Switch back to non-drawing mode after drawing a shape.
                this.drawingManager.setDrawingMode(null);

                // Add an event listener that selects the newly-drawn shape when the user
                // mouses down on it.
                var newShape = e.overlay;
                newShape.type = e.type;
                google.maps.event.addListener(newShape, 'click', function() {
                    this.setSelection(newShape);
                });
                this.setSelection(newShape);
            }
        }.bind(this));	
        google.maps.event.addListener(this.drawingManager, 'drawingmode_changed', this.clearSelection);
        google.maps.event.addListener(this.mapInstance, 'click', this.clearSelection);		
        google.maps.event.addListener(this.drawingManager, 'overlaycomplete', function(event) {
            switch (event.type) {
            case google.maps.drawing.OverlayType.CIRCLE:
                var radius = event.overlay.getRadius(); // returned in meters!! 
                var opts = { center: event.overlay.getCenter(), radius: radius };
                this.doToolSearch('circle', opts);
                break;
            //case google.maps.drawing.OverlayType.POLYGON:
            //    var path = event.overlay.getPath(); 
            //    this.doToolSearch('polygon', path);
            //    break;
            case google.maps.drawing.OverlayType.RECTANGLE:
                var bounds = event.overlay.getBounds(); 
                this.doToolSearch('rectangle', bounds);
                break;	
            } 
        }.bind(this));
        google.maps.event.addListener(this.drawingManager, 'circlecomplete', function (circle){
            google.maps.event.addListener(circle, 'radius_changed', function () {
                var radius = circle.getRadius(); // returned in meters!! 
                var opts = { center: circle.getCenter(), radius: radius };
                this.doToolSearch('circle', opts);
            }.bind(this));
            google.maps.event.addListener(circle, 'center_changed', function () {
                var radius = circle.getRadius(); // returned in meters!! 
                var opts = { center: circle.getCenter(), radius: radius };
                this.doToolSearch('circle', opts);
            }.bind(this));
        }.bind(this));
        google.maps.event.addListener(this.drawingManager, 'rectanglecomplete', function (rectangle){
            google.maps.event.addListener(rectangle, 'bounds_changed', function () {
                var bounds = rectangle.getBounds(); 
                this.doToolSearch('rectangle', bounds);
            }.bind(this));
        }.bind(this));
        /*
        google.maps.event.addListener(this.drawingManager, 'polygoncomplete', function (polygon){
            google.maps.event.addListener(polygon, 'insert_at', function () {
                var path = polygon.getPath(); 
                this.doToolSearch('polygon', path);
            }.bind(this));
            google.maps.event.addListener(polygon, 'remove_at', function () {
                var path = polygon.getPath(); 
                this.doToolSearch('polygon', path);
            }.bind(this));
            google.maps.event.addListener(polygon, 'set_at', function () {
                var path = polygon.getPath(); 
                this.doToolSearch('polygon', path);
            }.bind(this));
        }.bind(this));
        */
    },
    
    // utility methods
    clearSelection: function() {
        if (this.selectedShape) {
            this.selectedShape.setEditable(false);
            this.selectedShape.setMap(null);
            this.selectedShape = null;
            mapOptions.geopoint = {};
        }
    },

    setSelection: function(shape) {
	    this.clearSelection();
	    this.selectedShape = shape;
	    shape.setEditable(true);
    },
	
    doToolSearch: function(type, options){
        mapOptions.geopoint = {};
        mapOptions.geopoint['type'] = type;
        switch(type){
            case 'circle':
                mapOptions.geopoint['lat'] = options.center.lat();
                mapOptions.geopoint['lon'] = options.center.lng();
                mapOptions.geopoint['rad'] = (options.radius / 1000); // convert meters to km
            break;
            //case 'polygon':
            //    var paths = [];
            //    for (var i = 0; i < options.length; i++){
            //        var point = options.getAt(i);
            //        paths.push({ lat: point.lat(), lon: point.lng() });	
            //    }
            //    mapOptions.geopoint['paths'] = paths;
                //console.dir(paths);
            //break;
            case 'rectangle':
                var SW = options.getSouthWest();
                var NE = options.getNorthEast();
                var SW_array = [ SW.lat(), SW.lng() ];
                var NE_array = [ NE.lat(), NE.lng() ];
                mapOptions.geopoint['sw'] = SW_array;
                mapOptions.geopoint['ne'] = NE_array;
            break;
        }
        this.search();
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

function formatCurrency(num, symbol, position, format) {
    cSeparator = (format == 1) ? ',' : '.';

    num = num.toString().replace(/\$|\,/g,'');
    if(isNaN(num))
        num = "0";
        //sign = (num == (num = Math.abs(num)));
        num = Math.floor(num*100+0.50000000001);
        //cents = num%100;
        num = Math.floor(num/100).toString();
        //if(cents<10)
        //cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++){
        num = num.substring(0,num.length-(4*i+3))+cSeparator+num.substring(num.length-(4*i+3));
    }
    //return (((sign)?'':'-') + '$' + num);
    if(position == 1){
        return num+' '+symbol;
    }else{
        return symbol+num;
    }
}

function addCommas(nStr){    
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
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
