var bookWidth = 600;
var bookHeight = 400;
var bookMinWidth = 200;
var bookScale = 1.2;
var topMenuWidth = 242;

var browserName = "";
var browserPrefix = "";
var isIE = false;
var versionIE = 9;
var fullLink;

function getDocumentSize(doc) { // getting a real size document with scrolling etc.
    var r = { width: 0, height: 0 };

    var width1 = 0, width2 = 0, width3 = 0, width4 = 0, maxWidth = 0;
    var height1 = 0, height2 = 0, height3 = 0, height4 = 0, maxHeight = 0;


    if (doc.width) maxWidth = doc.width;
    if (doc.body) {
        if (doc.body.scrollWidth) width1 = doc.body.scrollWidth;
        if (doc.body.offsetWidth) width2 = doc.body.offsetWidth;
    }
    if (doc.documentElement) {
        width3 = doc.documentElement.scrollWidth;
        width4 = doc.documentElement.clientWidth;
    }

    maxWidth = Math.max(Math.max(Math.max(width1, width2), Math.max(width3, width4)), maxWidth);

    if (doc.height) maxHeight = doc.height;
    if (doc.body) {
        if (doc.body.scrollHeight) height1 = doc.body.scrollHeight;
        if (doc.body.offsetHeight) height2 = doc.body.offsetHeight;
    }
    if (doc.documentElement) {
        height3 = doc.documentElement.scrollHeight;
        height4 = doc.documentElement.clientHeight;
    }
    maxHeight = Math.max(Math.max(Math.max(height1, height2), Math.max(height3, height4)), maxHeight);

    r.width = maxWidth;
    r.height = maxHeight;

    return r;
}

var noFlashNotification = function (imgUrl, spreadUrl) {

    var noteWindow = {

        draw: function (imgUrl) {

            if (!document.getElementById('NOTE')) {
                var div = document.createElement("DIV");
                div.id = "NOTE";
                document.getElementsByTagName("body")[0].appendChild(div);



                div.style.position = "absolute";
                div.style.top = "0px";
                div.style.left = "0px";
                if (isIE && 1 * versionIE < 9) {
                    div.style.filter = "progid:DXImageTransform.Microsoft.Alpha(opacity=50)";
                } else {
                    div.style.backgroundColor = "rgba(0,0,0,0.5)";
                }
                div.style.width = window.innerWidth + 'px'; //"100%";
                div.style.height = window.innerHeight + 'px'; //"100%";

                var title = (browserName == 'firefox') ? document.getElementsByTagName('title')[0].textContent.substr(document.getElementsByTagName('title')[0].textContent.indexOf('-') + 1) : document.getElementsByTagName('title')[0].innerText.substr(document.getElementsByTagName('title')[0].innerText.indexOf('-') + 1);

                var divWidth = (window.innerWidth < 600) ? "90%" : "600px";
                var margTop = (window.innerHeight / 2 > 200) ? window.innerHeight / 2 - 200 : window.innerHeight / 2;

                div.innerHTML = '<div id="flash-notification" class="flash-notification" style="width:' + divWidth + '; margin: ' + margTop + 'px auto; padding: 12px; overflow: hidden; background-color: rgb(255, 255, 255); border: 1px solid rgb(200, 200, 200); border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; font-style: normal; font-variant: normal; font-weight: normal; font-size: 11px; line-height: 14px; font-family: Arial; position: relative; background-position: initial initial; background-repeat: initial initial; -webkit-box-shadow: 0px 3px 10px rgba(0,0,0,.8);-moz-box-shadow: 0px 3px 10px rgba(0,0,0,.8); box-shadow: 0px 3px 10px rgba(0,0,0,.8);"><a id="closeButton" href="javascript:void(0);" style="display:block;width:8px;height:8px;text-decoration:none;font:0/0 a;cursor:pointer;background:url(http://d2b44id80uvcdw.cloudfront.net/site/close.png);position:absolute;top:12px;right:12px;left:auto;bottom:auto;"></a><img id="noteImage"  style="display:block;float:left;text-decoration:none;margin:10px 20px 10px 10px; -webkit-box-shadow: 0px 3px 10px rgba(0,0,0,.5);-moz-box-shadow: 0px 3px 10px rgba(0,0,0,.5); box-shadow: 0px 3px 10px rgba(0,0,0,.5);" src="' + imgUrl + '"><div style="font-weight:bold;padding-top:14px;padding-bottom:10px; font-size:14px;">' + title + '</div><div>To maximize your viewing experience of this digital publication, we recommend installing Adobe Flash Player Plugin. This installation will only take a few moments. Should you experience any issues with installation, please contact your System Administrator.</div><a href="http://get.adobe.com/flashplayer/" style="display:block;text-decoration:none;margin:15px 10px 0 10px;" target="_blank"><img src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" alt="" border="0" style="border:0;display:block;" width="160" height="41"></a></div>';

                if (document.getElementById('closeButton')) {
                    noteWindow.setCloseEvent();
                } else {
                    setTimeout(noteWindow.setCloseEvent, 300);
                }

                if (spreadUrl != "") {
                    setTimeout(noteWindow.replaceAnimatedImg, 700);
                }
            }


        },

        replaceAnimatedImg: function () {
            var div = document.getElementById('noteImage');
            var title = (browserName == 'firefox') ? document.getElementsByTagName('title')[0].textContent.substr(document.getElementsByTagName('title')[0].textContent.indexOf('-') + 1) : document.getElementsByTagName('title')[0].innerText.substr(document.getElementsByTagName('title')[0].innerText.indexOf('-') + 1);

            div.parentNode.innerHTML = '<a id="closeButton" href="javascript:void(0);" style="display:block;width:8px;height:8px;text-decoration:none;font:0/0 a;cursor:pointer;background:url(http://d2b44id80uvcdw.cloudfront.net/site/close.png);position:absolute;top:12px;right:12px;left:auto;bottom:auto;"></a><iframe id="sprateIframe" style="display:block;float:left;text-decoration:none;margin:10px 20px 10px 10px; -webkit-box-shadow: 0px 3px 10px rgba(0,0,0,.5);-moz-box-shadow: 0px 3px 10px rgba(0,0,0,.5); box-shadow: 0px 3px 10px rgba(0,0,0,.5);" frameborder="0"  width="' + div.width + 'px" height="' + div.height + 'px"  title=' + title + ' src="' + spreadUrl + '" type="text/html" scrolling="no" marginwidth="0" marginheight="0"></iframe><div style="font-weight:bold;padding-top:14px;padding-bottom:10px; font-size:14px;">' + title + '</div><div>To maximize your viewing experience of this digital publication, we recommend installing Adobe Flash Player Plugin. This installation will only take a few moments. Should you experience any issues with installation, please contact your System Administrator.</div><a href="http://get.adobe.com/flashplayer/" style="display:block;text-decoration:none;margin:15px 10px 0 10px;" target="_blank"><img src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" alt="" border="0" style="border:0;display:block;" width="160" height="41"></a>';

            if (document.getElementById('closeButton')) {
                noteWindow.setCloseEvent();
            } else {
                setTimeout(noteWindow.setCloseEvent, 300);
            }

            /*
            alink = function(){
            var iframe = document.getElementById('sprateIframe');
            if (iframe && (document.domain.indexOf('publ.com') != -1)){
            var innerDoc = iframe.contentDocument || iframe.contentWindow.document;
            if(innerDoc.getElementById('publicationLink')){
            var id = spreadUrl.split('?')[0].split('/');
            id = id[id.length-1]
            src = window.location.host + '/Session/DetectBrowser?returnTo='+ spreadUrl.split('?')[0]+'&type=Flash'
            }
            }
            }
				
            setTimeout(alink,300);
            */
            div = null;

        },

        setCloseEvent: function () {
            if (isIE && versionIE < 9) {
                document.getElementById('closeButton').attachEvent("onclick", noteWindow.close);
            } else {
                document.getElementById('closeButton').addEventListener("click", noteWindow.close, false);
            }

        },

        close: function () {
            document.getElementById("NOTE").parentNode.removeChild(document.getElementById("NOTE"));
        }


    };
    noteWindow.draw(imgUrl);

}

var eventLock = function (event) {

    event.preventDefault ? event.preventDefault() : event.returnValue = false;
    event.stopPropagation ? event.stopPropagation() : event.returnValue = false;

    event = event || window.event; // get window.event if argument is falsy (in IE) 
    var targetElement = event.target || event.srcElement; // get srcElement if target is falsy (IE)
    var href = (targetElement.href) ? targetElement.href : targetElement.parentNode.href;

    if (href.split('/')[href.split('/').length - 1].split('.')[1] == 'png') {
        href = targetElement.parentNode.href;
    }
    href = href.split('/')[href.split('/').length - 1].split('.')[0];


    loadPage(href);

    return false;
}

var linkLock = function (event) {
    event = event || window.event; // get window.event if argument is falsy (in IE) 
    var targetElement = event.target || event.srcElement; // get srcElement if target is falsy (IE)
    var href = (targetElement.href) ? targetElement.href : targetElement.parentNode.href;


    if (href.split('/')[href.split('/').length - 2] == "basic-html") {
        event.preventDefault ? event.preventDefault() : event.returnValue = false;
        event.stopPropagation ? event.stopPropagation() : event.returnValue = false;




        href = href.split('/')[href.split('/').length - 1].split('.')[0];
        loadPage(href);
    }


    return false;
}

var navigationCorrect = function (event) {

    if (document.getElementById("NOTE")) {
        document.getElementById("NOTE").style.width = window.innerWidth + "px"; //"100%";
        document.getElementById("NOTE").style.height = window.innerHeight + "px"; //"100%";
        document.getElementById("NOTE").childNodes[0].style.margin = (window.innerHeight / 2 - 100) + 'px auto';
    }

    var smallWindow = (document.getElementById("Book").offsetLeft < 20) ? true : false;

    if (document.getElementById("rightTool")) {
        document.getElementById("rightTool").style.position = "fixed";
        document.getElementById("rightTool").style.left = smallWindow ? bookWidth - 52 + "px" : document.getElementById("Book").offsetLeft + bookWidth + 20 + "px";
        document.getElementById("rightTool").style.top = (bookHeight > getClientHeight()) ? getClientHeight() / 2 - 50 + "px" : bookHeight / 2 - 50 + document.getElementById("Page").offsetTop + "px";
        document.getElementById("rightTool").style.width = (document.getElementById("rightTool").getElementsByTagName("A")[1].scrollWidth > 52) ? document.getElementById("rightTool").getElementsByTagName("A")[1].scrollWidth + "px" : 52 + "px";

    }
    if (document.getElementById("leftTool")) {
        document.getElementById("leftTool").style.position = "fixed";
        document.getElementById("leftTool").style.left = smallWindow ? "0px" : (document.getElementById("leftTool").getElementsByTagName("A")[1].scrollWidth > 52) ? document.getElementById("Book").offsetLeft - document.getElementById("leftTool").getElementsByTagName("A")[1].scrollWidth + "px" : document.getElementById("Book").offsetLeft - 52 + "px";
        document.getElementById("leftTool").style.top = (bookHeight > getClientHeight()) ? getClientHeight() / 2 - 50 + "px" : bookHeight / 2 - 50 + document.getElementById("Page").offsetTop + "px";
        document.getElementById("leftTool").style.width = (document.getElementById("leftTool").getElementsByTagName("A")[1].scrollWidth > 52) ? document.getElementById("leftTool").getElementsByTagName("A")[1].scrollWidth + "px" : 52 + "px";
    }
    setBG();


}

var pageInit = function () {

    browserVer();
    paramSet();
    INNER = {};

    // window.location.hash



    if (isIE && versionIE < 9) {
        window.attachEvent("onhashchange", hashChangeLoadPage);
    } else {
        window.addEventListener("hashchange", hashChangeLoadPage, false);
    }

    if (isIE && versionIE < 9) {
        window.attachEvent("onresize", navigationCorrect);
    } else {
        window.addEventListener("resize", navigationCorrect, false);
    }


    //INFO!
    hashChangeLoadPage();

    if (!(isIE && versionIE == 7)) {

        var tocLock = function (event) {

            event.preventDefault ? event.preventDefault() : event.returnValue = false;
            event.stopPropagation ? event.stopPropagation() : event.returnValue = false;

            event = event || window.event; // get window.event if argument is falsy (in IE) 
            var targetElement = event.target || event.srcElement; // get srcElement if target is falsy (IE)


            var href = (targetElement.href) ? targetElement.href : targetElement.parentNode.href;
            href = 'toc';

            loadPage(href);

            return false;
        }

        var tool = (document.getElementById("boxMenu")) ? document.getElementById("boxMenu").getElementsByTagName("A")[0] : [];
        if (isIE && versionIE < 9) {

            tool.attachEvent("onclick", tocLock);
        } else {
            tool.addEventListener("click", tocLock, false);
        }

        var tool = (document.getElementById("rightTool")) ? document.getElementById("rightTool").getElementsByTagName("A") : [];
        for (var i = 0; i < tool.length; i++) {
            if (isIE && versionIE < 9) {
                tool[i].attachEvent("onclick", eventLock);
            } else {
                tool[i].addEventListener("click", eventLock, false);
            }
        }
        tool = (document.getElementById("leftTool")) ? document.getElementById("leftTool").getElementsByTagName("A") : [];
        for (var i = 0; i < tool.length; i++) {
            if (isIE && versionIE < 9) {
                tool[i].attachEvent("onclick", eventLock, false);
            } else {
                tool[i].addEventListener("click", eventLock, false);
            }
        }
    }



}

var checkBookSize = function (W, minW) {

    if (W < minW) {
        bookScale = minW / W;

    } else if (W * 1.2 > getClientWidth() - 300) {
        if (minW > getClientWidth() - 300) {
            bookScale = minW / (W * 1.2);
        } else {
            bookScale = (getClientWidth() - 300) / (W * 1.2);
        }
    } else {
        bookScale = 1.2;
    }
    return bookScale;

}

var currentPage = function () {

    // CLEAR CONTENT
    document.getElementById("Content").parentNode.removeChild(document.getElementById("Content"));
    var newDiv = document.createElement('div');
    newDiv.className = 'page';
    newDiv.id = 'Content';
    document.getElementById("Page").insertBefore(newDiv, document.getElementById("Page").firstChild)


    // LOAD CONTENT
    //INNER = {};
    //INNER = eval('(' + this.responseText + ')');


    // SET PARAMS
    document.title = INNER.title;
    document.getElementsByTagName("h1")[0].textContent = INNER.title;

    var meta = document.getElementsByTagName("meta");
    for (var i = 0; i < meta.length; i++) {
        if (meta[i].name == "keywords") meta[i].content = INNER.keywords;
        if (meta[i].name == "description") meta[i].content = INNER.title;
    }


    checkBookSize(INNER.width, bookMinWidth);

    document.getElementById("Book").style.width = INNER.width * bookScale + "px";
    document.getElementById("Page").style.height = INNER.height * bookScale + "px";


    if ((bookWidth != INNER.width * bookScale) | (bookHeight != INNER.height * bookScale)) {
        bookWidth = INNER.width * bookScale;
        bookHeight = INNER.height * bookScale;
    }



    if (INNER.fullLink) {

        fullLink = (INNER.fullLink.split('#')[1]) ? INNER.fullLink.split('#')[1] : '/1';
        //console.log(fullLink)
        if (document.getElementById('fullVersionLink')) {
            document.getElementById('fullVersionLink').href = document.getElementById('fullVersionLink').href.split('#')[0] + '#' + fullLink;
        }
    }




    //if(document.getElementById("NOTE")) document.getElementById("NOTE").style.height = document.body.scrollHeight + "px";



    if (INNER.substrate) {
        if (INNER.substrate.background) document.getElementById("Content").style.background = INNER.substrate.background;
        if (INNER.substrate.backgroundColor) document.getElementById("Content").style.backgroundColor = INNER.substrate.backgroundColor;
        if (INNER.substrate.backgroundSize) document.getElementById("Content").style.backgroundSize = INNER.substrate.backgroundSize;
        document.getElementById("Content").style.backgroundPosition = "center";
        document.getElementById("Content").style.backgroundRepeat = "no-repeat";
    }



    if (INNER.rightTool) {
        document.getElementById("rightTool").style.display = 'block';
        document.getElementById("rightTool").getElementsByTagName("A")[0].href = INNER.rightTool.src;
        document.getElementById("rightTool").getElementsByTagName("A")[1].href = INNER.rightTool.src;
        document.getElementById("rightTool").getElementsByTagName("A")[1].innerHTML = INNER.rightTool.innerText;
    } else {
        document.getElementById("rightTool").style.display = 'none';
    }
    if (INNER.leftTool) {
        document.getElementById("leftTool").style.display = 'block';
        document.getElementById("leftTool").getElementsByTagName("A")[0].href = INNER.leftTool.src;
        document.getElementById("leftTool").style.width = document.getElementById("leftTool").getElementsByTagName("A")[1].scrollWidth + 'px';
        document.getElementById("leftTool").getElementsByTagName("A")[1].href = INNER.leftTool.src;
        document.getElementById("leftTool").getElementsByTagName("A")[1].innerHTML = INNER.leftTool.innerText;
    } else {
        document.getElementById("leftTool").style.display = 'none';
    }
    navigationCorrect();

    // SET CONTENT
    var pageElem = document.getElementById("Content");
    var i = 1;


    if (INNER.content[0].tag) {
        tocCreate(INNER.content, pageElem);



    } else {
        while (INNER.content[i]) {
            pageCreateDiv(INNER.content[i], pageElem);
            i++;
        }
    }
    setSubstrate();
    setBG();



    function tocCreate(elem, parent) {
        // HEADER
        var newDiv = document.createElement(elem[0].tag);
        if (elem[0].text) newDiv.innerHTML = elem[0].text;
        if (elem[0].id) newDiv.id = elem[0].id;
        parent.appendChild(newDiv);
        newDiv.appendChild(document.createElement("br"));
        newDiv.appendChild(document.createElement("hr"));
        delete newDiv;


        //LIST
        function tocCreateElem(el, par) {





            var newElem = document.createElement(el.tag);
            if (el.className) newElem.className = el.className;
            par.appendChild(newElem);



            if (el.tag == 'a') {


                if (el.text) newElem.innerHTML = el.text;
                if (el.href) newElem.href = el.href;
                if (isIE && versionIE < 9) {
                    newElem.attachEvent("onclick", eventLock);
                } else {
                    newElem.addEventListener("click", eventLock, false);
                }

            }

            //


            if (el.content) {
                if (el.content[0]) {
                    var j = 0;
                    while (el.content[j]) {
                        tocCreateElem(el.content[j], newElem);
                        j++;
                    }
                } else {
                    if (el.content.tag == 'ul') {
                        tocCreateUl(el.content, newElem);
                    } else {
                        tocCreateElem(el.content, newElem);
                    }
                }
            }












            delete newElem;
        }

        function tocCreateUl(el, par) {
            var newUl = document.createElement(el.tag);
            if (el.text) newUl.textContent = el.text;
            if (el.id) newUl.id = el.id;
            if (el.className) newUl.className = el.className;
            par.appendChild(newUl);
            var j = 1;
            while (el.content[j]) {
                tocCreateElem(el.content[j], newUl);
                j++;
            }
            delete newUl;
        }



        if (elem[1]) {

            tocCreateUl(elem[1], parent);
        }

        checkLongString();

        var th = document.getElementById("TocList").offsetHeight + document.getElementById("TocHeader").offsetHeight;
        var hh = document.getElementById("PageHeader").offsetHeight + document.getElementById("PageMenu").offsetHeight;

        var bodyHeight = document.getElementsByTagName('body')[0].offsetHeight;

        if (hh + th > bodyHeight) {
            document.getElementById("Page").style.height = th + 30 + 'px';
        } else if ((bookHeight > bodyHeight)) {
            if (th > bodyHeight) {
                document.getElementById("Page").style.height = th + 30 + 'px';
            } else {
                document.getElementById("Page").style.height = bodyHeight - hh + 'px';
            }
        }

    }

    function pageCreateDiv(elem, parent) {
        var newDiv = document.createElement('div');
        if (elem.className) {
            newDiv.className = elem.className;
            if (elem.top) newDiv.style.top = elem.top * bookScale + "px";
            if (elem.left) newDiv.style.left = elem.left * bookScale + "px";
            if (elem.right) newDiv.style.right = elem.right * bookScale + "px";
            if (elem.width) newDiv.style.width = elem.width * bookScale + "px";
            if (elem.height) newDiv.style.height = elem.height * bookScale + "px";
            parent.appendChild(newDiv);

            if (elem.content) {
                if (elem.content[0]) {
                    var j = 0;
                    while (elem.content[j]) {
                        pageCreateElement(elem.content[j], newDiv);
                        j++;
                    }
                } else {
                    pageCreateElement(elem.content, newDiv);
                }
            }

            if (elem.TransformOrigin) newDiv.style[browserPrefix + 'TransformOrigin'] = elem.TransformOrigin;
            if (elem.Transform) {
                // 
                if (isIE && versionIE <= 9) {
                    var angle = elem.Transform.substr(7, elem.Transform.length - 11);
                    rotateContentAngle(newDiv, angle);
                }
                newDiv.style[browserPrefix + 'Transform'] = elem.Transform;
            }




        }
        delete newDiv;
    }

    function pageCreateElement(elem, parent) {
        if (elem.tag) {
            var newElem = document.createElement(elem.tag);

            if (elem.className) newElem.className = elem.className;
            if (elem.top) newElem.style.top = elem.top * bookScale + "px";
            if (elem.left) newElem.style.left = elem.left * bookScale + "px";
            if (elem.right) newElem.style.right = elem.right * bookScale + "px";
            if (elem.width) newElem.style.width = elem.width * bookScale + "px";
            if (elem.height) newElem.style.height = elem.height * bookScale + "px";
            if (elem.text) {
                if (browserName == 'firefox') newElem.innerHTML = elem.text;
                else newElem.innerText = elem.text;
            }
            if (elem.fontWeight) newElem.style.fontWeight = elem.fontWeight;
            if (elem.fontStyle) newElem.style.fontStyle = elem.fontStyle;
            if (elem.src) newElem.style.src = elem.src;
            if (elem.zIndex) newElem.style.zIndex = elem.zIndex;
            if (elem.backgroundColor) newElem.style.backgroundColor = elem.backgroundColor;
            parent.appendChild(newElem);

            if (elem.tag == "a") {
                newElem.setAttribute('href', (elem.href) ? elem.href : "");
                if (isIE && versionIE < 9) {
                    newElem.attachEvent("onclick", linkLock);
                } else {
                    newElem.addEventListener("click", linkLock, false);
                }
            }

            if (elem.tag == "img") {
                newElem.setAttribute('alt', (elem.alt) ? elem.alt : "");
                newElem.setAttribute('src', (elem.src) ? elem.src : "");
            }

            if (elem.tag == "iframe") {
                if (elem.type == "YouTube") {
                    newElem.setAttribute('src', 'http://www.youtube.com/embed/' + elem.id);
                    newElem.setAttribute('frameborder', '0');
                }
                if (elem.type == "Vimeo") {
                    newElem.setAttribute('src', 'http://player.vimeo.com/video/' + elem.id);
                    newElem.setAttribute('frameborder', '0');
                }
            }

            if (elem.tag == "span") {
                //
                if (elem.content) {
                    pageCreateElement(elem.content, newElem);
                }

                var font = newElem;
                var computedStyle = font.currentStyle || window.getComputedStyle(font, null);
                if (font.style.fontSize) {
                    scale = (Math.abs(font.style.fontSize.replace("px", "")) * bookScale);
                } else {
                    scale = (Math.abs(computedStyle.fontSize.replace("px", "")) * bookScale);
                }
                font.style.fontSize = scale + "px";

                if (font.offsetWidth > parent.offsetWidth) {

                    while ((font.offsetWidth > parent.offsetWidth) && (scale > 1)) {
                        scale = scale - 1;
                        font.style.fontSize = scale + "px";
                    }
                } else if (font.offsetWidth < parent.offsetWidth) {
                    var tt = 0;
                    while ((font.offsetWidth < parent.offsetWidth) && (tt < 5)) {
                        scale = scale + 1;
                        tt++;
                        font.style.fontSize = scale + "px";
                    }

                    if (font.offsetWidth > parent.offsetWidth) {
                        scale = scale - 1;
                        font.style.fontSize = scale + "px";
                    }
                }

                // TO DO: why don't work?????	
                //font.style.width = elems[i].offsetWidth	+ "px";
                //font.style.textAlign = "justify";  

                var diff = (parent.offsetHeight - font.offsetHeight) / 2;
                diff = diff.toFixed();

                if (diff > 0) { font.style.padding = diff + "px 0px"; }
                font.style.top = (parent.offsetHeight - font.offsetHeight) / 2 + "px";



            }



            if ((elem.content) && (elem.tag != "span")) {
                if (elem.content[0]) {
                    var j = 0;
                    while (elem.content[j]) {
                        pageCreateElement(elem.content[j], newElem);
                        j++;
                    }
                } else {
                    pageCreateElement(elem.content, newElem);
                }
            }
            delete newElem;
        }
    }



};

function loadPage(name) {
    /*
    var myRequest = new XMLHttpRequest();
    myRequest.open("GET", "./javascript/" + name + ".js?r=" + Math.random());
    myRequest.onload = currentPage;
    myRequest.onerror = function () { document.write('Error: can`t load JS') };
    myRequest.send();


    delete myRequest;

    */
    var head = document.getElementsByTagName("head")[0];

    if (document.getElementById("PageContent")) {
        document.getElementById("PageContent").src = "./javascript/" + name + ".js";
    } else {
        var script = document.createElement('script');
        //script.id = 'PageContent';
        script.type = 'text/javascript';
        script.src = "./javascript/" + name + ".js";
        head.appendChild(script);
    }


    window.location.hash = (window.location.hash.substr(1) != name) ? name : window.location.hash;
    checkPublCom();


}

function hashChangeLoadPage() {
    /*
    var name = window.location.hash.substr(1);
    if (name == "noFlash") {
    noFlashNotification();
    loadPage(page1);
    } else {
    loadPage(name);
    }
    */

    var strP = window.location.hash.split('&');
    var hash = strP[0].split('#')[1] ? strP[0].split('#')[1] : '';
    var IsPubl = (document.domain.indexOf('publ.com') != -1) ? true : false;

    //console.log('strP=' + strP)


    var SHOW_NOTE = (window.location.hash.indexOf("noFlash") != -1) ? true : false;

    if (isIE && versionIE == 7) {
        window.location.replace("./page1.html");
    } else {

        if (SHOW_NOTE) {

            for (var i = 0; i < strP.length; i++) {
                if (strP[i].indexOf("img=") != -1) {
                    var u = strP[i].substr(strP[i].indexOf("img=") + 4);
                    var imgUrl = IsPubl ? u : "./../../../" + u;
                }
                if (strP[i].indexOf("h=") != -1) {
                    var imgUrl = IsPubl ? imgUrl + '&' + strP[i] : imgUrl;
                }
                if (strP[i].indexOf("w=") != -1) {
                    var imgUrl = IsPubl ? imgUrl + '&' + strP[i] : imgUrl;
                }
                if (strP[i].indexOf("i=") != -1) {
                    var imgUrl = IsPubl ? imgUrl + '&' + strP[i] : imgUrl;
                }
                //console.log('imgUrl=' + imgUrl)
                if (strP[i].indexOf("spread=") != -1) {
                    var s = strP[i].substr(strP[i].indexOf("spread=") + 7);


                    if (IsPubl) {
                        var id = s.split('?')[0].split('/');
                        id = id[id.length - 1];
                        var publLink = encodeURIComponent(window.location.host + '/Session/DetectBrowser?returnTo=/' + id + '&type=Flash');

                        //console.log('publLink=' + publLink)
                    }

                    var spreadUrl = IsPubl ? s + '&link=' + window.location.protocol + '//' + publLink : "./../flash/spread.html";

                    //console.log('spreadUrl = ' + spreadUrl)
                }




            }



            noFlashNotification(imgUrl, spreadUrl);
            loadPage('page1');
        } else if (hash == "") {
            loadPage('page1');
        } else {
            var name = hash;
            if (1 * name > 0) {
                name = "page" + name;
                loadPage(name);
            } else if (name.indexOf("page") != -1) {
                loadPage(name);
            } else if (name.indexOf("toc") != -1) {
                loadPage(name);
            } else {
                loadPage('page1')
            }

        }
    }



}

function pageContentLoad(iin) {
    INNER = iin;
    currentPage();
}


function bindReady(handler) {

    var called = false;

    function ready() {
        if (called) return
        called = true
        setTimeout(handler, 50);
    }

    if (document.addEventListener) {
        document.addEventListener("DOMContentLoaded", function () {
            ready();
        }, false)
    } else if (document.attachEvent) {

        // (3.1)
        if (document.documentElement.doScroll && window == window.top) {
            function tryScroll() {
                if (called) return
                if (!document.body) return
                try {
                    document.documentElement.doScroll("left");
                    ready();
                } catch (e) {
                    setTimeout(tryScroll, 0);
                }
            }
            tryScroll();
        }

        document.attachEvent("onreadystatechange", function () {

            if (document.readyState === "complete") {
                ready();
            }
        })
    }

    if (window.addEventListener)
        window.addEventListener('load', ready, false)
    else if (window.attachEvent)
        window.attachEvent('onload', ready)
    /*  else  
    window.onload=ready
    */
}


function browserVer() {


    var browser = navigator.userAgent.toLowerCase();
    var UA = browser.match(/(opera|ie|firefox|chrome|version)[\s\/:]([\w\d\.]+)?.*?(safari|version[\s\/:]([\w\d\.]+)|$)/) || [null, 'unknown', 0];
    browserName = (UA[1] == 'version') ? UA[3] : UA[1];

    switch (browserName) {
        case 'safari':
            browserPrefix = 'webkit';
            break
        case 'firefox':
            browserPrefix = 'Moz';
            break
        case 'opera':
            browserPrefix = 'O';
            break
        case 'ie':
            browserPrefix = 'ms';
            isIE = true;
            if (document.all && !document.querySelector) {

                versionIE = 7;
            }

            if (document.all && document.querySelector && !document.getElementsByClassName) {
                versionIE = 8;
            }

            if (document.all && document.querySelector && document.getElementsByClassName && !window.atob) {
                versionIE = 9;
            }

            if (document.all && document.querySelector && document.getElementsByClassName && window.atob) {
                versionIE = 10;
                browserPrefix = '';
            }
            break
        case 'chrome':
            browserPrefix = 'webkit';
            break
        case 'unknown':
            browserPrefix = 'webkit';
            break
    };

}

function rotateContent(elem) {
    var angle = elem.style.transform.substr(7, elem.style.transform.length - 11);
    angle = angle.replace(",", ".");

    elem.style.overflow = "visible";

    var divWidthIn = 0;

    var sizeopt = { w: elem.offsetWidth, h: elem.offsetHeight };
    var cos = Math.cos(angle);
    var sin = Math.sin(angle);

    if (1 * versionIE < 9) {
        elem = elem.childNodes[0];
        var filter = 'progid:DXImageTransform.Microsoft.Matrix(sizingMethod="auto expand", M11 = ' + cos + ', M12 = ' + (-sin) + ', M21 = ' + sin + ', M22 = ' + cos + ')';
        elem.style.filter = filter;

        var w = elem.offsetWidth;
        var h = elem.offsetHeight;


        if (Math.PI / 2 <= angle && angle < Math.PI) {
            elem.style.marginLeft = Math.round(sizeopt.w * cos) + "px";
        } else if (Math.PI <= angle && angle < 3 * Math.PI / 2) {
            elem.style.marginLeft = Math.round(sizeopt.w * cos) + "px";
            elem.style.marginTop = Math.round(sizeopt.w * sin) + "px";
        } else if (3 * Math.PI / 2 <= angle && angle < 2 * Math.PI) {
            elem.style.marginTop = Math.round(sizeopt.w * sin) + "px";
        }


    } else if (1 * versionIE == 9) {
        elem.style[browserPrefix + 'TransformOrigin'] = "0 0 0";
        elem.style[browserPrefix + 'Transform'] = " rotate(" + angle + "rad)";
        elem.style.left = (1 * (elem.style.left.replace("px", "")) - (elem.style.width.replace("px", "")) / 2 + Math.round(sizeopt.w * cos / 2)) + "px";
        elem.style.top = (1 * (elem.style.top.replace("px", "")) + Math.round(sizeopt.w * sin / 2)) + "px";
    } else {
        elem.style[browserPrefix + 'transformOrigin'] = "0 0 0";
        elem.style[browserPrefix + 'transform'] = " rotate(" + angle + "rad)";
    }
}

function rotateContentAngle(elem, angle) {
    //var angle = elem.style.transform.substr(7, elem.style.transform.length - 11);
    angle = angle.replace(",", ".");



    elem.style.overflow = "visible";

    var divWidthIn = 0;

    var sizeopt = { w: elem.offsetWidth, h: elem.offsetHeight };
    var cos = Math.cos(angle);
    var sin = Math.sin(angle);


    if (1 * versionIE < 9) {
        elem = elem.childNodes[0];

        var filter = 'progid:DXImageTransform.Microsoft.Matrix(sizingMethod="auto expand", M11 = ' + cos + ', M12 = ' + (-sin) + ', M21 = ' + sin + ', M22 = ' + cos + ')';

        elem.style.filter = filter;

        var w = elem.offsetWidth;
        var h = elem.offsetHeight;


        if (Math.PI / 2 <= angle && angle < Math.PI) {
            elem.style.marginLeft = Math.round(sizeopt.w * cos) + "px";
        } else if (Math.PI <= angle && angle < 3 * Math.PI / 2) {
            elem.style.marginLeft = Math.round(sizeopt.w * cos) + "px";
            elem.style.marginTop = Math.round(sizeopt.w * sin) + "px";
        } else if (3 * Math.PI / 2 <= angle && angle < 2 * Math.PI) {
            elem.style.marginTop = Math.round(sizeopt.w * sin) + "px";
        }



    } else if (1 * versionIE == 9) {
        elem.style[browserPrefix + 'TransformOrigin'] = "0 0 0";
        elem.style[browserPrefix + 'Transform'] = " rotate(" + angle + "rad)";
        elem.style.left = (1 * (elem.style.left.replace("px", "")) - (elem.style.width.replace("px", "")) / 2 + Math.round(sizeopt.w * cos / 2)) + "px";
        elem.style.top = (1 * (elem.style.top.replace("px", "")) + Math.round(sizeopt.w * sin / 2)) + "px";
    } else {
        elem.style[browserPrefix + 'transformOrigin'] = "0 0 0";
        elem.style[browserPrefix + 'transform'] = " rotate(" + angle + "rad)";
    }
}
function setBG() {
    if (isIE && versionIE != 9 && versionIE != 10) {

        var elem = document.getElementById('bodyBg');
        var computedStyle = elem.currentStyle || window.getComputedStyle(elem, null);
        if (computedStyle.backgroundImage != "none") {

            elem.innerHTML = "<img src=" + computedStyle.backgroundImage.substr(5, computedStyle.backgroundImage.length - 7) + " style='position: fixed; top:0px; left: 0px; width:" + elem.offsetWidth + "px; height:" + elem.offsetHeight + "px;'>";
            elem.style.backgroundImage = "none";
        }
    }
}

function setSubstrate() {
    if (isIE && versionIE != 9 && versionIE != 10) {
        var elem = document.getElementById('Content');
        var computedStyle = elem.currentStyle || window.getComputedStyle(elem, null);

        if (computedStyle.backgroundImage != "none") {
            var imgBG = document.createElement('img');
            imgBG.src = computedStyle.backgroundImage.substr(5, computedStyle.backgroundImage.length - 7);
            imgBG.style.width = elem.offsetWidth + "px";
            imgBG.style.height = elem.offsetHeight + "px";
            imgBG.style.position = "absolute";
            imgBG.style.top = "0px";
            imgBG.style.left = "0px";
            (elem.childNodes[0]) ? elem.insertBefore(imgBG, elem.childNodes[0]) : elem.appendChild(imgBG);
        }
    }
}

function checkTocInit() {

    //browserVer();
    paramSet();

    if (isIE && versionIE < 9) {
        window.attachEvent("onresize", navigationCorrect);
    } else {
        window.addEventListener("resize", navigationCorrect, false);
    }

    bookWidth = bookScale * bookWidth;
    var windowWidth = getWidth();

    if (bookWidth < bookMinWidth) {
        bookScale = bookMinWidth / bookWidth;
        bookWidth = bookMinWidth;

    } else if (bookWidth > windowWidth - 300) {
        if (bookMinWidth > windowWidth - 300) {
            bookScale = bookMinWidth / bookWidth;
            bookWidth = bookMinWidth;
        } else {
            bookScale = (windowWidth - 300) / bookWidth;
            bookWidth = windowWidth - 300;
        }
    }
    checkTocSize();
    navigationCorrect();
    //setBG();



}


function checkLongString() {
    var item = document.getElementsByTagName('td')
    for (var i = 0; i < item.length; i++) {
        var cell = item[i].parentNode.parentNode.parentNode;
        cell = (cell.tagName == "LI") ? cell : (cell.parentNode.tagName == "LI") ? cell.parentNode : NaN;

        if (item[i].offsetWidth > cell.offsetWidth - 40) {
            var cellWidth = cell.offsetWidth - 40;
            var str = item[i].getElementsByTagName('a');
            if (str[0].innerText) { str[0].innerText = str[0].innerText.substring(0, cellWidth / 8) + '...'; }
            if (str[0].innerHTML) { str[0].innerHTML = str[0].innerHTML.substring(0, cellWidth / 8) + '...'; }
        }

    }
}

function getWidth() {
    if (isIE && versionIE != 9) {
        var windowWidth = document.documentElement.clientWidth;
    } else {
        var windowWidth = document.getElementsByTagName('body')[0].offsetWidth;
    }

    return windowWidth;
}

function getHeight() {
    if (isIE && versionIE != 9) {
        var windowHeight = document.documentElement.clientHeight;
    } else {
        var windowHeight = document.getElementsByTagName('body')[0].offsetHeight;
    }

    return windowHeight;
}

function getClientWidth() {
    return 'CSS1Compat' && !window.opera ? document.documentElement.clientWidth : document.body.clientWidth;
}
function getClientHeight() {
    //return  'CSS1Compat' && !window.opera ? document.documentElement.clientHeight : document.body.clientHeight;
    return document.documentElement.clientHeight;


}


function checkTocSize() {

    var ww = document.getElementById("Page").offsetWidth;

    if (ww != bookWidth) {
        document.getElementById("Book").style.width = bookWidth + 'px';
        document.getElementById("PageHeader").style.width = bookWidth + 'px';
        document.getElementById("PageMenu").style.width = bookWidth + 'px';
        document.getElementById("Page").style.width = bookWidth + 'px';

        if (document.getElementById("PageCopyright")) {
            document.getElementById("PageCopyright").style.width = bookWidth + 'px';
        }

    }

    checkLongString();

    var th = document.getElementById("TocList").offsetHeight + document.getElementById("TocHeader").offsetHeight;
    var hh = document.getElementById("PageHeader").offsetHeight + document.getElementById("PageMenu").offsetHeight;

    var bodyHeight = document.getElementsByTagName('body')[0].offsetHeight;

    if (hh + th > bodyHeight) {
        document.getElementById("Page").style.height = th + 30 + 'px';
    } else if ((bookHeight > bodyHeight)) {
        if (th > bodyHeight) {
            document.getElementById("Page").style.height = th + 30 + 'px';
        } else {
            document.getElementById("Page").style.height = bodyHeight - hh + 'px';
        }
    }



}

function checkPageInit() {

    browserVer();
    paramSet();

    if (isIE && versionIE < 9) {
        window.attachEvent("onresize", navigationCorrect);
    } else {
        window.addEventListener("resize", navigationCorrect, false);
    }





    var windowWidth = getWidth();

    bookScale = 1.2;

    if (bookWidth < bookMinWidth) {
        bookScale = bookMinWidth / bookWidth;
        bookWidth = bookMinWidth;
        bookHeight = bookScale * bookHeight;
        zoom(bookScale);


    } else if (bookWidth > windowWidth - 300) {
        if (bookMinWidth > windowWidth - 300) {
            bookScale = bookMinWidth / bookWidth;
            bookWidth = bookMinWidth;
            bookHeight = bookScale * bookHeight;
            zoom(bookScale);

        } else {
            bookScale = (windowWidth - 300) / bookWidth;
            bookWidth = windowWidth - 300;
            bookHeight = bookScale * bookHeight;
            zoom(bookScale);

        }
    } else {
        bookWidth = bookScale * bookWidth;
        bookHeight = bookScale * bookHeight;
        zoom(bookScale);

    }

    checkPageSize();
    navigationCorrect();
    //setBG();
    setSubstrate();

}


function checkPageSize() {
    var ww = document.getElementById("Page").offsetWidth;

    if (ww != bookWidth) {

        document.getElementById("Book").style.width = bookWidth + 'px';
        document.getElementById("PageHeader").style.width = bookWidth + 'px';
        document.getElementById("PageMenu").style.width = bookWidth + 'px';
        document.getElementById("Page").style.width = bookWidth + 'px';

        if (document.getElementById("PageCopyright")) {
            document.getElementById("PageCopyright").style.width = bookWidth + 'px';
        }

    }


    if (document.getElementById("Page").offsetHeight != bookHeight) {
        document.getElementById("Page").style.height = bookHeight + 'px';
    }

    if (bookHeight + 80 > getClientHeight()) {
        fixedNavigation();
    }

}

function fixedNavigation() {
    document.getElementById("leftTool").style.left = (document.getElementById("leftTool").offsetLeft + document.getElementById("leftTool").parentNode.offsetLeft) + "px";
    document.getElementById("leftTool").style.top = getClientHeight() / 2 + "px";
    document.getElementById("leftTool").style.position = "fixed";

    document.getElementById("rightTool").style.left = (document.getElementById("rightTool").offsetLeft + document.getElementById("rightTool").parentNode.offsetLeft) + "px";
    document.getElementById("rightTool").style.top = getClientHeight() / 2 + "px";
    document.getElementById("rightTool").style.position = "fixed";
}

function paramSet() {
    bookWidth = document.getElementById("Page").offsetWidth;
    var vW = document.getElementById("boxVersion").offsetWidth;
    var mW = document.getElementById("boxMenu").offsetWidth;
    bookMinWidth = (vW + mW + 40 < 500) ? 500 : vW + mW + 40;

    bookHeight = document.getElementById("Page").offsetHeight;
    bookScale = 1.2;
}

function zoom(step) {
    var item = document.getElementById('Content');
    var elems = item.childNodes;


    for (var i = 0; i < elems.length; i++) {
        if (elems[i].tagName == "DIV") {

            if (step != 1) {
                if (!elems[i].id) {

                    elems[i].style.top = (1 * (elems[i].style.top.replace("px", "")) * step) + "px";
                    elems[i].style.left = (1 * (elems[i].style.left.replace("px", "")) * step) + "px";

                    elems[i].style.width = (Math.abs(elems[i].style.width.replace("px", "")) * step) + "px";
                    elems[i].style.height = (Math.abs(elems[i].style.height.replace("px", "")) * step) + "px";

                    var img = elems[i].getElementsByTagName('img')[0];
                    if (img) {
                        var computedStyle = img.currentStyle || window.getComputedStyle(elems[i], null);
                        img.style.top = (1 * img.style.width.replace("px", "") * step) + "px";
                        img.style.left = (1 * img.style.width.replace("px", "") * step) + "px";

                        img.style.width = (1 * img.style.width.replace("px", "") * step) + "px";
                        img.style.height = (1 * img.style.height.replace("px", "") * step) + "px";

                    }
                    var video = elems[i].getElementsByTagName('iframe')[0];
                    if (video) {
                        var computedStyle = video.currentStyle || window.getComputedStyle(elems[i], null);
                        video.style.top = (1 * video.style.width.replace("px", "") * step) + "px";
                        video.style.left = (1 * video.style.width.replace("px", "") * step) + "px";

                        video.style.width = (1 * video.style.width.replace("px", "") * step) + "px";
                        video.style.height = (1 * video.style.height.replace("px", "") * step) + "px";

                    }
                }

            }

            var font = elems[i].getElementsByTagName('span')[0];
            if (font) {

                var computedStyle = font.currentStyle || window.getComputedStyle(font, null);
                if (font.style.fontSize) {
                    scale = (Math.abs(font.style.fontSize.replace("px", "")) * step);
                } else {
                    scale = (Math.abs(computedStyle.fontSize.replace("px", "")) * step);
                }
                font.style.fontSize = scale + "px";

                if (font.offsetWidth > elems[i].offsetWidth) {

                    while ((font.offsetWidth > elems[i].offsetWidth) && (scale > 1)) {
                        scale = scale - 1;
                        font.style.fontSize = scale + "px";
                    }
                } else if (font.offsetWidth < elems[i].offsetWidth) {
                    var tt = 0;
                    while ((font.offsetWidth < elems[i].offsetWidth) && (tt < 5)) {
                        scale = scale + 1;
                        tt++;
                        font.style.fontSize = scale + "px";
                    }
                    if (font.offsetWidth > elems[i].offsetWidth) {
                        scale = scale - 1;
                        font.style.fontSize = scale + "px";
                    }
                }

                // TO DO: why don't work?????	
                //font.style.width = elems[i].offsetWidth	+ "px";
                //font.style.textAlign = "justify";  

                var diff = ((elems[i].offsetHeight - font.offsetHeight) / 2);
                diff = diff.toFixed();

                if (diff > 0) { font.style.padding = diff + "px 0px"; }
                font.style.top = ((elems[i].offsetHeight - font.offsetHeight) / 2) + "px";
            }


            if (isIE && elems[i].style.transform) {
                rotateContent(elems[i]);
            }
        }

    }


}

function checkPublCom() {
    if (document.domain.indexOf('publ.com') != -1) {
        var parts = document.URL.split('/');
        var prevpart = '';
        for (var i = 0; i < parts.length; i++) {
            if (prevpart.toLowerCase() == 'bookdata')
                return replaceBackLink(parts[i]);
            if (parts[i].toLowerCase() == 'seo' || parts[i].toLowerCase() == 'basic-html')
                return replaceBackLink(prevpart);
            prevpart = parts[i];
        }
    } else {
        return replaceBackLink();
        //console.log(document.getElementById('fullVersionLink').href.indexOf('#'))
    }
}

function replaceBackLink(id) {
    var link = document.getElementById('fullVersionLink');

    if (link) {
        var hash = '';

        sss = link.href.split('#');
        if (sss[1]) {
            hash = '#' + sss[1];
        } else {
            hash = '';
        }


        /*
        var hash = window.location.hash;
        if (hash.indexOf('toc') != -1) {
        hash = -1;
        } else {
        hash = '#/' + hash.substr(4 + 1) + '/';
        }
        */

        if (hash != -1)
            link.href = (document.domain.indexOf('publ.com') != -1) ? 'http://' + document.domain + '/' + id + hash : (link.href.indexOf('#') != -1) ? link.href.substr(0, link.href.indexOf('#')) + hash : link.href + hash;
        else
            link.href = (document.domain.indexOf('publ.com') != -1) ? 'http://' + document.domain + '/' + id : (link.href.indexOf('#') != -1) ? link.href.substr(0, link.href.indexOf('#')) : link.href;
    }
}

function checkIndex() {
    browserVer();

    if (!(isIE && versionIE == 7)) {

        var parts = document.URL.split('/');
        var hash = parts[parts.length - 1].split('.')[0];
        var link = '';
        for (var i = 0; i < parts.length - 1; i++) {
            link += parts[i] + '/';
        }
        link += 'index.html#' + hash;
        window.location.replace(link);
    }

}