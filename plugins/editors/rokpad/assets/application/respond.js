/*
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
window.matchMedia=window.matchMedia||(function(l,k){var n,i=l.documentElement,h=i.firstElementChild||i.firstChild,m=l.createElement("body"),j=l.createElement("div");
j.id="mq-test-1";j.style.cssText="position:absolute;top:-100em";m.style.background="none";m.appendChild(j);return function(a){j.innerHTML='&shy;<style media="'+a+'"> #mq-test-1 { width: 42px; }</style>';
i.insertBefore(m,h);n=j.offsetWidth==42;i.removeChild(m);return{matches:n,media:a};};})(document);
/* Respond.js v1.1.0: min/max-width media query polyfill. (c) Scott Jehl. MIT/GPLv2 Lic. j.mp/respondjs  */
(function(P){P.respond={};
respond.update=function(){};respond.mediaQueriesSupported=P.matchMedia&&P.matchMedia("only all").matches;if(respond.mediaQueriesSupported){return;}var x=P.document,B=x.documentElement,L=[],J=[],D=[],F={},M=30,O=x.getElementsByTagName("head")[0]||B,N=x.getElementsByTagName("base")[0],S=O.getElementsByTagName("link"),Q=[],T=function(){var c=S,g=c.length,f=0,b,e,d,a;
for(;f<g;f++){b=c[f],e=b.href,d=b.media,a=b.rel&&b.rel.toLowerCase()==="stylesheet";if(!!e&&a&&!F[e]){if(b.styleSheet&&b.styleSheet.rawCssText){H(b.styleSheet.rawCssText,e,d);
F[e]=true;}else{if((!/^([a-zA-Z:]*\/\/)/.test(e)&&!N)||e.replace(RegExp.$1,"").split("/")[0]===P.location.host){Q.push({href:e,media:d});}}}}z();},z=function(){if(Q.length){var a=Q.shift();
G(a.href,function(b){H(b,a.href,a.media);F[a.href]=true;z();});}},H=function(i,h,e){var k=i.match(/@media[^\{]+\{([^\{\}]*\{[^\}\{]*\})+/gi),g=k&&k.length||0,h=h.substring(0,h.lastIndexOf("/")),f=function(n){return n.replace(/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g,"$1"+h+"$2$3");
},d=!g&&e,a=0,b,m,l,c,j;if(h.length){h+="/";}if(d){g=1;}for(;a<g;a++){b=0;if(d){m=e;J.push(f(i));}else{m=k[a].match(/@media *([^\{]+)\{([\S\s]+?)$/)&&RegExp.$1;
J.push(RegExp.$2&&f(RegExp.$2));}c=m.split(",");j=c.length;for(;b<j;b++){l=c[b];L.push({media:l.split("(")[0].match(/(only\s+)?([a-zA-Z]+)\s?/)&&RegExp.$2||"all",rules:J.length-1,hasquery:l.indexOf("(")>-1,minw:l.match(/\(min\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/)&&parseFloat(RegExp.$1)+(RegExp.$2||""),maxw:l.match(/\(max\-width:[\s]*([\s]*[0-9\.]+)(px|em)[\s]*\)/)&&parseFloat(RegExp.$1)+(RegExp.$2||"")});
}}K();},I,C,y=function(){var c,b=x.createElement("div"),a=x.body,d=false;b.style.cssText="position:absolute;font-size:1em;width:1em";if(!a){a=d=x.createElement("body");
a.style.background="none";}a.appendChild(b);B.insertBefore(a,B.firstChild);c=b.offsetWidth;if(d){B.removeChild(a);}else{a.removeChild(b);}c=E=parseFloat(c);
return c;},E,K=function(l){var k="clientWidth",c=B[k],m=x.compatMode==="CSS1Compat"&&c||x.body[k]||c,a={},n=S[S.length-1],g=(new Date()).getTime();if(l&&I&&g-I<M){clearTimeout(C);
C=setTimeout(K,M);return;}else{I=g;}for(var p in L){var i=L[p],b=i.minw,j=i.maxw,d=b===null,f=j===null,h="em";if(!!b){b=parseFloat(b)*(b.indexOf(h)>-1?(E||y()):1);
}if(!!j){j=parseFloat(j)*(j.indexOf(h)>-1?(E||y()):1);}if(!i.hasquery||(!d||!f)&&(d||m>=b)&&(f||m<=j)){if(!a[i.media]){a[i.media]=[];}a[i.media].push(J[i.rules]);
}}for(var p in D){if(D[p]&&D[p].parentNode===O){O.removeChild(D[p]);}}for(var p in a){var e=x.createElement("style"),o=a[p].join("\n");e.type="text/css";
e.media=p;O.insertBefore(e,n.nextSibling);if(e.styleSheet){e.styleSheet.cssText=o;}else{e.appendChild(x.createTextNode(o));}D.push(e);}},G=function(a,b){var c=R();
if(!c){return;}c.open("GET",a,true);c.onreadystatechange=function(){if(c.readyState!=4||c.status!=200&&c.status!=304){return;}b(c.responseText);};if(c.readyState==4){return;
}c.send(null);},R=(function(){var a=false;try{a=new XMLHttpRequest();}catch(b){a=new ActiveXObject("Microsoft.XMLHTTP");}return function(){return a;};})();
T();respond.update=T;function A(){K(true);}if(P.addEventListener){P.addEventListener("resize",A,false);}else{if(P.attachEvent){P.attachEvent("onresize",A);
}}})(this);