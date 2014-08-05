 var ipSortableDocuments = new Class({

    Implements: [Events, Chain, Options],
    Binds: ['buildImageDivs', 'buildSortable', 'addImage'],

    options: {
        avail:{},
        selected:{},
        iptoken: '',
        propid: '',
        imgPath: '',
        iplimit: 10,
        url: '',
        client: 'administrator'
    },

    initialize: function(options){
        var self = this;
        options.client = (options.client == 'administrator/') ? 'administrator/' : '';
        this.setOptions(options);

        this.alimitstart    = 0; // available limitstart
        this.slimitstart    = 0; // selected limitstart
        this.atotalimgs     = 0; // count of all avail images
        this.stotalimgs     = 0; // count of all selected images

        // build the divs and ULs, as well as pagination divs
        this.buildImageDivs();
        this.buildPaginationDivs(0);
        //this.buildPaginationDivs(1); //not doing pagination for selected

        // build the sortable
        this.buildSortable();

        // grab the images
        this.getImages(0);
        this.getImages(1);

        // refresh pagination
        this.doPagination();

        // build the message effect
        this.ipmessage = new Fx.Reveal(document.getElementById('ip_documents_message'),
            {duration: 1500, transition: Fx.Transitions.Elastic.easeOut, onComplete:function(){
                this.element.dissolve();
        }});
    },

    buildImageDivs: function(){
        if (this.options.debug) console.log('building image divs');
        this.ipAvail    = document.getElementById('ip_gallery_available_doc');
        this.ipSelected = document.getElementById('ip_gallery_selected_doc');

        this.ipAvailUl     = new Element('ul', { id: 'ipAvailUldoc', 'class': 'ipsorter'  });
        this.ipSelectedUl  = new Element('ul', { id: 'ipSelectedUldoc', 'class': 'ipsorter' });

        this.ipAvailUl.inject(this.ipAvail);
        this.ipSelectedUl.inject(this.ipSelected);
    },

    updateImages: function(own){
        if(!own){
            // check if the "no results" table is there and remove
            if (document.id('ipAvailNoResultsDoc')) document.id('ipAvailNoResultsDoc').dissolve();
            if (this.options.debug) console.log('running update images own = false');
            var listElements = this.ipAvailUl.getElements('LI');
            // clean the sortable items so we can re-add them
            if (listElements.length) this.ipSort.removeItems(listElements);
            // create image elements and inject them
            this.ipAvailUl.empty();
            Array.each(this.options.avail, function(obj){
                var im = this.buildAvailForm(obj);
                this.ipAvailUl.adopt(im);
                this.ipSort.addItems(im);
            }, this);
            // refresh the pagination
            this.doPagination(0);
        } else if (own){
            // check if the "no results" table is there and remove
            if (document.id('ipSelectedNoResultsDoc')) document.id('ipSelectedNoResultsDoc').dissolve();
            if (this.options.debug) console.log('running update images own = true');
            var listElements = this.ipSelectedUl.getElements('LI');
            // clean the sortable items so we can re-add them
            if (listElements.length)this.ipSort.removeItems(listElements);
            // create image elements and inject them
            this.ipSelectedUl.empty();
            Array.each(this.options.selected, function(obj){
                var im = this.buildSelectedForm(obj);
                this.ipSelectedUl.adopt(im);
                this.ipSort.addItems(im);
            }, this);
        }
    },

    deleteImage: function(element){
        var self = this;
        var imgId = element.get('id');
        var el = element;
        imgId = imgId.replace('ipImage', '');
        if (this.options.debug) console.log('running image delete id ' + imgId);

        var remoteRequest = new Request.JSON({
                url: this.options.ipbaseurl+'/'+this.options.client+'index.php?option=com_iproperty&'+this.options.iptoken+'=1&format=raw',
                link: 'chain',
                method: 'post',
                data: {
                        task: 'ajax.ajaxDelete',
                        imgid: imgId
                },
                onSuccess: function(response) {
                    if(response == '1'){
                        if (self.options.debug) console.log('deleteImage success: ' + response);
                        self.ipSort.removeItems(el).destroy();
                        self.buildSuccessMessage();
                        self.getImages(1);
                    } else {
                        if (self.options.debug) console.log('deleteImage failure: ' + response);
                        self.buildFailureMessage();
                    }
                }
        }).send();
    },

    addImage: function(element){
        var self = this;
        var imgId = element.get('id');
        var el = element;
        imgId = imgId.replace('ipImage', '');
        if (this.options.debug) console.log('running image add id ' + imgId);

        var remoteRequest = new Request.JSON({
            url: this.options.ipbaseurl+'/'+this.options.client+'index.php?option=com_iproperty&'+this.options.iptoken+'=1&format=raw',
            link: 'chain',
            method: 'post',
            data: {
                    task: 'ajax.ajaxAdd',
                    propid: this.options.propid,
                    imgid: imgId
            },
            onSuccess: function(response) {
                if(response != '0'){
                    // check if the "no results" table is there and remove
                    if (document.id('ipSelectedNoResultsDoc')) document.id('ipSelectedNoResultsDoc').dissolve();
                    if (self.options.debug) console.log('addImage success: New image ID ' + response);
                    self.buildSuccessMessage();
                    if(el.set('id', 'ipImage'+response)){
                        // reset the id for the controls column
                        document.getElementById('controlCol'+imgId).set('id', 'controlCol'+response);
                        if (self.options.debug) console.log('new ElementId: ' + el.get('id'));
                        self.updateForm(el);
                        self.saveOrder();
                        self.updateImages(0);
                    }
                } else {
                    if (self.options.debug) console.log('addImage failure: ' + response);
                    self.buildFailureMessage();
                }
            }
        }).send();
    },

    saveImage: function(){
        this.saveOrder();
    },

    getImages: function(own){
        if (this.options.debug) console.log('running getDocs. Own: ' + own);
        var self = this;
        var limitstart = own ? this.slimitstart : this.alimitstart;
        var tempLimit = own ? 99 : this.options.iplimit; // only set limit on avail list

        //var updater = own ? document.getElementById('ip_gallery_available') : document.getElementById('ip_gallery_selected');
        var imageRequest = new Request.JSON({
            //useSpinner: true,
            //update: updater,
            async: false, // we need to do this or else the pagination won't work
            url: this.options.ipbaseurl+'/'+this.options.client+'index.php?option=com_iproperty&'+this.options.iptoken+'=1&format=raw',
            link: 'chain', // may need to set this to chain
            method: 'post',
            data: {
                'task': 'ajax.ajaxLoadFiles',
                'propid': this.options.propid,
                'own': own,
                'limitstart': limitstart,
                'limit': tempLimit
            },
            onSuccess: function(responseJSON) {
                var images = responseJSON;
                var imcount = images.shift() * 1; // multiply by 1 to type cast as number
                if (!own){
                    self.atotalimgs = imcount;
                } else {
                    self.stotalimgs = imcount;
                }
                if (self.options.debug) console.log('getDocs returned ' + imcount + ' images.');
                if (imcount >= 1 && images[0] != 0){
                    if(own == 1){
                        self.options.selected = images;
                    } else if (own == 0) {
                        self.options.avail = images;
                    }
                    self.updateImages(own);
                } else {
                    if(!own){
                        self.ipAvailUl.adopt(new Element( 'li', {id: 'ipAvailNoResultsDoc', 'class': 'noresults', html: '<table><tr><td colspan=2>'+self.options.language.noresults+'</td></tr></table>'} ));
                    } else {
                        self.ipSelectedUl.adopt(new Element( 'li', {id: 'ipSelectedNoResultsDoc', 'class': 'noresults', html: '<table><tr><td colspan=2>'+self.options.language.noresults+'</td></tr></table>'} ));
                    }
                }
            }
        }).send();
    },

    saveOrder: function(){
        var self = this;
        if (this.options.debug) console.log('running saveOrder');
        var order = this.ipSort.serialize(1);
        var sortOrder = [];
        Array.each(order, function(position, index) {
            if (position != null){ // have to do this due to weird null being introduced by sortable
                var ipRow = [];
                // get ID and add to the array
                ipRow.push(position);

                // grab the title/description
                var row = document.id(position);
                if(row){
                    row.getElements('input').each(function(input){
                        ipRow.push(input.value);
                    });
                    sortOrder.push(ipRow);
                }
            }
        });
        // json encode array and call reorder function
        sortOrder = JSON.encode(sortOrder);

        var remoteRequest = new Request.JSON({
            url: this.options.ipbaseurl+'/'+this.options.client+'index.php?option=com_iproperty&'+this.options.iptoken+'=1&format=raw',
            link: 'chain',
            method: 'post',
            data: {
                    task: 'ajax.ajaxSort',
                    data: sortOrder
            },
            onSuccess: function(response) {
                if(response == '1'){
                    if (self.options.debug) console.log('saveOrder success: ' + response);
                    self.buildSuccessMessage();
                } else {
                    if (self.options.debug) console.log('saveOrder failure: ' + response);
                    self.buildFailureMessage();
                }
            }
        }).send();
    },

    buildAvailForm: function(obj){
        var icon;

        switch (obj.type){
            case '.pdf':
                icon = 'pdf.png';
                break;
            case '.doc':
                icon = 'doc.png';
                break;
            case '.odt':
                icon = 'odt.png';
                break;
            default:
                icon = 'rtf.png';
                break;
        }

        //begin the li container for each sortable object
        var li          = new Element ('li', {id: 'ipImage'+obj.id, 'class': 'ipAvailRowClass'});
        var table       = new Element ('table', {'class': 'imgtable'});

        var img         = this.buildImg(this.options.ipbaseurl+'/media/media/images/mime-icon-32/'+icon, 'ipdoc-image current', '', obj.fname);
        var fname       = this.buildLink(this.options.ipbaseurl+obj.path+obj.fname+obj.type, obj.fname+obj.type, 'modal', '');
        var imgtitle    = new Element('div', {'class': 'availtitle', id: 'imgFname'});

        var leftCol     = new Element('td', {'class': 'width-10'});
        var rightCol    = new Element('td', {'class': 'width-90', id: 'controlCol'+obj.id});

        img.inject(leftCol);
        imgtitle.inject(rightCol);
        fname.inject(imgtitle);
        leftCol.inject(table);
        rightCol.inject(table);
        table.inject(li);

        return li;
    },

    buildSelectedForm: function(obj){
        var self = this;
        var icon;

        switch (obj.type){
            case '.pdf':
                icon = 'pdf.png';
                break;
            case '.doc':
                icon = 'doc.png';
                break;
            case '.odt':
                icon = 'odt.png';
                break;
            default:
                icon = 'rtf.png';
                break;
        }

        //begin the li container for each sortable object
        var li          = new Element ('li', {id: 'ipImage'+obj.id, 'class': 'ipSelectedRowClass'});
        var table       = new Element ('table', {'class': 'imgtable'});
        var controls    = new Element ('div', {id: 'ipImgControls'});

        var img         = this.buildImg(this.options.ipbaseurl+'/media/media/images/mime-icon-32/'+icon, 'ipdoc-image current', '', obj.fname);
        var fname       = this.buildLink(this.options.ipbaseurl+obj.path+obj.fname+obj.type, obj.fname+obj.type, 'modal', '');
        var del         = this.buildLink('javascript:void(0);', this.options.language.del, 'ipDelete', 'ipImgDelete'+obj.id);
        var save        = this.buildLink('javascript:void(0);', this.options.language.save, 'ipSave', 'ipImgSave'+obj.id);
        var up          = this.buildLink('javascript:void(0);', '&nbsp;', 'ipUpimg', 'ipImgUp'+obj.id);
        var down        = this.buildLink('javascript:void(0);', '&nbsp;', 'ipDownimg', 'ipImgDown'+obj.id);
        var form        = this.buildFormDiv('ipImgForm', obj.id, obj.title, obj.description);

        del.addEvent('click', function(el){
            self.deleteImage(document.getElementById('ipImage'+obj.id));
        });

        save.addEvent('click', function(el){
            self.saveImage(document.getElementById('ipImage'+obj.id));
        });

        up.addEvent('click', function(el){
            self.moveUp(li.id);
        });

        down.addEvent('click', function(el){
            self.moveDown(li.id);
        });

        var leftCol     = new Element('td', {'class': 'width-10'});
        var rightCol    = new Element('td', {'class': 'width-90'});
        var fnameContainer = new Element('div');

        //bind the form and delete/save links to the controls div
        fname.inject(fnameContainer);
        form.inject(controls);
        del.inject(controls);
        save.inject(controls);
        up.inject(controls);
        down.inject(controls);

        img.inject(leftCol);
        fnameContainer.inject(rightCol);
        controls.inject(rightCol);
        leftCol.inject(table);
        rightCol.inject(table);
        table.inject(li);

        return li;
    },

    updateForm: function(el){
        if (this.options.debug) console.log('doing updateForm action');
        if (el.hasClass('ipAvailRowClass')) {
            var self    = this;
            var imgId   = el.get('id');

            imgId = imgId.replace('ipImage', '');
            // we moved a picture from the avail pile into the selected list
            el.removeClass('ipAvailRowClass');
            el.addClass('ipSelectedRowClass');
            //el.getElementById('imgFname').destroy();
            // add form
            var controls    = new Element ('div', {id: 'ipImgControls'});
            var fname       = el.imgFname.get('html');
            var del         = this.buildLink('javascript:void(0);', this.options.language.del, 'ipDelete', 'ipImgDelete'+imgId);
            var save        = this.buildLink('javascript:void(0);', this.options.language.save, 'ipSave', 'ipImgSave'+imgId);
            var up          = this.buildLink('javascript:void(0);', '&nbsp;', 'ipUpimg', 'ipImgUp'+imgId);
            var down        = this.buildLink('javascript:void(0);', '&nbsp;', 'ipDownimg', 'ipImgDown'+imgId);
            var form        = this.buildFormDiv('ipImgForm', imgId, '', '');

            del.addEvent('click', function(el){
                self.deleteImage(document.getElementById('ipImage'+imgId));
            });

            save.addEvent('click', function(el){
                self.saveImage(document.getElementById('ipImage'+imgId));
            });

            up.addEvent('click', function(el){
                self.moveUp('ipImage'+imgId);
            });

            down.addEvent('click', function(el){
                self.moveDown('ipImage'+imgId);
            });

            form.inject(controls);
            //fname.inject(controls);
            del.inject(controls);
            save.inject(controls);
            up.inject(controls);
            down.inject(controls);
            controls.inject(document.id('controlCol'+imgId));
        }
    },

    buildSortable: function(){
        var self = this;
        this.ipSort = new Sortables('#ip_gallery_available_doc UL, #ip_gallery_selected_doc UL', {
          clone: true,
          revert: true,
          opacity: 0.7,
          onComplete: function(el,clone) {
            if (el.getParent('ul').get('id') == 'ipAvailUldoc'){
                if (el.hasClass('ipSelectedRowClass')) {
                    // we moved a picture from the selected into the avail pile
                    self.deleteImage(el);
                }
            } else if (el.getParent('ul').get('id') == 'ipSelectedUldoc') {
                if (el.hasClass('ipAvailRowClass')) {
                    // we moved a picture from the avail pile into the selected list
                    self.addImage(el);
                }
            } // else it was a simple reorder within the same list
            // now do the reorder function, regardless of whether or not we just added a photo or simply moved one
            self.saveOrder();
          }
        });
    },

    doPagination: function(selected){
        var self = this;
        // set vars
        var own = false;
        var limit = this.options.iplimit;
        var el, ipcount, limitstart, suffix, prev, next, paginationDiv;
        if (selected){
            paginationDiv = document.id('ip_gallery_sel_pagination_doc');
            own = true;
            limitstart = this.slimitstart;
            ipcount = this.stotalimgs;
            suffix = '_sel';
        } else {;
            paginationDiv = document.id('ip_gallery_av_pagination_doc');
            limitstart = this.alimitstart;
            ipcount = this.atotalimgs;
            suffix = '_av';
        }
        // assign proper button
        prev = document.id('docipPrevButton'+suffix);
        next = document.id('docipNextButton'+suffix);

        // hide pagination div til we know if it's needed
        paginationDiv.hide();
        if (limitstart >= limit){
            paginationDiv.show();
            // remove any existing click event
            prev.removeEvents('click');
            // only add prev action if we're not at the beginning of the set
            prev.addEvent('click', function(){
                if (self.options.debug == true) console.log('fired prev pagination event');
                if (own){
                    self.slimitstart = limitstart - limit;
                } else {
                    self.alimitstart = limitstart - limit;
                }
                self.getImages(own);
            });
        }

        if (limitstart <= (ipcount - limit)){
            paginationDiv.show();
            // remove any existing click event
            next.removeEvents('click');
            // only add the next action if we're not within 'limit' of the total
            next.addEvent('click', function(){
                if (self.options.debug == true) console.log('fired next pagination event');
                if (own){
                    self.slimitstart = limitstart + limit;
                } else {
                    self.alimitstart = limitstart + limit;
                }
                self.getImages(own);
            });
        }
        var tempCount = (ipcount <= limitstart+this.options.iplimit) ? ipcount : limitstart+this.options.iplimit;
        // write the numbers into the proper area
        document.id('docpagination_limitstart'+suffix).set('html', limitstart);
        document.id('docpagination_totalcounttemp'+suffix).set('html', tempCount);
        document.id('docpagination_totalcount'+suffix).set('html', ipcount);
    },

    buildImg: function(path, cssclass, alt, title){
        var img = new Element ('img', {
            'src': path,
            'class': cssclass,
            'alt': alt,
            'title': title
        });
        return img;
    },

    buildLink: function(href, txt, cssclass, linkid){
        var link = new Element ('a', {
            href: href,
            html: txt,
            'class': cssclass,
            id: linkid
        });
        return link;
    },

    buildFormDiv: function(formid, objid, objtitle, objdesc){
        var form = new Element ('div', {
            id: 'ipImgForm',
            html: '<label for="'+objid+'_title">'+this.options.language.iptitletext+'</label>\n\
                    <input id="'+objid+'_title" class="inputbox" type="text" value="'+objtitle+'" /><br />\n\
                   <label for="'+objid+'_description">'+this.options.language.ipdesctext+'</label>\n\
                    <input id="'+objid+'_desc" class="inputbox" type="text" value="'+objdesc+'" />'
        });
        return form;
    },

    buildSuccessMessage: function(){
        if (this.options.debug) console.log('doing success message');
        document.getElementById('ip_documents_message').set('html','<div class="ip_message">'+this.options.language.updated+'</div>');
        this.ipmessage.reveal();
    },

    buildFailureMessage: function(){
        if (this.options.debug) console.log('doing failure message');
        document.getElementById('ip_documents_message').set('html','<div class="ip_message">'+this.options.language.notupdated+'</div>');
        this.ipmessage.reveal();
    },

    moveUp: function(id) {
        var prev = document.getElementById(id).getPrevious();
        if (prev){
            document.getElementById(id).inject(prev, 'before');
            this.saveOrder();
        }
    },

    moveDown: function(id) {
        var next = document.getElementById(id).getNext();
        if (next){
            document.getElementById(id).inject(next, 'after');
            this.saveOrder();
        }
    },

    buildPaginationDivs: function(own){
        var paginationDiv;
        var suffix = own ? '_sel' : '_av';

        if (own){
            paginationDiv = document.id('ip_gallery_sel_pagination_doc');
        } else {
            paginationDiv = document.id('ip_gallery_av_pagination_doc');
        }

        // build prev/next buttons
        var prev = new Element('a', {
            //href: 'javascript:void(0);',
            id: 'docipPrevButton'+suffix,
            html: this.options.language.previous,
            'class': 'ippagination disabled'
        });
        var next = new Element('a', {
            //href: 'javascript:void(0);',
            id: 'docipNextButton'+suffix,
            html: this.options.language.next,
            'class': 'ippagination disabled'
        });

        paginationDiv.set('html', ' (<span id="docpagination_limitstart'+suffix+'"></span> - <span id="docpagination_totalcounttemp'+suffix+'"></span> '+this.options.language.of+' <span id="docpagination_totalcount'+suffix+'"></span>) ');
        paginationDiv.hide();
        prev.inject(paginationDiv, 'top');
        next.inject(paginationDiv, 'bottom');
    }
});
