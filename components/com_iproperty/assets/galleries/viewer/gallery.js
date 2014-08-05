/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

function IPGallery(cp,pa) {

	this.currentPic	= cp;
	this.picamount	= pa;
	this.highlight	= new Array("#C64934","#FFFFFF");
	this.slideshow	= 1;
	this.speed		= 5000;
		
	// Gallery Methods
	this.firstPic		= firstPic;
	this.lastPic		= lastPic;
	this.nextPic		= nextPic;
	this.previousPic    = previousPic;
	this.showPic		= showPic;
	this.mark			= mark;
	this.startSls		= startSls;
	this.stopSls		= stopSls;
	this.slowerSls	    = slowerSls;
	this.fasterSls		= fasterSls;
	
}

function mark(p,c){
	var e = document.getElementById(p);
    e.style.borderColor = this.highlight[c];
}

function firstPic(){
	this.currentPic = 1;
	this.showPic();
}

function lastPic(){
	this.currentPic = this.picamount;
	this.showPic();
}

function previousPic(){
	if(this.currentPic == 1){
		//alert("First picture reached!");
	}
	else{
		this.currentPic = this.currentPic -1;
		this.showPic();
	}
}

function nextPic(){	
	if(gl.slideshow == 0){
		if(this.currentPic == this.picamount){
			//alert("Last picture reached!");
		}
		else{
			this.currentPic = this.currentPic +1;
			this.showPic();
		}
	}
	else{
		if(gl.currentPic == gl.picamount){
			gl.currentPic = 1;
		}
		else{
			gl.currentPic = gl.currentPic +1;
		}
		sp = gl.speed;			
		setTimeout("showPic()",sp);
	}
}

function startSls(){
	this.slideshow = 1;
	this.showPic();
}

function stopSls(){
	this.slideshow = 0;
}

function slowerSls(){
	if(this.speed < 10000) {
    	this.speed	+= 1000;
    }
    else{
    	//alert("Slowest Speed Reached!");
    }
}

function fasterSls(){
	if(this.speed > 1000) {
    	this.speed	-= 1000;
    }
    else{
    	//alert("Fastest speed reached!");
    } 
}

function showPic(){		
	var img = eval('document.images[\'ipimage\']');
	
	if(gl.slideshow == 0){
		nr = this.currentPic
        if(nr == undefined){
            //bypass
        }else{
            img.src = pic[nr].imgpath + pic[nr].name + pic[nr].type;
        }
	}
	else{
		nr = gl.currentPic;
		if(nr == undefined){
            //bypass
        }else{
            img.src = pic[nr].imgpath + pic[nr].name + pic[nr].type;
            gl.nextPic();
        }
	}
}

function IPImage(pp,t,d,fn,tp) {
    this.imgpath		= pp;
    this.title			= t;
    this.description	= d;
    this.name 			= fn;
    this.type			= tp;		
}


