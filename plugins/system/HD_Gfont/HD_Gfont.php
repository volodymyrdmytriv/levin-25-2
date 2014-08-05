<?php
# HD-GFont       	          	          	              
# Copyright (C) 2012 by Hyde-Design  	   	   	   	   
# Homepage   : www.hyde-design.co.uk		   	   	   
# Author     : Hyde-Design    		   	   	   	   
# Email      : sales@hyde-design.co.uk 	   	   	   
# Version    : 3.25.1
# Latest Font: Chelsea Market                       	   	    	
# License    : http://www.gnu.org/copyleft/gpl.html GNU/GPL         

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');

class plgSystemHD_Gfont extends JPlugin
{function plgSystemHD_Gfont(&$subject, $config)	{parent::__construct($subject, $config);	
$this->_plugin = JPluginHelper::getPlugin( 'System', 'HD_Gfont' );}
	
	function onAfterRender()
	{ $element_url = '/administrator/'; $current_url = $_SERVER['REQUEST_URI'];
	global $mainframe;
	$buffer = JResponse::getBody();
	if (strstr($current_url, $element_url)) {;} else {
	
	
$goofurl_1 = '';
$goofont1 = '';
$goofont1 = $this->params->get( 'font-face-1' );

if ($goofont1=="Allan") {$goofurl_1="Allan:bold";}
elseif ($goofont1=="Exo") {$goofurl_1="Exo:400";$goofont1="Exo";}
elseif ($goofont1=="Exo Italic") {$goofurl_1="Exo:400italic";$goofont1="Exo";}
elseif ($goofont1=="Exo Bold") {$goofurl_1="Exo:700";$goofont1="Exo";}
elseif ($goofont1=="Exo Bold Italic") {$goofurl_1="Exo:700italic";$goofont1="Exo";}
elseif ($goofont1=="Chelsea Market") {$goofurl_1="Chelsea+Market";}
elseif ($goofont1=="Jim Nightmare") {$goofurl_1="Jim+Nightmare";}
elseif ($goofont1=="Oldenburg") {$goofurl_1="Oldenburg";}
elseif ($goofont1=="Spicy Rice") {$goofurl_1="Spicy+Rice";}
elseif ($goofont1=="Nosifer") {$goofurl_1="Nosifer";}
elseif ($goofont1=="Eater") {$goofurl_1="Eater";}
elseif ($goofont1=="Creepster") {$goofurl_1="Creepster";}
elseif ($goofont1=="Butcherman") {$goofurl_1="Butcherman";}
elseif ($goofont1=="Sofia") {$goofurl_1="Sofia";}
elseif ($goofont1=="Asul") {$goofurl_1="Asul";}
elseif ($goofont1=="Alex Brush") {$goofurl_1="Alex+Brush";}
elseif ($goofont1=="Arizonia") {$goofurl_1="Arizonia";}
elseif ($goofont1=="Italianno") {$goofurl_1="Italianno";}
elseif ($goofont1=="Qwigley") {$goofurl_1="Qwigley";}
elseif ($goofont1=="Ruge Boogie") {$goofurl_1="Ruge+Boogie";}
elseif ($goofont1=="Ruthie") {$goofurl_1="Ruthie";}
elseif ($goofont1=="Playball") {$goofurl_1="Playball";}
elseif ($goofont1=="Dynalight") {$goofurl_1="Dynalight";}
elseif ($goofont1=="Stoke") {$goofurl_1="Stoke";}
elseif ($goofont1=="Sarina") {$goofurl_1="Sarina";}
elseif ($goofont1=="Yesteryear") {$goofurl_1="Yesteryear";}
elseif ($goofont1=="Trade Winds") {$goofurl_1="Trade+Winds";}
elseif ($goofont1=="Frijole") {$goofurl_1="Frijole";}
elseif ($goofont1=="Trykker") {$goofurl_1="Trykker";}
elseif ($goofont1=="Sail") {$goofurl_1="Sail";}
elseif ($goofont1=="Quantico") {$goofurl_1="Quantico";}
elseif ($goofont1=="Patua One") {$goofurl_1="Patua+One";}
elseif ($goofont1=="Overlock") {$goofurl_1="Overlock";}
elseif ($goofont1=="Overlock SC") {$goofurl_1="Overlock+SC";}
elseif ($goofont1=="Habibi") {$goofurl_1="Habibi";}
elseif ($goofont1=="Noticia Text") {$goofurl_1="Noticia+Text";}
elseif ($goofont1=="Miniver") {$goofurl_1="Miniver";}
elseif ($goofont1=="Medula One") {$goofurl_1="Medula+One";}
elseif ($goofont1=="Inder") {$goofurl_1="Inder";}
elseif ($goofont1=="Fugaz One") {$goofurl_1="Fugaz+One";}
elseif ($goofont1=="Flavors") {$goofurl_1="Flavors";}
elseif ($goofont1=="Flamenco") {$goofurl_1="Flamenco";}
elseif ($goofont1=="Duru Sans") {$goofurl_1="Duru+Sans";}
elseif ($goofont1=="Crete Round") {$goofurl_1="Crete+Round";}
elseif ($goofont1=="Caesar Dressing") {$goofurl_1="Caesar+Dressing";}
elseif ($goofont1=="Cambo") {$goofurl_1="Cambo";}
elseif ($goofont1=="Bluenard") {$goofurl_1="Bluenard";}
elseif ($goofont1=="Bree Serif") {$goofurl_1="Bree+Serif";}
elseif ($goofont1=="Boogaloo") {$goofurl_1="Boogaloo";}
elseif ($goofont1=="Belgrano") {$goofurl_1="Belgrano";}
elseif ($goofont1=="Armata") {$goofurl_1="Armata";}
elseif ($goofont1=="Alfa Slab One") {$goofurl_1="Alfa+Slab+One";}
elseif ($goofont1=="Uncial Antiqua") {$goofurl_1="Uncial+Antique";}
elseif ($goofont1=="Almendra") {$goofurl_1="Almendra";}
elseif ($goofont1=="Almendra SC") {$goofurl_1="Almendra+SC";}
elseif ($goofont1=="Acme") {$goofurl_1="Acme";}
elseif ($goofont1=="Squada One") {$goofurl_1="Squada+One";}
elseif ($goofont1=="Basic") {$goofurl_1="Basic";}
elseif ($goofont1=="Bilbo Swash Caps") {$goofurl_1="Bilbo+Swash+Caps";}
elseif ($goofont1=="Marko One") {$goofurl_1="Marko+One";}
elseif ($goofont1=="Bad Script") {$goofurl_1="Bad+Script";}
elseif ($goofont1=="Plaster") {$goofurl_1="Plaster";}
elseif ($goofont1=="Handlee") {$goofurl_1="Handlee";}
elseif ($goofont1=="Bathazar") {$goofurl_1="Bathazar";}
elseif ($goofont1=="Passion One") {$goofurl_1="Passion+One";}
elseif ($goofont1=="Chango") {$goofurl_1="Chango";}
elseif ($goofont1=="Enriqueta") {$goofurl_1="Enriqueta";}
elseif ($goofont1=="Montserrat") {$goofurl_1="Montserrat";}
elseif ($goofont1=="Original Surfer") {$goofurl_1="Original+Surfer";}
elseif ($goofont1=="Baumans") {$goofurl_1="Baumans";}
elseif ($goofont1=="Fascinate") {$goofurl_1="Fascinate";}
elseif ($goofont1=="Fascinate Inline") {$goofurl_1="Fascinate+Inline";}
elseif ($goofont1=="Stint Ultra Condensed") {$goofurl_1="Stint+Ultra+Condensed";}
elseif ($goofont1=="Bonbon") {$goofurl_1="Bonbon";}
elseif ($goofont1=="Arbutus") {$goofurl_1="Arbutus";}
elseif ($goofont1=="Galdeano") {$goofurl_1="Galdeano";}
elseif ($goofont1=="Metamorphous") {$goofurl_1="Metamorphous";}
elseif ($goofont1=="Cevivhe One") {$goofurl_1="Cevivhe+One";}
elseif ($goofont1=="Marmelad") {$goofurl_1="Marmelad";}
elseif ($goofont1=="Engagement") {$goofurl_1="Engagement";}
elseif ($goofont1=="Electrolize") {$goofurl_1="Electrolize";}
elseif ($goofont1=="Fresca") {$goofurl_1="Fresca";}
elseif ($goofont1=="Vigo") {$goofurl_1="Vigo";}
elseif ($goofont1=="Bilbo") {$goofurl_1="Bilbo";}
elseif ($goofont1=="Cabin Condensed") {$goofurl_1="Cabin+Condensed";}
elseif ($goofont1=="Dr Sugiyama") {$goofurl_1="Dr+Sugiyama";}
elseif ($goofont1=="Herr Von Muellerhoff") {$goofurl_1="Herr+Von+Muellerhoff";}
elseif ($goofont1=="Miss Fajardose") {$goofurl_1="Miss+Fajardose";}
elseif ($goofont1=="Miss Saint Delafield") {$goofurl_1="Miss+Saint+Delafield";}
elseif ($goofont1=="Monsieur La Doulaise") {$goofurl_1="Monsieur+La+Doulaise";}
elseif ($goofont1=="Mr Bedford") {$goofurl_1="Mr+Bedford";}
elseif ($goofont1=="Mr Dafoe") {$goofurl_1="Mr+Dafoe";}
elseif ($goofont1=="Mr De Gaviland") {$goofurl_1="Mr+De+Gaviland";}
elseif ($goofont1=="Mrs Sheppards") {$goofurl_1="Mrs+Sheppards";}
elseif ($goofont1=="Aguafina Script") {$goofurl_1="Aguafina+Script";}
elseif ($goofont1=="Piedra") {$goofurl_1="Piedra";}
elseif ($goofont1=="Aladin") {$goofurl_1="Aladin";}
elseif ($goofont1=="Chicle") {$goofurl_1="Chicle";}
elseif ($goofont1=="Cagliostro") {$goofurl_1="Cagliostro";}
elseif ($goofont1=="Lemon") {$goofurl_1="Lemon";}
elseif ($goofont1=="Unlock") {$goofurl_1="Unlock";}
elseif ($goofont1=="Signika") {$goofurl_1="Signika";}
elseif ($goofont1=="Signika Negaive") {$goofurl_1="Signika+Negative";}
elseif ($goofont1=="Niconne") {$goofurl_1="Niconne";}
elseif ($goofont1=="Knewave") {$goofurl_1="Knewave";}
elseif ($goofont1=="Righteous") {$goofurl_1="Righteous";}
elseif ($goofont1=="Ribeye") {$goofurl_1="Ribeye";}
elseif ($goofont1=="Ribeye Marrow") {$goofurl_1="Ribeye+Marrow";}
elseif ($goofont1=="Spirax") {$goofurl_1="Spirax";}
elseif ($goofont1=="Concert One") {$goofurl_1="Concert+One";}
elseif ($goofont1=="Bubblegun Sans") {$goofurl_1="Bubblegun+Sans";}
elseif ($goofont1=="Iceland") {$goofurl_1="Iceland";}
elseif ($goofont1=="Devonshire") {$goofurl_1="Devonshire";}
elseif ($goofont1=="Fondamento") {$goofurl_1="Fondamento";}
elseif ($goofont1=="Bitter") {$goofurl_1="Bitter";}
elseif ($goofont1=="Convergence") {$goofurl_1="Convergence";}
elseif ($goofont1=="Lancelot") {$goofurl_1="Lancelot";}
elseif ($goofont1=="Petrona") {$goofurl_1="Petrona";}
elseif ($goofont1=="Supermercado One") {$goofurl_1="Supermercado+One";}
elseif ($goofont1=="Arapey") {$goofurl_1="Arapey";}
elseif ($goofont1=="Mate") {$goofurl_1="Mate";}
elseif ($goofont1=="Mate SC") {$goofurl_1="Mate+SC";}
elseif ($goofont1=="Rammetto One") {$goofurl_1="Rammetto+One";}
elseif ($goofont1=="Fjord One") {$goofurl_1="Fjord+One";}
elseif ($goofont1=="Cabin Sketch") {$goofurl_1="Cabin+Sketch";}
elseif ($goofont1=="Jockey One") {$goofurl_1="Jockey+One";}
elseif ($goofont1=="Contrail One") {$goofurl_1="Contrail+One";}
elseif ($goofont1=="Atomic Age") {$goofurl_1="Atomic+Age";}
elseif ($goofont1=="Corben") {$goofurl_1="Corben";}
elseif ($goofont1=="Linden Hill") {$goofurl_1="Linden+Hill";}
elseif ($goofont1=="Quicksand") {$goofurl_1="Quicksand";}
elseif ($goofont1=="Amatic SC") {$goofurl_1="Amatic+SC";}
elseif ($goofont1=="Salsa") {$goofurl_1="Salsa";}
elseif ($goofont1=="Marck Script") {$goofurl_1="Marck+Script";}
elseif ($goofont1=="Vast Shadow") {$goofurl_1="Vast+Shadow";}
elseif ($goofont1=="Cookie") {$goofurl_1="Cookie";}
elseif ($goofont1=="Pinyon Script") {$goofurl_1="Pinyon+Script";}
elseif ($goofont1=="Satisfy") {$goofurl_1="Satisfy";}
elseif ($goofont1=="Rancho") {$goofurl_1="Rancho";}
elseif ($goofont1=="Coda") {$goofurl_1="Coda";}
elseif ($goofont1=="Sancheek") {$goofurl_1="Sancheek";}
elseif ($goofont1=="Ubunto Mon") {$goofurl_1="Ubunto+Mon";}
elseif ($goofont1=="Unbunto Condensed") {$goofurl_1="Ubunto+Condensed";}
elseif ($goofont1=="Federant") {$goofurl_1="Federant";}
elseif ($goofont1=="Andada") {$goofurl_1="Andada";}
elseif ($goofont1=="Poly") {$goofurl_1="Poly";}
elseif ($goofont1=="Gochi Hand") {$goofurl_1="Gochi+Hand";}
elseif ($goofont1=="Alike Angular") {$goofurl_1="Alike+Angular";}
elseif ($goofont1=="Poller One") {$goofurl_1="Poller+One";}
elseif ($goofont1=="Chivo") {$goofurl_1="Chivo";}
elseif ($goofont1=="Sanista One") {$goofurl_1="Sanista+One";}
elseif ($goofont1=="Terminal Dosis") {$goofurl_1="Terminal+Dosis";}
elseif ($goofont1=="Sorts Mill Goudy") {$goofurl_1="Sorts+Mill+Goudy";}
elseif ($goofont1=="Adamina") {$goofurl_1="Adamina";}
elseif ($goofont1=="Prata") {$goofurl_1="Prata";}
elseif ($goofont1=="Julee") {$goofurl_1="Julee";}
elseif ($goofont1=="Changa One") {$goofurl_1="Changa+One";}
elseif ($goofont1=="Merienda One") {$goofurl_1="Merienda+One";}
elseif ($goofont1=="Prociono") {$goofurl_1="Prociono";}
elseif ($goofont1=="Passero One") {$goofurl_1="Passero+One";}
elseif ($goofont1=="Antic") {$goofurl_1="Antic";}
elseif ($goofont1=="Dorsa") {$goofurl_1="Dorsa";}
elseif ($goofont1=="Abril Fatface") {$goofurl_1="Abril+Fatface";}
elseif ($goofont1=="Delius Unicase") {$goofurl_1="Delius+Unicase";}
elseif ($goofont1=="Alike") {$goofurl_1="Alike";}
elseif ($goofont1=="Monoton") {$goofurl_1="Monoton";}
elseif ($goofont1=="Days One") {$goofurl_1="Days One";}
elseif ($goofont1=="Numans") {$goofurl_1="Numans";}
elseif ($goofont1=="Aldrich") {$goofurl_1="Aldrich";}
elseif ($goofont1=="Vidaloka") {$goofurl_1="Vidaloka";}
elseif ($goofont1=="Short Stack") {$goofurl_1="Short+Stack";}
elseif ($goofont1=="Montez") {$goofurl_1="Montez";}
elseif ($goofont1=="Voltaire") {$goofurl_1="Voltaire";}
elseif ($goofont1=="Geostar Fill") {$goofurl_1="Geostar+Fill";}
elseif ($goofont1=="Geostar") {$goofurl_1="Geostar";}
elseif ($goofont1=="Questrial") {$goofurl_1="Questrial";}
elseif ($goofont1=="Alice") {$goofurl_1="Alice";}
elseif ($goofont1=="Andika") {$goofurl_1="Andika";}
elseif ($goofont1=="Tulpen One") {$goofurl_1="Tulpen+One";}
elseif ($goofont1=="Smokum") {$goofurl_1="Smokum";}
elseif ($goofont1=="Delius Swash Caps") {$goofurl_1="Delius+Swash+Caps";}
elseif ($goofont1=="Actor") {$goofurl_1="Actor";}
elseif ($goofont1=="Abel") {$goofurl_1="Abel";}
elseif ($goofont1=="Rationale") {$goofurl_1="Rationale";}
elseif ($goofont1=="Rochester") {$goofurl_1="Rochester";}
elseif ($goofont1=="Delius") {$goofurl_1="Delius";}
elseif ($goofont1=="Federo") {$goofurl_1="Federo";}
elseif ($goofont1=="Aubrey") {$goofurl_1="Aubrey";}
elseif ($goofont1=="Carme") {$goofurl_1="Carme";}
elseif ($goofont1=="Black Ops One") {$goofurl_1="Black+Ops+One";}
elseif ($goofont1=="Kelly Slab") {$goofurl_1="Kelly+Slab";}
elseif ($goofont1=="Gloria Hallelujah") {$goofurl_1="Gloria+Hallelujah";}
elseif ($goofont1=="Ovo") {$goofurl_1="Ovo";}
elseif ($goofont1=="Snippet") {$goofurl_1="Snippet";}
elseif ($goofont1=="Leckerli One") {$goofurl_1="Leckerli+One";}
elseif ($goofont1=="Rosario") {$goofurl_1="Rosario";}
elseif ($goofont1=="Unna") {$goofurl_1="Unna";}
elseif ($goofont1=="Pompiere") {$goofurl_1="Pompiere";}
elseif ($goofont1=="Yellowtail") {$goofurl_1="Yellowtail";}
elseif ($goofont1=="Modern Antiqua") {$goofurl_1="Modern+Antiqua";}
elseif ($goofont1=="Give You Glory") {$goofurl_1="Give+You+Glory";}
elseif ($goofont1=="Yeseva One") {$goofurl_1="Yeseva+One";}
elseif ($goofont1=="Varela Round") {$goofurl_1="Varela+Round";}
elseif ($goofont1=="Patrick Hand") {$goofurl_1="Patrick+Hand";}
elseif ($goofont1=="Forum") {$goofurl_1="Forum";}
elseif ($goofont1=="Bowlby One") {$goofurl_1="Bowlby+One";}
elseif ($goofont1=="Bowlby One SC") {$goofurl_1="Bowlby+One+SC";}
elseif ($goofont1=="Loved by the King") {$goofurl_1="Loved+by+the+King";}
elseif ($goofont1=="Love Ya Like A Sister") {$goofurl_1="Love+Ya+Like+A+Sister";}
elseif ($goofont1=="Stardos Stencil") {$goofurl_1="Stardos+Stencil";}
elseif ($goofont1=="Hammersmith One") {$goofurl_1="Hammersmith+One";}
elseif ($goofont1=="Gravitas One") {$goofurl_1="Gravitas+One";}
elseif ($goofont1=="Asset") {$goofurl_1="Asset";}
elseif ($goofont1=="Goblin One") {$goofurl_1="Goblin+One";}
elseif ($goofont1=="Varela") {$goofurl_1="Varela";}
elseif ($goofont1=="Fanwood Text") {$goofurl_1="Fanwood+Text";$goofont1="Fanwood Text";}
elseif ($goofont1=="Fanwood Text") {$goofurl_1="Fanwood+Text:400italic";$goofont1="Fanwood Text";}
elseif ($goofont1=="Gentium Basic") {$goofurl_1="Gentium+Basic";$goofont1="Gentium Basic";}
elseif ($goofont1=="Gentium Basic Italic") {$goofurl_1="Gentium+Basic:400italic";$goofont1="Gentium Basic";}
elseif ($goofont1=="Gentium Basic Bold") {$goofurl_1="Gentium+Basic:700";$goofont1="Gentium Basic";}
elseif ($goofont1=="Gentium Basic Bold Italic") {$goofurl_1="Gentium+Basic:700italic";$goofont1="Gentium Basic";}
elseif ($goofont1=="Gentium Book Basic") {$goofurl_1="Gentium+Book+Basic";$goofont1="Gentium Book Basic";}
elseif ($goofont1=="Gentium Book Basic Italic") {$goofurl_1="Gentium+Book+Basic:400italic";$goofont1="Gentium Book Basic";}
elseif ($goofont1=="Gentium Book Basic Bold") {$goofurl_1="Gentium+Book+Basic:700";$goofont1="Gentium Book Basic";}
elseif ($goofont1=="Gentium Book Basic Bold Italic") {$goofurl_1="Gentium+Book+Basic:700italic";$goofont1="Gentium Book Basic";}
elseif ($goofont1=="Volkhov") {$goofurl_1="Volkhov";$goofont1="Volkhov";}
elseif ($goofont1=="Volkhov Italic") {$goofurl_1="Volkhov:400italic";$goofont1="Volkhov";}
elseif ($goofont1=="Volkhov Bold") {$goofurl_1="Volkhov:700";$goofont1="Volkhov";}
elseif ($goofont1=="Volkhov Bold Italic") {$goofurl_1="Volkhov:700italic";$goofont1="Volkhov";}
elseif ($goofont1=="Comfortaa Book") {$goofurl_1="Comfortaa:300";$goofont1="Comfortaa";}
elseif ($goofont1=="Comfortaa Normal") {$goofurl_1="Comfortaa";$goofont1="Comfortaa";}
elseif ($goofont1=="Comfortaa Bold") {$goofurl_1="Comfortaa:700";$goofont1="Comfortaa";}
elseif ($goofont1=="Coustard") {$goofurl_1="Coustard";$goofont1="Coustard";}
elseif ($goofont1=="Coustard Ultra Bold") {$goofurl_1="Coustard:900";$goofont1="Coustard";}
elseif ($goofont1=="Marvel") {$goofurl_1="Marvel";$goofont1="Marvel";}
elseif ($goofont1=="Marvel Italic") {$goofurl_1="Marvel:400italic";$goofont1="Marvel";}
elseif ($goofont1=="Marvel Bold") {$goofurl_1="Marvel:700";$goofont1="Marvel";}
elseif ($goofont1=="Marvel Bold Italic") {$goofurl_1="Marvel:700italic";$goofont1="Marvel";}
elseif ($goofont1=="Istok Web") {$goofurl_1="Istok+Web";$goofont1="Istok Web";}
elseif ($goofont1=="Istok Web Italic") {$goofurl_1="Istok+Web:400italic";$goofont1="Istok Web";}
elseif ($goofont1=="Istok Web Bold") {$goofurl_1="Istok+Web:700";$goofont1="Istok Web";}
elseif ($goofont1=="Istok Web Bold Italic") {$goofurl_1="Istok+Web:700italic";$goofont1="Istok Web";}
elseif ($goofont1=="Tienne") {$goofurl_1="Tienne";$goofont1="Tienne";}
elseif ($goofont1=="Tienne Bold") {$goofurl_1="Tienne:700";$goofont1="Tienne";}
elseif ($goofont1=="Tienne Ultra Bold") {$goofurl_1="Tienne:900";$goofont1="Tienne";}
elseif ($goofont1=="Nixie One") {$goofurl_1="Nixie+One";}
elseif ($goofont1=="Redressed") {$goofurl_1="Redressed";}
elseif ($goofont1=="Lobster Two") {$goofurl_1="Lobster+Two";$goofont1="Lobster Two";}
elseif ($goofont1=="Lobster Two Italic") {$goofurl_1="Lobster+Two:400italic";$goofont1="Lobster Two";}
elseif ($goofont1=="Lobster Two Bold") {$goofurl_1="Lobster+Two:700";$goofont1="Lobster Two";}
elseif ($goofont1=="Lobster Two Bold Italic") {$goofurl_1="Lobster+Two:700italic";$goofont1="Lobster Two";}
elseif ($goofont1=="Caudex") {$goofurl_1="Caudex";}
elseif ($goofont1=="Jura") {$goofurl_1="Jura";}
elseif ($goofont1=="Ruslan Display") {$goofurl_1="Ruslan+Display";}
elseif ($goofont1=="Brawler") {$goofurl_1="Brawler";}
elseif ($goofont1=="Nunito") {$goofurl_1="Nunito";}
elseif ($goofont1=="Wire One") {$goofurl_1="Wire+One";}
elseif ($goofont1=="Podkova") {$goofurl_1="Podkova";}
elseif ($goofont1=="Muli") {$goofurl_1="Muli";}
elseif ($goofont1=="Maven Pro") {$goofurl_1="Maven+Pro";}
elseif ($goofont1=="Tenor Sans") {$goofurl_1="Tenor+Sans";}
elseif ($goofont1=="Limelight") {$goofurl_1="Limelight";}
elseif ($goofont1=="Playfair Display") {$goofurl_1="Playfair+Display";}
elseif ($goofont1=="Artifika") {$goofurl_1="Artifika";}
elseif ($goofont1=="Lora") {$goofurl_1="Lora";}
elseif ($goofont1=="Kameron") {$goofurl_1="Kameron";}
elseif ($goofont1=="Cedarville Cursive") {$goofurl_1="Cedarville+Cursive";}
elseif ($goofont1=="Zeyada") {$goofurl_1="Zeyada";}
elseif ($goofont1=="La Belle Aurore") {$goofurl_1="La+Belle+Aurore";}
elseif ($goofont1=="Shadows into Light") {$goofurl_1="Shadows+Into+Light";}
elseif ($goofont1=="Shanti") {$goofurl_1="Shanti";}
elseif ($goofont1=="Mako") {$goofurl_1="Mako";}
elseif ($goofont1=="Metrophobic") {$goofurl_1="Metrophobic";}
elseif ($goofont1=="Ultra") {$goofurl_1="Ultra";}
elseif ($goofont1=="Play") {$goofurl_1="Play";}
elseif ($goofont1=="Didact Gothic") {$goofurl_1="Didact+Gothic";}
elseif ($goofont1=="Judson") {$goofurl_1="Judson";}
elseif ($goofont1=="Megrim") {$goofurl_1="Megrim";}
elseif ($goofont1=="Rokkitt") {$goofurl_1="Rokkitt";}
elseif ($goofont1=="Monofett") {$goofurl_1="Monofett";}
elseif ($goofont1=="Paytone One") {$goofurl_1="Paytone+One";}
elseif ($goofont1=="Holtwood One SC") {$goofurl_1="Holtwood+One+SC";}
elseif ($goofont1=="Carter One") {$goofurl_1="Carter+One";}
elseif ($goofont1=="Francois One") {$goofurl_1="Francois+One";}
elseif ($goofont1=="Bigshot One") {$goofurl_1="Bigshot+One";}
elseif ($goofont1=="Sigmar One") {$goofurl_1="Sigmar+One";}
elseif ($goofont1=="Swanky and Moo Moo") {$goofurl_1="Swanky+and+Moo+Moo";}
elseif ($goofont1=="Over the Rainbow") {$goofurl_1="Over+the+Rainbow";}
elseif ($goofont1=="Wallpoet") {$goofurl_1="Wallpoet";}
elseif ($goofont1=="Damion") {$goofurl_1="Damion";}
elseif ($goofont1=="News Cycle") {$goofurl_1="News+Cycle";}
elseif ($goofont1=="Aclonica") {$goofurl_1="Aclonica";}
elseif ($goofont1=="Special Elite") {$goofurl_1="Special+Elite";}
elseif ($goofont1=="Smythe") {$goofurl_1="Smythe";}
elseif ($goofont1=="Quattrocento Sans") {$goofurl_1="Quattrocento+Sans";}
elseif ($goofont1=="The Girl Next Door") {$goofurl_1="The+Girl+Next+Door";}
elseif ($goofont1=="Sue Ellen Francisco") {$goofurl_1="Sue+Ellen+Francisco";}
elseif ($goofont1=="Dawning of a New Day") {$goofurl_1="Dawning+of+a+New+Day";}
elseif ($goofont1=="Waiting for the Sunrise") {$goofurl_1="Waiting+for+the+Sunrise";}
elseif ($goofont1=="Annie Use Your Telescope") {$goofurl_1="Annie+Use+Your+Telescope";}
elseif ($goofont1=="Maiden Orange") {$goofurl_1="Maiden+Orange";}
elseif ($goofont1=="Luckiest Guy") {$goofurl_1="Luckiest+Guy";}
elseif ($goofont1=="Bangers") {$goofurl_1="Bangers";}
elseif ($goofont1=="Miltonian") {$goofurl_1="Miltonian";}
elseif ($goofont1=="Miltonian Tattoo") {$goofurl_1="Miltonian+Tattoo";}
elseif ($goofont1=="Allerta") {$goofurl_1="Allerta";}
elseif ($goofont1=="Allerta Stencil") {$goofurl_1="Allerta+Stencil";}
elseif ($goofont1=="Amaranth") {$goofurl_1="Amaranth";}
elseif ($goofont1=="Anonymous Pro") {$goofurl_1="Anonymous+Pro";}
elseif ($goofont1=="Anonymous Pro Italic") {$goofurl_1="Anonymous+Pro:italic";$goofont1="Anonymous Pro";}
elseif ($goofont1=="Anonymous Pro Bold") {$goofurl_1="Anonymous+Pro:bold";$goofont1="Anonymous Pro";}
elseif ($goofont1=="Anonymous Pro Bold Italic") {$goofurl_1="Anonymous+Pro:bolditalic";$goofont1="Anonymous Pro";}
elseif ($goofont1=="Anton") {$goofurl_1="Anton";}
elseif ($goofont1=="Architects Daughter") {$goofurl_1="Architects+Daughter";}
elseif ($goofont1=="Arimo") {$goofurl_1="Arimo";}
elseif ($goofont1=="Arimo Italic") {$goofurl_1="Arimo:italic";$goofont1="Arimo";}
elseif ($goofont1=="Arimo Bold") {$goofurl_1="Arimo:bold";$goofont1="Arimo";}
elseif ($goofont1=="Arimo Bold Italic") {$goofurl_1="Arimo:bolditalic";$goofont1="Arimo";}
elseif ($goofont1=="Arvo") {$goofurl_1="Arvo"; $goofont1="Arvo";}
elseif ($goofont1=="Arvo Italic") {$goofurl_1="Arvo:italic"; $goofont1="Arvo";}
elseif ($goofont1=="Arvo Bold") {$goofurl_1="Arvo:bold"; $goofont1="Arvo";}
elseif ($goofont1=="Arvo Bold Italic") {$goofurl_1="Arvo:bolditalic"; $goofont1="Arvo";}
elseif ($goofont1=="Astloch") {$goofurl_1="Astloch";}
elseif ($goofont1=="Astloch Bold") {$goofurl_1="Astloch:bold"; $goofont1="Astloch";}
elseif ($goofont1=="Bentham") {$goofurl_1="Bentham";}
elseif ($goofont1=="Bevan") {$goofurl_1="Bevan";}
elseif ($goofont1=="Buda") {$goofurl_1="Buda:light";}
elseif ($goofont1=="Cabin") {$goofurl_1="Cabin:regular";}
elseif ($goofont1=="Cabin Italic") {$goofurl_1="Cabin:regularitalic";$goofont1="Cabin";}
elseif ($goofont1=="Cabin Bold") {$goofurl_1="Cabin:bold";$goofont1="Cabin";}
elseif ($goofont1=="Cabin Bold Italic") {$goofurl_1="Cabin:bolditalic";$goofont1="Cabin";}
elseif ($goofont1=="Cabin Sketch") {$goofurl_1="Cabin+Sketch:bold";}
elseif ($goofont1=="Calligraffitti") {$goofurl_1="Calligraffitti";}
elseif ($goofont1=="Candal") {$goofurl_1="Candal";}
elseif ($goofont1=="Cantarell") {$goofurl_1="Cantarell";}
elseif ($goofont1=="Cantarell Italic") {$goofurl_1="Cantarell:italic";$goofont1="Cantarell";}
elseif ($goofont1=="Cantarell Bold") {$goofurl_1="Cantarell:bold";$goofont1="Cantarell";}
elseif ($goofont1=="Cantarell Bold Italic") {$goofurl_1="Cantarell:bolditalic";$goofont1="Cantarell";}
elseif ($goofont1=="Cardo") {$goofurl_1="Cardo";}
elseif ($goofont1=="Cherry Cream Soda") {$goofurl_1="Cherry+Cream+Soda";}
elseif ($goofont1=="Chewy") {$goofurl_1="Chewy";}
elseif ($goofont1=="Coda") {$goofurl_1="Coda:800";}
elseif ($goofont1=="Coda Caption") {$goofurl_1="Coda+Caption:800";}
elseif ($goofont1=="Coming Soon") {$goofurl_1="Coming+Soon";}
elseif ($goofont1=="Copse") {$goofurl_1="Copse";}
elseif ($goofont1=="Corben") {$goofurl_1="Corben:bold";}
elseif ($goofont1=="Cousine") {$goofurl_1="Cousine";}
elseif ($goofont1=="Cousine Italic") {$goofurl_1="Cousine:italic";$goofont1="Cousine";}
elseif ($goofont1=="Cousine Bold") {$goofurl_1="Cousine:bold";$goofont1="Cousine";}
elseif ($goofont1=="Cousine Bold Italic") {$goofurl_1="Cousine:bolditalic";$goofont1="Cousine";}
elseif ($goofont1=="Covered By Your Grace") {$goofurl_1="Covered+By+Your+Grace";}
elseif ($goofont1=="Crafty Girls") {$goofurl_1="Crafty+Girls";}
elseif ($goofont1=="Crimson Text") {$goofurl_1="Crimson+Text";}
elseif ($goofont1=="Crimson Text Italic") {$goofurl_1="Crimson+Text:italic";$goofont1="Crimson Text";}
elseif ($goofont1=="Crimson Text Bold") {$goofurl_1="Crimson+Text:bold";$goofont1="Crimson Text";}
elseif ($goofont1=="Crimson Text Bold Italic") {$goofurl_1="Crimson+Text:bolditalic";$goofont1="Crimson Text";}
elseif ($goofont1=="Crushed") {$goofurl_1="Crushed";}
elseif ($goofont1=="Cuprum") {$goofurl_1="Cuprum";}
elseif ($goofont1=="Droid Sans") {$goofurl_1="Droid+Sans";}
elseif ($goofont1=="Droid Sans Bold") {$goofurl_1="Droid+Sans:bold"; $goofont1="Droid Sans";}
elseif ($goofont1=="Droid Sans Mono") {$goofurl_1="Droid+Sans+Mono";}
elseif ($goofont1=="Droid Serif") {$goofurl_1="Droid+Serif";}
elseif ($goofont1=="Droid Serif Italic") {$goofurl_1="Droid+Serif:italic";$goofont1="Droid Serif";}
elseif ($goofont1=="Droid Serif Bold") {$goofurl_1="Droid+Serif:bold";$goofont1="Droid Serif";}
elseif ($goofont1=="Droid Serif Bold Italic") {$goofurl_1="Droid+Serif:bolditalic";$goofont1="Droid Serif";}
elseif ($goofont1=="EB Garamond") {$goofurl_1="EB+Garamond";}
elseif ($goofont1=="Expletus Sans") {$goofurl_1="Expletus+Sans";}
elseif ($goofont1=="Expletus Sans Bold") {$goofurl_1="Expletus+Sans:bold";$goofont1="Expletus Sans";}
elseif ($goofont1=="Fontdiner Swanky") {$goofurl_1="Fontdiner+Swanky";}
elseif ($goofont1=="Geo") {$goofurl_1="Geo";}
elseif ($goofont1=="Goudy Bookletter 1911") {$goofurl_1="Goudy+Bookletter+1911";}
elseif ($goofont1=="Gruppo") {$goofurl_1="Gruppo";}
elseif ($goofont1=="Homemade Apple") {$goofurl_1="Homemade+Apple";}
elseif ($goofont1=="IM Fell Double Pica") {$goofurl_1="IM+Fell+Double+Pica";$goofont1="IM Fell Double Pica";}
elseif ($goofont1=="IM Fell Double Pica Italic") {$goofurl_1="IM+Fell+Double+Pica:italic";$goofont1="IM Fell Double Pica";}
elseif ($goofont1=="IM Fell Double Pica SC") {$goofurl_1="IM+Fell+Double+Pica+SC";}
elseif ($goofont1=="IM Fell DW Pica") {$goofurl_1="IM+Fell+DW+Pica";$goofont1="IM Fell DW Pica";}
elseif ($goofont1=="IM Fell DW Pica Italic") {$goofurl_1="IM+Fell+DW+Pica:italic";$goofont1="IM Fell DW Pica";}
elseif ($goofont1=="IM Fell DW Pica SC") {$goofurl_1="IM+Fell+DW+Pica+SC";}
elseif ($goofont1=="IM Fell English") {$goofurl_1="IM+Fell+English";$goofont1="IM Fell English";}
elseif ($goofont1=="IM Fell English Italic") {$goofurl_1="IM+Fell+English:italic";$goofont1="IM Fell English";}
elseif ($goofont1=="IM Fell English SC") {$goofurl_1="IM+Fell+English+SC";}
elseif ($goofont1=="IM Fell French Canon") {$goofurl_1="IM+Fell+French+Canon";$goofont1="IM Fell French Canon";}
elseif ($goofont1=="IM Fell French Canon Italic") {$goofurl_1="IM+Fell+French+Canon:italic";$goofont1="IM Fell French Canon";}
elseif ($goofont1=="IM Fell French Canon SC") {$goofurl_1="IM+Fell+French+Canon+SC";}
elseif ($goofont1=="IM Fell Great Primer") {$goofurl_1="IM+Fell+Great+Primer";$goofont1="IM Fell Great Primer";}
elseif ($goofont1=="IM Fell Great Primer Italic") {$goofurl_1="IM+Fell+Great+Primer:italic";$goofont1="IM Fell Great Primer";}
elseif ($goofont1=="IM Fell Great Primer SC") {$goofurl_1="IM+Fell+Great+Primera+SC";}
elseif ($goofont1=="Inconsolata") {$goofurl_1="Inconsolata";}
elseif ($goofont1=="Indie Flower") {$goofurl_1="Indie+Flower";}
elseif ($goofont1=="Irish Grover") {$goofurl_1="Irish+Grover";}
elseif ($goofont1=="Josefin Sans") {$goofurl_1="Josefin+Sans";}
elseif ($goofont1=="Josefin Sans Italic") {$goofurl_1="Josefin+Sans:regularitalic"; $goofont1="Josefin Sans";}
elseif ($goofont1=="Josefin Sans Bold") {$goofurl_1="Josefin+Sans:bold"; $goofont1="Josefin Sans";}
elseif ($goofont1=="Josefin Sans Bold Italic") {$goofurl_1="Josefin+Sans:bolditalic"; $goofont1="Josefin Sans";}
elseif ($goofont1=="Josefin Slab") {$goofurl_1="Josefin+Slab";}
elseif ($goofont1=="Just Another Hand") {$goofurl_1="Just+Another+Hand";}
elseif ($goofont1=="Just Me Again Down Here") {$goofurl_1="Just+Me+Again+Down+Here";}
elseif ($goofont1=="Kenia") {$goofurl_1="Kenia";}
elseif ($goofont1=="Kranky") {$goofurl_1="Kranky";}
elseif ($goofont1=="Kreon") {$goofurl_1="Kreon";}
elseif ($goofont1=="Kreon Bold") {$goofurl_1="Kreon:bold"; $goofont1="Kreon";}
elseif ($goofont1=="Kristi") {$goofurl_1="Kristi";}
elseif ($goofont1=="Lato") {$goofurl_1="Lato";}
elseif ($goofont1=="Lato Italic") {$goofurl_1="Lato:regularitalic";$goofont1="Lato";}
elseif ($goofont1=="Lato Bold") {$goofurl_1="Lato:bold";$goofont1="Lato";}
elseif ($goofont1=="Lato Bold Italic") {$goofurl_1="Lato:bolditalic";$goofont1="Lato";}
elseif ($goofont1=="League Script") {$goofurl_1="League+Script";}
elseif ($goofont1=="Lekton") {$goofurl_1="Lekton";}
elseif ($goofont1=="Lekton Italic") {$goofurl_1="Lekton:italic"; $goofont1="Lekton";}
elseif ($goofont1=="Lekton Bold") {$goofurl_1="Lekton:bold"; $goofont1="Lekton";}
elseif ($goofont1=="Lobster") {$goofurl_1="Lobster";}
elseif ($goofont1=="MedievalSharp") {$goofurl_1="MedievalSharp";}
elseif ($goofont1=="Merriweather") {$goofurl_1="Merriweather";}
elseif ($goofont1=="Michroma") {$goofurl_1="Michroma";}
elseif ($goofont1=="Molengo") {$goofurl_1="Molengo";}
elseif ($goofont1=="Mountains of Christmas") {$goofurl_1="Mountains+of+Christmas";}
elseif ($goofont1=="Neucha") {$goofurl_1="Neucha";}
elseif ($goofont1=="Neuton") {$goofurl_1="Neuton";}
elseif ($goofont1=="Neuton Italic") {$goofurl_1="Neuton:italic"; $goofont1="Neuton";}
elseif ($goofont1=="Nobile") {$goofurl_1="Nobile";}
elseif ($goofont1=="Nobile Italic") {$goofurl_1="Nobile:italic"; $goofont1="Nobile";}
elseif ($goofont1=="Nobile Bold") {$goofurl_1="Nobile:bold"; $goofont1="Nobile";}
elseif ($goofont1=="Nobile Bold Italic") {$goofurl_1="Nobile:bolditalic"; $goofont1="Nobile";}
elseif ($goofont1=="Nova Round") {$goofurl_1="Nova+Round";}
elseif ($goofont1=="Nova Script") {$goofurl_1="Nova+Script";}
elseif ($goofont1=="Nova Slim") {$goofurl_1="Nova+Slim";}
elseif ($goofont1=="Nova Cut") {$goofurl_1="Nova+Cut";}
elseif ($goofont1=="Nova Oval") {$goofurl_1="Nova+Oval";}
elseif ($goofont1=="Nova Mono") {$goofurl_1="Nova+Mono";}
elseif ($goofont1=="Nova Flat") {$goofurl_1="Nova+Flat";}
elseif ($goofont1=="OFL Sorts Mill Goudy TT") {$goofurl_1="OFL+Sorts+Mill+Goudy+TT";}
elseif ($goofont1=="OFL Sorts Mill Goudy TT Italic") {$goofurl_1="OFL+Sorts+Mill+Goudy+TT:italic";$goofont1="OFL Sorts Mill Goudy TT";}
elseif ($goofont1=="Old Standard TT") {$goofurl_1="Old+Standard+TT";}
elseif ($goofont1=="Old Standard TT Italic") {$goofurl_1="Old+Standard+TT:italic";$goofont1="Old Standard TT";}
elseif ($goofont1=="Old Standard TT Bold") {$goofurl_1="Old+Standard+TT:bold";$goofont1="Old Standard TT";}
elseif ($goofont1=="Orbitron") {$goofurl_1="Orbitron";}
elseif ($goofont1=="Orbitron Italic") {$goofurl_1="Orbitron:italic";$goofont1="Orbitron";}
elseif ($goofont1=="Orbitron Bold") {$goofurl_1="Orbitron:bold";$goofont1="Orbitron";}
elseif ($goofont1=="Orbitron Bold Italic") {$goofurl_1="Orbitron:bolditalic";$goofont1="Orbitron";}
elseif ($goofont1=="Oswald") {$goofurl_1="Oswald";}
elseif ($goofont1=="Pacifico") {$goofurl_1="Pacifico";}
elseif ($goofont1=="Permanent Marker") {$goofurl_1="Permanent+Marker";}
elseif ($goofont1=="PT Sans") {$goofurl_1="PT+Sans";}
elseif ($goofont1=="PT Sans Italic") {$goofurl_1="PT+Sans:italic";}
elseif ($goofont1=="PT Sans Bold") {$goofurl_1="PT+Sans:bold";}
elseif ($goofont1=="PT Sans Bold Italic") {$goofurl_1="PT+Sans:bolditalic";}
elseif ($goofont1=="PT Sans Caption") {$goofurl_1="PT+Sans+Caption";}
elseif ($goofont1=="PT Sans Caption Bold") {$goofurl_1="PT+Sans+Caption:bold"; $goofont1="PT Sans Caption";}
elseif ($goofont1=="PT Sans Narrow") {$goofurl_1="PT+Sans+Narrow";}
elseif ($goofont1=="PT Sans Narrow Bold") {$goofurl_1="PT+Sans+Narrow:bold"; $goofont1="PT Sans Narrow";}
elseif ($goofont1=="PT Serif") {$goofurl_1="PT+Serif";}
elseif ($goofont1=="PT Serif Italic") {$goofurl_1="PT+Serif:italic";$goofont1="PT Serif";}
elseif ($goofont1=="PT Serif Bold") {$goofurl_1="PT+Serif:bold";$goofont1="PT Serif";}
elseif ($goofont1=="PT Serif Bold Italic") {$goofurl_1="PT+Serif:bolditalic";$goofont1="PT Serif";}
elseif ($goofont1=="PT Serif Caption") {$goofurl_1="PT+Serif+Caption";}
elseif ($goofont1=="PT Serif Caption Bold") {$goofurl_1="PT+Serif+Caption+Bold"; $goofont1="PT Serif Caption";}
elseif ($goofont1=="Philosopher") {$goofurl_1="Philosopher";}
elseif ($goofont1=="Puritan") {$goofurl_1="Puritan";}
elseif ($goofont1=="Puritan Italic") {$goofurl_1="Puritan:italic";$goofont1="Puritan";}
elseif ($goofont1=="Puritan Bold") {$goofurl_1="Puritan:bold";$goofont1="Puritan";}
elseif ($goofont1=="Puritan Bold Italic") {$goofurl_1="Puritan:bolditalic";$goofont1="Puritan";}
elseif ($goofont1=="Quattrocento") {$goofurl_1="Quattrocento";}
elseif ($goofont1=="Raleway") {$goofurl_1="Raleway:100";}
elseif ($goofont1=="Reenie Beanie") {$goofurl_1="Reenie+Beanie";}
elseif ($goofont1=="Rock Salt") {$goofurl_1="Rock+Salt";}
elseif ($goofont1=="Schoolbell") {$goofurl_1="Schoolbell";}
elseif ($goofont1=="Slackey") {$goofurl_1="Slackey";}
elseif ($goofont1=="Sniglet") {$goofurl_1="Sniglet:800";}
elseif ($goofont1=="Sunshiney") {$goofurl_1="Sunshiney";}
elseif ($goofont1=="Syncopate") {$goofurl_1="Syncopate";}
elseif ($goofont1=="Tangerine") {$goofurl_1="Tangerine";}
elseif ($goofont1=="Terminal Dosis Light") {$goofurl_1="Terminal Dosis Light";}
elseif ($goofont1=="Tinos") {$goofurl_1="Tinos";}
elseif ($goofont1=="Tinos Italic") {$goofurl_1="Tinos:italic";$goofont1="Tinos";}
elseif ($goofont1=="Tinos Bold") {$goofurl_1="Tinos:bold";$goofont1="Tinos";}
elseif ($goofont1=="Tinos Bold Italic") {$goofurl_1="Tinos:bolditalic";$goofont1="Tinos";}
elseif ($goofont1=="Ubuntu") {$goofurl_1="Ubuntu";}
elseif ($goofont1=="Ubuntu Italic") {$goofurl_1="Ubuntu:italic";$goofont1="Ubuntu";}
elseif ($goofont1=="Ubuntu Bold") {$goofurl_1="Ubuntu:bold";$goofont1="Ubuntu";}
elseif ($goofont1=="Ubuntu Bold Italic") {$goofurl_1="Ubuntu:bolditalic";$goofont1="Ubuntu";}
elseif ($goofont1=="UnifrakturCook") {$goofurl_1="UnifrakturCook:bold";}
elseif ($goofont1=="UnifrakturMaguntia") {$goofurl_1="UnifrakturMaguntia";}
elseif ($goofont1=="Unkempt") {$goofurl_1="Unkempt";}
elseif ($goofont1=="VT323") {$goofurl_1="VT323";}
elseif ($goofont1=="Vibur") {$goofurl_1="Vibur";}
elseif ($goofont1=="Vollkorn") {$goofurl_1="Vollkorn";}
elseif ($goofont1=="Vollkorn Italic") {$goofurl_1="Vollkorn:italic";$goofont1="Vollkorn";}
elseif ($goofont1=="Vollkorn Bold") {$goofurl_1="Vollkorn:bold";$goofont1="Vollkorn";}
elseif ($goofont1=="Vollkorn Bold Italic") {$goofurl_1="Vollkorn:bolditalic";$goofont1="Vollkorn";}
elseif ($goofont1=="Walter Turncoat") {$goofurl_1="Walter+Turncoat";}
elseif ($goofont1=="Yanone Kaffeesatz") {$goofurl_1="Yanone+Kaffeesatz";}
elseif ($goofont1=="Yanone Kaffeesatz Light") {$goofurl_1="Yanone+Kaffeesatz:light";$goofont1="Yanone Kaffeesatz";}
elseif ($goofont1=="Yanone Kaffeesatz Bold") {$goofurl_1="Yanone+Kaffeesatz:bold";$goofont1="Yanone Kaffeesatz";}
else ;


$goofurl_2 = '';
$goofont2 = '';
$goofont2 = $this->params->get( 'font-face-2' );
if ($goofont2=="Allan") {$goofurl_2="Allan:bold";}
elseif ($goofont2=="Exo") {$goofurl_2="Exo:400";$goofont2="Exo";}
elseif ($goofont2=="Exo Italic") {$goofurl_2="Exo:400italic";$goofont2="Exo";}
elseif ($goofont2=="Exo Bold") {$goofurl_2="Exo:700";$goofont2="Exo";}
elseif ($goofont2=="Exo Bold Italic") {$goofurl_2="Exo:700italic";$goofont2="Exo";}
elseif ($goofont2=="Chelsea Market") {$goofurl_2="Chelsea+Market";}
elseif ($goofont2=="Jim Nightmare") {$goofurl_2="Jim+Nightmare";}
elseif ($goofont2=="Oldenburg") {$goofurl_2="Oldenburg";}
elseif ($goofont2=="Spicy Rice") {$goofurl_2="Spicy+Rice";}
elseif ($goofont2=="Nosifer") {$goofurl_2="Nosifer";}
elseif ($goofont2=="Eater") {$goofurl_2="Eater";}
elseif ($goofont2=="Creepster") {$goofurl_2="Creepster";}
elseif ($goofont2=="Butcherman") {$goofurl_2="Butcherman";}
elseif ($goofont2=="Sofia") {$goofurl_2="Sofia";}
elseif ($goofont2=="Asul") {$goofurl_2="Asul";}
elseif ($goofont2=="Alex Brush") {$goofurl_2="Alex+Brush";}
elseif ($goofont2=="Arizonia") {$goofurl_2="Arizonia";}
elseif ($goofont2=="Italianno") {$goofurl_2="Italianno";}
elseif ($goofont2=="Qwigley") {$goofurl_2="Qwigley";}
elseif ($goofont2=="Ruge Boogie") {$goofurl_2="Ruge+Boogie";}
elseif ($goofont2=="Ruthie") {$goofurl_2="Ruthie";}
elseif ($goofont2=="Playball") {$goofurl_2="Playball";}
elseif ($goofont2=="Dynalight") {$goofurl_2="Dynalight";}
elseif ($goofont2=="Stoke") {$goofurl_2="Stoke";}
elseif ($goofont2=="Sarina") {$goofurl_2="Sarina";}
elseif ($goofont2=="Yesteryear") {$goofurl_2="Yesteryear";}
elseif ($goofont2=="Trade Winds") {$goofurl_2="Trade+Winds";}
elseif ($goofont2=="Frijole") {$goofurl_2="Frijole";}
elseif ($goofont2=="Trykker") {$goofurl_2="Trykker";}
elseif ($goofont2=="Sail") {$goofurl_2="Sail";}
elseif ($goofont2=="Quantico") {$goofurl_2="Quantico";}
elseif ($goofont2=="Patua One") {$goofurl_2="Patua+One";}
elseif ($goofont2=="Overlock") {$goofurl_2="Overlock";}
elseif ($goofont2=="Overlock SC") {$goofurl_2="Overlock+SC";}
elseif ($goofont2=="Habibi") {$goofurl_2="Habibi";}
elseif ($goofont2=="Noticia Text") {$goofurl_2="Noticia+Text";}
elseif ($goofont2=="Miniver") {$goofurl_2="Miniver";}
elseif ($goofont2=="Medula One") {$goofurl_2="Medula+One";}
elseif ($goofont2=="Inder") {$goofurl_2="Inder";}
elseif ($goofont2=="Fugaz One") {$goofurl_2="Fugaz+One";}
elseif ($goofont2=="Flavors") {$goofurl_2="Flavors";}
elseif ($goofont2=="Flamenco") {$goofurl_2="Flamenco";}
elseif ($goofont2=="Duru Sans") {$goofurl_2="Duru+Sans";}
elseif ($goofont2=="Crete Round") {$goofurl_2="Crete+Round";}
elseif ($goofont2=="Caesar Dressing") {$goofurl_2="Caesar+Dressing";}
elseif ($goofont2=="Cambo") {$goofurl_2="Cambo";}
elseif ($goofont2=="Bluenard") {$goofurl_2="Bluenard";}
elseif ($goofont2=="Bree Serif") {$goofurl_2="Bree+Serif";}
elseif ($goofont2=="Boogaloo") {$goofurl_2="Boogaloo";}
elseif ($goofont2=="Belgrano") {$goofurl_2="Belgrano";}
elseif ($goofont2=="Armata") {$goofurl_2="Armata";}
elseif ($goofont2=="Alfa Slab One") {$goofurl_2="Alfa+Slab+One";}
elseif ($goofont2=="Uncial Antiqua") {$goofurl_2="Uncial+Antique";}
elseif ($goofont2=="Almendra") {$goofurl_2="Almendra";}
elseif ($goofont2=="Almendra SC") {$goofurl_2="Almendra+SC";}
elseif ($goofont2=="Acme") {$goofurl_2="Acme";}
elseif ($goofont2=="Squada One") {$goofurl_2="Squada+One";}
elseif ($goofont2=="Basic") {$goofurl_2="Basic";}
elseif ($goofont2=="Bilbo Swash Caps") {$goofurl_2="Bilbo+Swash+Caps";}
elseif ($goofont2=="Marko One") {$goofurl_2="Marko+One";}
elseif ($goofont2=="Bad Script") {$goofurl_2="Bad+Script";}
elseif ($goofont2=="Plaster") {$goofurl_2="Plaster";}
elseif ($goofont2=="Handlee") {$goofurl_2="Handlee";}
elseif ($goofont2=="Bathazar") {$goofurl_2="Bathazar";}
elseif ($goofont2=="Passion One") {$goofurl_2="Passion+One";}
elseif ($goofont2=="Chango") {$goofurl_2="Chango";}
elseif ($goofont2=="Enriqueta") {$goofurl_2="Enriqueta";}
elseif ($goofont2=="Montserrat") {$goofurl_2="Montserrat";}
elseif ($goofont2=="Original Surfer") {$goofurl_2="Original+Surfer";}
elseif ($goofont2=="Baumans") {$goofurl_2="Baumans";}
elseif ($goofont2=="Fascinate") {$goofurl_2="Fascinate";}
elseif ($goofont2=="Fascinate Inline") {$goofurl_2="Fascinate+Inline";}
elseif ($goofont2=="Stint Ultra Condensed") {$goofurl_2="Stint+Ultra+Condensed";}
elseif ($goofont2=="Bonbon") {$goofurl_2="Bonbon";}
elseif ($goofont2=="Arbutus") {$goofurl_2="Arbutus";}
elseif ($goofont2=="Galdeano") {$goofurl_2="Galdeano";}
elseif ($goofont2=="Metamorphous") {$goofurl_2="Metamorphous";}
elseif ($goofont2=="Cevivhe One") {$goofurl_2="Cevivhe+One";}
elseif ($goofont2=="Marmelad") {$goofurl_2="Marmelad";}
elseif ($goofont2=="Engagement") {$goofurl_2="Engagement";}
elseif ($goofont2=="Electrolize") {$goofurl_2="Electrolize";}
elseif ($goofont2=="Fresca") {$goofurl_2="Fresca";}
elseif ($goofont2=="Vigo") {$goofurl_2="Vigo";}
elseif ($goofont2=="Bilbo") {$goofurl_2="Bilbo";}
elseif ($goofont2=="Cabin Condensed") {$goofurl_2="Cabin+Condensed";}
elseif ($goofont2=="Dr Sugiyama") {$goofurl_2="Dr+Sugiyama";}
elseif ($goofont2=="Herr Von Muellerhoff") {$goofurl_2="Herr+Von+Muellerhoff";}
elseif ($goofont2=="Miss Fajardose") {$goofurl_2="Miss+Fajardose";}
elseif ($goofont2=="Miss Saint Delafield") {$goofurl_2="Miss+Saint+Delafield";}
elseif ($goofont2=="Monsieur La Doulaise") {$goofurl_2="Monsieur+La+Doulaise";}
elseif ($goofont2=="Mr Bedford") {$goofurl_2="Mr+Bedford";}
elseif ($goofont2=="Mr Dafoe") {$goofurl_2="Mr+Dafoe";}
elseif ($goofont2=="Mr De Gaviland") {$goofurl_2="Mr+De+Gaviland";}
elseif ($goofont2=="Mrs Sheppards") {$goofurl_2="Mrs+Sheppards";}
elseif ($goofont2=="Aguafina Script") {$goofurl_2="Aguafina+Script";}
elseif ($goofont2=="Piedra") {$goofurl_2="Piedra";}
elseif ($goofont2=="Aladin") {$goofurl_2="Aladin";}
elseif ($goofont2=="Chicle") {$goofurl_2="Chicle";}
elseif ($goofont2=="Cagliostro") {$goofurl_2="Cagliostro";}
elseif ($goofont2=="Lemon") {$goofurl_2="Lemon";}
elseif ($goofont2=="Unlock") {$goofurl_2="Unlock";}
elseif ($goofont2=="Signika") {$goofurl_2="Signika";}
elseif ($goofont2=="Signika Negaive") {$goofurl_2="Signika+Negative";}
elseif ($goofont2=="Niconne") {$goofurl_2="Niconne";}
elseif ($goofont2=="Knewave") {$goofurl_2="Knewave";}
elseif ($goofont2=="Righteous") {$goofurl_2="Righteous";}
elseif ($goofont2=="Ribeye") {$goofurl_2="Ribeye";}
elseif ($goofont2=="Ribeye Marrow") {$goofurl_2="Ribeye+Marrow";}
elseif ($goofont2=="Spirax") {$goofurl_2="Spirax";}
elseif ($goofont2=="Concert One") {$goofurl_2="Concert+One";}
elseif ($goofont2=="Bubblegun Sans") {$goofurl_2="Bubblegun+Sans";}
elseif ($goofont2=="Iceland") {$goofurl_2="Iceland";}
elseif ($goofont2=="Devonshire") {$goofurl_2="Devonshire";}
elseif ($goofont2=="Fondamento") {$goofurl_2="Fondamento";}
elseif ($goofont2=="Bitter") {$goofurl_2="Bitter";}
elseif ($goofont2=="Convergence") {$goofurl_2="Convergence";}
elseif ($goofont2=="Lancelot") {$goofurl_2="Lancelot";}
elseif ($goofont2=="Petrona") {$goofurl_2="Petrona";}
elseif ($goofont2=="Supermercado One") {$goofurl_2="Supermercado+One";}
elseif ($goofont2=="Arapey") {$goofurl_2="Arapey";}
elseif ($goofont2=="Mate") {$goofurl_2="Mate";}
elseif ($goofont2=="Mate SC") {$goofurl_2="Mate+SC";}
elseif ($goofont2=="Rammetto One") {$goofurl_2="Rammetto+One";}
elseif ($goofont2=="Fjord One") {$goofurl_2="Fjord+One";}
elseif ($goofont2=="Cabin Sketch") {$goofurl_2="Cabin+Sketch";}
elseif ($goofont2=="Jockey One") {$goofurl_2="Jockey+One";}
elseif ($goofont2=="Contrail One") {$goofurl_2="Contrail+One";}
elseif ($goofont2=="Atomic Age") {$goofurl_2="Atomic+Age";}
elseif ($goofont2=="Corben") {$goofurl_2="Corben";}
elseif ($goofont2=="Linden Hill") {$goofurl_2="Linden+Hill";}
elseif ($goofont2=="Quicksand") {$goofurl_2="Quicksand";}
elseif ($goofont2=="Amatic SC") {$goofurl_2="Amatic+SC";}
elseif ($goofont2=="Salsa") {$goofurl_2="Salsa";}
elseif ($goofont2=="Marck Script") {$goofurl_2="Marck+Script";}
elseif ($goofont2=="Vast Shadow") {$goofurl_2="Vast+Shadow";}
elseif ($goofont2=="Cookie") {$goofurl_2="Cookie";}
elseif ($goofont2=="Pinyon Script") {$goofurl_2="Pinyon+Script";}
elseif ($goofont2=="Satisfy") {$goofurl_2="Satisfy";}
elseif ($goofont2=="Rancho") {$goofurl_2="Rancho";}
elseif ($goofont2=="Coda") {$goofurl_2="Coda";}
elseif ($goofont2=="Sancheek") {$goofurl_2="Sancheek";}
elseif ($goofont2=="Ubunto Mon") {$goofurl_2="Ubunto+Mon";}
elseif ($goofont2=="Unbunto Condensed") {$goofurl_2="Ubunto+Condensed";}
elseif ($goofont2=="Federant") {$goofurl_2="Federant";}
elseif ($goofont2=="Andada") {$goofurl_2="Andada";}
elseif ($goofont2=="Poly") {$goofurl_2="Poly";}
elseif ($goofont2=="Gochi Hand") {$goofurl_2="Gochi+Hand";}
elseif ($goofont2=="Alike Angular") {$goofurl_2="Alike+Angular";}
elseif ($goofont2=="Poller One") {$goofurl_2="Poller+One";}
elseif ($goofont2=="Chivo") {$goofurl_2="Chivo";}
elseif ($goofont2=="Sanista One") {$goofurl_2="Sanista+One";}
elseif ($goofont2=="Terminal Dosis") {$goofurl_2="Terminal+Dosis";}
elseif ($goofont2=="Sorts Mill Goudy") {$goofurl_2="Sorts+Mill+Goudy";}
elseif ($goofont2=="Adamina") {$goofurl_2="Adamina";}
elseif ($goofont2=="Prata") {$goofurl_2="Prata";}
elseif ($goofont2=="Julee") {$goofurl_2="Julee";}
elseif ($goofont2=="Changa One") {$goofurl_2="Changa+One";}
elseif ($goofont2=="Merienda One") {$goofurl_2="Merienda+One";}
elseif ($goofont2=="Prociono") {$goofurl_2="Prociono";}
elseif ($goofont2=="Passero One") {$goofurl_2="Passero+One";}
elseif ($goofont2=="Antic") {$goofurl_2="Antic";}
elseif ($goofont2=="Dorsa") {$goofurl_2="Dorsa";}
elseif ($goofont2=="Abril Fatface") {$goofurl_2="Abril+Fatface";}
elseif ($goofont2=="Delius Unicase") {$goofurl_2="Delius+Unicase";}
elseif ($goofont2=="Alike") {$goofurl_2="Alike";}
elseif ($goofont2=="Monoton") {$goofurl_2="Monoton";}
elseif ($goofont2=="Days One") {$goofurl_2="Days One";}
elseif ($goofont2=="Numans") {$goofurl_2="Numans";}
elseif ($goofont2=="Aldrich") {$goofurl_2="Aldrich";}
elseif ($goofont2=="Vidaloka") {$goofurl_2="Vidaloka";}
elseif ($goofont2=="Short Stack") {$goofurl_2="Short+Stack";}
elseif ($goofont2=="Montez") {$goofurl_2="Montez";}
elseif ($goofont2=="Voltaire") {$goofurl_2="Voltaire";}
elseif ($goofont2=="Geostar Fill") {$goofurl_2="Geostar+Fill";}
elseif ($goofont2=="Geostar") {$goofurl_2="Geostar";}
elseif ($goofont2=="Questrial") {$goofurl_2="Questrial";}
elseif ($goofont2=="Alice") {$goofurl_2="Alice";}
elseif ($goofont2=="Andika") {$goofurl_2="Andika";}
elseif ($goofont2=="Tulpen One") {$goofurl_2="Tulpen+One";}
elseif ($goofont2=="Smokum") {$goofurl_2="Smokum";}
elseif ($goofont2=="Delius Swash Caps") {$goofurl_2="Delius+Swash+Caps";}
elseif ($goofont2=="Actor") {$goofurl_2="Actor";}
elseif ($goofont2=="Abel") {$goofurl_2="Abel";}
elseif ($goofont2=="Rationale") {$goofurl_2="Rationale";}
elseif ($goofont2=="Rochester") {$goofurl_2="Rochester";}
elseif ($goofont2=="Delius") {$goofurl_2="Delius";}
elseif ($goofont2=="Federo") {$goofurl_2="Federo";}
elseif ($goofont2=="Aubrey") {$goofurl_2="Aubrey";}
elseif ($goofont2=="Carme") {$goofurl_2="Carme";}
elseif ($goofont2=="Black Ops One") {$goofurl_2="Black+Ops+One";}
elseif ($goofont2=="Kelly Slab") {$goofurl_2="Kelly+Slab";}
elseif ($goofont2=="Gloria Hallelujah") {$goofurl_2="Gloria+Hallelujah";}
elseif ($goofont2=="Ovo") {$goofurl_2="Ovo";}
elseif ($goofont2=="Snippet") {$goofurl_2="Snippet";}
elseif ($goofont2=="Leckerli One") {$goofurl_2="Leckerli+One";}
elseif ($goofont2=="Rosario") {$goofurl_2="Rosario";}
elseif ($goofont2=="Unna") {$goofurl_2="Unna";}
elseif ($goofont2=="Pompiere") {$goofurl_2="Pompiere";}
elseif ($goofont2=="Yellowtail") {$goofurl_2="Yellowtail";}
elseif ($goofont2=="Modern Antiqua") {$goofurl_2="Modern+Antiqua";}
elseif ($goofont2=="Give You Glory") {$goofurl_2="Give+You+Glory";}
elseif ($goofont2=="Yeseva One") {$goofurl_2="Yeseva+One";}
elseif ($goofont2=="Varela Round") {$goofurl_2="Varela+Round";}
elseif ($goofont2=="Patrick Hand") {$goofurl_2="Patrick+Hand";}
elseif ($goofont2=="Forum") {$goofurl_2="Forum";}
elseif ($goofont2=="Bowlby One") {$goofurl_2="Bowlby+One";}
elseif ($goofont2=="Bowlby One SC") {$goofurl_2="Bowlby+One+SC";}
elseif ($goofont2=="Loved by the King") {$goofurl_2="Loved+by+the+King";}
elseif ($goofont2=="Love Ya Like A Sister") {$goofurl_2="Love+Ya+Like+A+Sister";}
elseif ($goofont2=="Stardos Stencil") {$goofurl_2="Stardos+Stencil";}
elseif ($goofont2=="Hammersmith One") {$goofurl_2="Hammersmith+One";}
elseif ($goofont2=="Gravitas One") {$goofurl_2="Gravitas+One";}
elseif ($goofont2=="Asset") {$goofurl_2="Asset";}
elseif ($goofont2=="Goblin One") {$goofurl_2="Goblin+One";}
elseif ($goofont2=="Varela") {$goofurl_2="Varela";}
elseif ($goofont2=="Fanwood Text") {$goofurl_2="Fanwood+Text";$goofont2="Fanwood Text";}
elseif ($goofont2=="Fanwood Text") {$goofurl_2="Fanwood+Text:400italic";$goofont2="Fanwood Text";}
elseif ($goofont2=="Gentium Basic") {$goofurl_2="Gentium+Basic";$goofont2="Gentium Basic";}
elseif ($goofont2=="Gentium Basic Italic") {$goofurl_2="Gentium+Basic:400italic";$goofont2="Gentium Basic";}
elseif ($goofont2=="Gentium Basic Bold") {$goofurl_2="Gentium+Basic:700";$goofont2="Gentium Basic";}
elseif ($goofont2=="Gentium Basic Bold Italic") {$goofurl_2="Gentium+Basic:700italic";$goofont2="Gentium Basic";}
elseif ($goofont2=="Gentium Book Basic") {$goofurl_2="Gentium+Book+Basic";$goofont2="Gentium Book Basic";}
elseif ($goofont2=="Gentium Book Basic Italic") {$goofurl_2="Gentium+Book+Basic:400italic";$goofont2="Gentium Book Basic";}
elseif ($goofont2=="Gentium Book Basic Bold") {$goofurl_2="Gentium+Book+Basic:700";$goofont2="Gentium Book Basic";}
elseif ($goofont2=="Gentium Book Basic Bold Italic") {$goofurl_2="Gentium+Book+Basic:700italic";$goofont2="Gentium Book Basic";}
elseif ($goofont2=="Volkhov") {$goofurl_2="Volkhov";$goofont2="Volkhov";}
elseif ($goofont2=="Volkhov Italic") {$goofurl_2="Volkhov:400italic";$goofont2="Volkhov";}
elseif ($goofont2=="Volkhov Bold") {$goofurl_2="Volkhov:700";$goofont2="Volkhov";}
elseif ($goofont2=="Volkhov Bold Italic") {$goofurl_2="Volkhov:700italic";$goofont2="Volkhov";}
elseif ($goofont2=="Comfortaa Book") {$goofurl_2="Comfortaa:300";$goofont2="Comfortaa";}
elseif ($goofont2=="Comfortaa Normal") {$goofurl_2="Comfortaa";$goofont2="Comfortaa";}
elseif ($goofont2=="Comfortaa Bold") {$goofurl_2="Comfortaa:700";$goofont2="Comfortaa";}
elseif ($goofont2=="Coustard") {$goofurl_2="Coustard";$goofont2="Coustard";}
elseif ($goofont2=="Coustard Ultra Bold") {$goofurl_2="Coustard:900";$goofont2="Coustard";}
elseif ($goofont2=="Marvel") {$goofurl_2="Marvel";$goofont2="Marvel";}
elseif ($goofont2=="Marvel Italic") {$goofurl_2="Marvel:400italic";$goofont2="Marvel";}
elseif ($goofont2=="Marvel Bold") {$goofurl_2="Marvel:700";$goofont2="Marvel";}
elseif ($goofont2=="Marvel Bold Italic") {$goofurl_2="Marvel:700italic";$goofont2="Marvel";}
elseif ($goofont2=="Istok Web") {$goofurl_2="Istok+Web";$goofont2="Istok Web";}
elseif ($goofont2=="Istok Web Italic") {$goofurl_2="Istok+Web:400italic";$goofont2="Istok Web";}
elseif ($goofont2=="Istok Web Bold") {$goofurl_2="Istok+Web:700";$goofont2="Istok Web";}
elseif ($goofont2=="Istok Web Bold Italic") {$goofurl_2="Istok+Web:700italic";$goofont2="Istok Web";}
elseif ($goofont2=="Tienne") {$goofurl_2="Tienne";$goofont2="Tienne";}
elseif ($goofont2=="Tienne Bold") {$goofurl_2="Tienne:700";$goofont2="Tienne";}
elseif ($goofont2=="Tienne Ultra Bold") {$goofurl_2="Tienne:900";$goofont2="Tienne";}
elseif ($goofont2=="Nixie One") {$goofurl_2="Nixie+One";}
elseif ($goofont2=="Redressed") {$goofurl_2="Redressed";}
elseif ($goofont2=="Lobster Two") {$goofurl_2="Lobster+Two";$goofont2="Lobster Two";}
elseif ($goofont2=="Lobster Two Italic") {$goofurl_2="Lobster+Two:400italic";$goofont2="Lobster Two";}
elseif ($goofont2=="Lobster Two Bold") {$goofurl_2="Lobster+Two:700";$goofont2="Lobster Two";}
elseif ($goofont2=="Lobster Two Bold Italic") {$goofurl_2="Lobster+Two:700italic";$goofont2="Lobster Two";}
elseif ($goofont2=="Caudex") {$goofurl_2="Caudex";}
elseif ($goofont2=="Jura") {$goofurl_2="Jura";}
elseif ($goofont2=="Ruslan Display") {$goofurl_2="Ruslan+Display";}
elseif ($goofont2=="Brawler") {$goofurl_2="Brawler";}
elseif ($goofont2=="Nunito") {$goofurl_2="Nunito";}
elseif ($goofont2=="Wire One") {$goofurl_2="Wire+One";}
elseif ($goofont2=="Podkova") {$goofurl_2="Podkova";}
elseif ($goofont2=="Muli") {$goofurl_2="Muli";}
elseif ($goofont2=="Maven Pro") {$goofurl_2="Maven+Pro";}
elseif ($goofont2=="Tenor Sans") {$goofurl_2="Tenor+Sans";}
elseif ($goofont2=="Limelight") {$goofurl_2="Limelight";}
elseif ($goofont2=="Playfair Display") {$goofurl_2="Playfair+Display";}
elseif ($goofont2=="Artifika") {$goofurl_2="Artifika";}
elseif ($goofont2=="Lora") {$goofurl_2="Lora";}
elseif ($goofont2=="Kameron") {$goofurl_2="Kameron";}
elseif ($goofont2=="Cedarville Cursive") {$goofurl_2="Cedarville+Cursive";}
elseif ($goofont2=="Zeyada") {$goofurl_2="Zeyada";}
elseif ($goofont2=="La Belle Aurore") {$goofurl_2="La+Belle+Aurore";}
elseif ($goofont2=="Shadows into Light") {$goofurl_2="Shadows+Into+Light";}
elseif ($goofont2=="Shanti") {$goofurl_2="Shanti";}
elseif ($goofont2=="Mako") {$goofurl_2="Mako";}
elseif ($goofont2=="Metrophobic") {$goofurl_2="Metrophobic";}
elseif ($goofont2=="Ultra") {$goofurl_2="Ultra";}
elseif ($goofont2=="Play") {$goofurl_2="Play";}
elseif ($goofont2=="Didact Gothic") {$goofurl_2="Didact+Gothic";}
elseif ($goofont2=="Judson") {$goofurl_2="Judson";}
elseif ($goofont2=="Megrim") {$goofurl_2="Megrim";}
elseif ($goofont2=="Rokkitt") {$goofurl_2="Rokkitt";}
elseif ($goofont2=="Monofett") {$goofurl_2="Monofett";}
elseif ($goofont2=="Paytone One") {$goofurl_2="Paytone+One";}
elseif ($goofont2=="Holtwood One SC") {$goofurl_2="Holtwood+One+SC";}
elseif ($goofont2=="Carter One") {$goofurl_2="Carter+One";}
elseif ($goofont2=="Francois One") {$goofurl_2="Francois+One";}
elseif ($goofont2=="Bigshot One") {$goofurl_2="Bigshot+One";}
elseif ($goofont2=="Sigmar One") {$goofurl_2="Sigmar+One";}
elseif ($goofont2=="Swanky and Moo Moo") {$goofurl_2="Swanky+and+Moo+Moo";}
elseif ($goofont2=="Over the Rainbow") {$goofurl_2="Over+the+Rainbow";}
elseif ($goofont2=="Wallpoet") {$goofurl_2="Wallpoet";}
elseif ($goofont2=="Damion") {$goofurl_2="Damion";}
elseif ($goofont2=="News Cycle") {$goofurl_2="News+Cycle";}
elseif ($goofont2=="Aclonica") {$goofurl_2="Aclonica";}
elseif ($goofont2=="Special Elite") {$goofurl_2="Special+Elite";}
elseif ($goofont2=="Smythe") {$goofurl_2="Smythe";}
elseif ($goofont2=="Quattrocento Sans") {$goofurl_2="Quattrocento+Sans";}
elseif ($goofont2=="The Girl Next Door") {$goofurl_2="The+Girl+Next+Door";}
elseif ($goofont2=="Sue Ellen Francisco") {$goofurl_2="Sue+Ellen+Francisco";}
elseif ($goofont2=="Dawning of a New Day") {$goofurl_2="Dawning+of+a+New+Day";}
elseif ($goofont2=="Waiting for the Sunrise") {$goofurl_2="Waiting+for+the+Sunrise";}
elseif ($goofont2=="Annie Use Your Telescope") {$goofurl_2="Annie+Use+Your+Telescope";}
elseif ($goofont2=="Maiden Orange") {$goofurl_2="Maiden+Orange";}
elseif ($goofont2=="Luckiest Guy") {$goofurl_2="Luckiest+Guy";}
elseif ($goofont2=="Bangers") {$goofurl_2="Bangers";}
elseif ($goofont2=="Miltonian") {$goofurl_2="Miltonian";}
elseif ($goofont2=="Miltonian Tattoo") {$goofurl_2="Miltonian+Tattoo";}
elseif ($goofont2=="Allerta") {$goofurl_2="Allerta";}
elseif ($goofont2=="Allerta Stencil") {$goofurl_2="Allerta+Stencil";}
elseif ($goofont2=="Amaranth") {$goofurl_2="Amaranth";}
elseif ($goofont2=="Anonymous Pro") {$goofurl_2="Anonymous+Pro";}
elseif ($goofont2=="Anonymous Pro Italic") {$goofurl_2="Anonymous+Pro:italic";$goofont2="Anonymous Pro";}
elseif ($goofont2=="Anonymous Pro Bold") {$goofurl_2="Anonymous+Pro:bold";$goofont2="Anonymous Pro";}
elseif ($goofont2=="Anonymous Pro Bold Italic") {$goofurl_2="Anonymous+Pro:bolditalic";$goofont2="Anonymous Pro";}
elseif ($goofont2=="Anton") {$goofurl_2="Anton";}
elseif ($goofont2=="Architects Daughter") {$goofurl_2="Architects+Daughter";}
elseif ($goofont2=="Arimo") {$goofurl_2="Arimo";}
elseif ($goofont2=="Arimo Italic") {$goofurl_2="Arimo:italic";$goofont2="Arimo";}
elseif ($goofont2=="Arimo Bold") {$goofurl_2="Arimo:bold";$goofont2="Arimo";}
elseif ($goofont2=="Arimo Bold Italic") {$goofurl_2="Arimo:bolditalic";$goofont2="Arimo";}
elseif ($goofont2=="Arvo") {$goofurl_2="Arvo"; $goofont2="Arvo";}
elseif ($goofont2=="Arvo Italic") {$goofurl_2="Arvo:italic"; $goofont2="Arvo";}
elseif ($goofont2=="Arvo Bold") {$goofurl_2="Arvo:bold"; $goofont2="Arvo";}
elseif ($goofont2=="Arvo Bold Italic") {$goofurl_2="Arvo:bolditalic"; $goofont2="Arvo";}
elseif ($goofont2=="Astloch") {$goofurl_2="Astloch";}
elseif ($goofont2=="Astloch Bold") {$goofurl_2="Astloch:bold"; $goofont2="Astloch";}
elseif ($goofont2=="Bentham") {$goofurl_2="Bentham";}
elseif ($goofont2=="Bevan") {$goofurl_2="Bevan";}
elseif ($goofont2=="Buda") {$goofurl_2="Buda:light";}
elseif ($goofont2=="Cabin") {$goofurl_2="Cabin:regular";}
elseif ($goofont2=="Cabin Italic") {$goofurl_2="Cabin:regularitalic";$goofont2="Cabin";}
elseif ($goofont2=="Cabin Bold") {$goofurl_2="Cabin:bold";$goofont2="Cabin";}
elseif ($goofont2=="Cabin Bold Italic") {$goofurl_2="Cabin:bolditalic";$goofont2="Cabin";}
elseif ($goofont2=="Cabin Sketch") {$goofurl_2="Cabin+Sketch:bold";}
elseif ($goofont2=="Calligraffitti") {$goofurl_2="Calligraffitti";}
elseif ($goofont2=="Candal") {$goofurl_2="Candal";}
elseif ($goofont2=="Cantarell") {$goofurl_2="Cantarell";}
elseif ($goofont2=="Cantarell Italic") {$goofurl_2="Cantarell:italic";$goofont2="Cantarell";}
elseif ($goofont2=="Cantarell Bold") {$goofurl_2="Cantarell:bold";$goofont2="Cantarell";}
elseif ($goofont2=="Cantarell Bold Italic") {$goofurl_2="Cantarell:bolditalic";$goofont2="Cantarell";}
elseif ($goofont2=="Cardo") {$goofurl_2="Cardo";}
elseif ($goofont2=="Cherry Cream Soda") {$goofurl_2="Cherry+Cream+Soda";}
elseif ($goofont2=="Chewy") {$goofurl_2="Chewy";}
elseif ($goofont2=="Coda") {$goofurl_2="Coda:800";}
elseif ($goofont2=="Coda Caption") {$goofurl_2="Coda+Caption:800";}
elseif ($goofont2=="Coming Soon") {$goofurl_2="Coming+Soon";}
elseif ($goofont2=="Copse") {$goofurl_2="Copse";}
elseif ($goofont2=="Corben") {$goofurl_2="Corben:bold";}
elseif ($goofont2=="Cousine") {$goofurl_2="Cousine";}
elseif ($goofont2=="Cousine Italic") {$goofurl_2="Cousine:italic";$goofont2="Cousine";}
elseif ($goofont2=="Cousine Bold") {$goofurl_2="Cousine:bold";$goofont2="Cousine";}
elseif ($goofont2=="Cousine Bold Italic") {$goofurl_2="Cousine:bolditalic";$goofont2="Cousine";}
elseif ($goofont2=="Covered By Your Grace") {$goofurl_2="Covered+By+Your+Grace";}
elseif ($goofont2=="Crafty Girls") {$goofurl_2="Crafty+Girls";}
elseif ($goofont2=="Crimson Text") {$goofurl_2="Crimson+Text";}
elseif ($goofont2=="Crimson Text Italic") {$goofurl_2="Crimson+Text:italic";$goofont2="Crimson Text";}
elseif ($goofont2=="Crimson Text Bold") {$goofurl_2="Crimson+Text:bold";$goofont2="Crimson Text";}
elseif ($goofont2=="Crimson Text Bold Italic") {$goofurl_2="Crimson+Text:bolditalic";$goofont2="Crimson Text";}
elseif ($goofont2=="Crushed") {$goofurl_2="Crushed";}
elseif ($goofont2=="Cuprum") {$goofurl_2="Cuprum";}
elseif ($goofont2=="Droid Sans") {$goofurl_2="Droid+Sans";}
elseif ($goofont2=="Droid Sans Bold") {$goofurl_2="Droid+Sans:bold"; $goofont2="Droid Sans";}
elseif ($goofont2=="Droid Sans Mono") {$goofurl_2="Droid+Sans+Mono";}
elseif ($goofont2=="Droid Serif") {$goofurl_2="Droid+Serif";}
elseif ($goofont2=="Droid Serif Italic") {$goofurl_2="Droid+Serif:italic";$goofont2="Droid Serif";}
elseif ($goofont2=="Droid Serif Bold") {$goofurl_2="Droid+Serif:bold";$goofont2="Droid Serif";}
elseif ($goofont2=="Droid Serif Bold Italic") {$goofurl_2="Droid+Serif:bolditalic";$goofont2="Droid Serif";}
elseif ($goofont2=="EB Garamond") {$goofurl_2="EB+Garamond";}
elseif ($goofont2=="Expletus Sans") {$goofurl_2="Expletus+Sans";}
elseif ($goofont2=="Expletus Sans Bold") {$goofurl_2="Expletus+Sans:bold";$goofont2="Expletus Sans";}
elseif ($goofont2=="Fontdiner Swanky") {$goofurl_2="Fontdiner+Swanky";}
elseif ($goofont2=="Geo") {$goofurl_2="Geo";}
elseif ($goofont2=="Goudy Bookletter 1911") {$goofurl_2="Goudy+Bookletter+1911";}
elseif ($goofont2=="Gruppo") {$goofurl_2="Gruppo";}
elseif ($goofont2=="Homemade Apple") {$goofurl_2="Homemade+Apple";}
elseif ($goofont2=="IM Fell Double Pica") {$goofurl_2="IM+Fell+Double+Pica";$goofont2="IM Fell Double Pica";}
elseif ($goofont2=="IM Fell Double Pica Italic") {$goofurl_2="IM+Fell+Double+Pica:italic";$goofont2="IM Fell Double Pica";}
elseif ($goofont2=="IM Fell Double Pica SC") {$goofurl_2="IM+Fell+Double+Pica+SC";}
elseif ($goofont2=="IM Fell DW Pica") {$goofurl_2="IM+Fell+DW+Pica";$goofont2="IM Fell DW Pica";}
elseif ($goofont2=="IM Fell DW Pica Italic") {$goofurl_2="IM+Fell+DW+Pica:italic";$goofont2="IM Fell DW Pica";}
elseif ($goofont2=="IM Fell DW Pica SC") {$goofurl_2="IM+Fell+DW+Pica+SC";}
elseif ($goofont2=="IM Fell English") {$goofurl_2="IM+Fell+English";$goofont2="IM Fell English";}
elseif ($goofont2=="IM Fell English Italic") {$goofurl_2="IM+Fell+English:italic";$goofont2="IM Fell English";}
elseif ($goofont2=="IM Fell English SC") {$goofurl_2="IM+Fell+English+SC";}
elseif ($goofont2=="IM Fell French Canon") {$goofurl_2="IM+Fell+French+Canon";$goofont2="IM Fell French Canon";}
elseif ($goofont2=="IM Fell French Canon Italic") {$goofurl_2="IM+Fell+French+Canon:italic";$goofont2="IM Fell French Canon";}
elseif ($goofont2=="IM Fell French Canon SC") {$goofurl_2="IM+Fell+French+Canon+SC";}
elseif ($goofont2=="IM Fell Great Primer") {$goofurl_2="IM+Fell+Great+Primer";$goofont2="IM Fell Great Primer";}
elseif ($goofont2=="IM Fell Great Primer Italic") {$goofurl_2="IM+Fell+Great+Primer:italic";$goofont2="IM Fell Great Primer";}
elseif ($goofont2=="IM Fell Great Primer SC") {$goofurl_2="IM+Fell+Great+Primera+SC";}
elseif ($goofont2=="Inconsolata") {$goofurl_2="Inconsolata";}
elseif ($goofont2=="Indie Flower") {$goofurl_2="Indie+Flower";}
elseif ($goofont2=="Irish Grover") {$goofurl_2="Irish+Grover";}
elseif ($goofont2=="Josefin Sans") {$goofurl_2="Josefin+Sans";}
elseif ($goofont2=="Josefin Sans Italic") {$goofurl_2="Josefin+Sans:regularitalic"; $goofont2="Josefin Sans";}
elseif ($goofont2=="Josefin Sans Bold") {$goofurl_2="Josefin+Sans:bold"; $goofont2="Josefin Sans";}
elseif ($goofont2=="Josefin Sans Bold Italic") {$goofurl_2="Josefin+Sans:bolditalic"; $goofont2="Josefin Sans";}
elseif ($goofont2=="Josefin Slab") {$goofurl_2="Josefin+Slab";}
elseif ($goofont2=="Just Another Hand") {$goofurl_2="Just+Another+Hand";}
elseif ($goofont2=="Just Me Again Down Here") {$goofurl_2="Just+Me+Again+Down+Here";}
elseif ($goofont2=="Kenia") {$goofurl_2="Kenia";}
elseif ($goofont2=="Kranky") {$goofurl_2="Kranky";}
elseif ($goofont2=="Kreon") {$goofurl_2="Kreon";}
elseif ($goofont2=="Kreon Bold") {$goofurl_2="Kreon:bold"; $goofont2="Kreon";}
elseif ($goofont2=="Kristi") {$goofurl_2="Kristi";}
elseif ($goofont2=="Lato") {$goofurl_2="Lato";}
elseif ($goofont2=="Lato Italic") {$goofurl_2="Lato:regularitalic";$goofont2="Lato";}
elseif ($goofont2=="Lato Bold") {$goofurl_2="Lato:bold";$goofont2="Lato";}
elseif ($goofont2=="Lato Bold Italic") {$goofurl_2="Lato:bolditalic";$goofont2="Lato";}
elseif ($goofont2=="League Script") {$goofurl_2="League+Script";}
elseif ($goofont2=="Lekton") {$goofurl_2="Lekton";}
elseif ($goofont2=="Lekton Italic") {$goofurl_2="Lekton:italic"; $goofont2="Lekton";}
elseif ($goofont2=="Lekton Bold") {$goofurl_2="Lekton:bold"; $goofont2="Lekton";}
elseif ($goofont2=="Lobster") {$goofurl_2="Lobster";}
elseif ($goofont2=="MedievalSharp") {$goofurl_2="MedievalSharp";}
elseif ($goofont2=="Merriweather") {$goofurl_2="Merriweather";}
elseif ($goofont2=="Michroma") {$goofurl_2="Michroma";}
elseif ($goofont2=="Molengo") {$goofurl_2="Molengo";}
elseif ($goofont2=="Mountains of Christmas") {$goofurl_2="Mountains+of+Christmas";}
elseif ($goofont2=="Neucha") {$goofurl_2="Neucha";}
elseif ($goofont2=="Neuton") {$goofurl_2="Neuton";}
elseif ($goofont2=="Neuton Italic") {$goofurl_2="Neuton:italic"; $goofont2="Neuton";}
elseif ($goofont2=="Nobile") {$goofurl_2="Nobile";}
elseif ($goofont2=="Nobile Italic") {$goofurl_2="Nobile:italic"; $goofont2="Nobile";}
elseif ($goofont2=="Nobile Bold") {$goofurl_2="Nobile:bold"; $goofont2="Nobile";}
elseif ($goofont2=="Nobile Bold Italic") {$goofurl_2="Nobile:bolditalic"; $goofont2="Nobile";}
elseif ($goofont2=="Nova Round") {$goofurl_2="Nova+Round";}
elseif ($goofont2=="Nova Script") {$goofurl_2="Nova+Script";}
elseif ($goofont2=="Nova Slim") {$goofurl_2="Nova+Slim";}
elseif ($goofont2=="Nova Cut") {$goofurl_2="Nova+Cut";}
elseif ($goofont2=="Nova Oval") {$goofurl_2="Nova+Oval";}
elseif ($goofont2=="Nova Mono") {$goofurl_2="Nova+Mono";}
elseif ($goofont2=="Nova Flat") {$goofurl_2="Nova+Flat";}
elseif ($goofont2=="OFL Sorts Mill Goudy TT") {$goofurl_2="OFL+Sorts+Mill+Goudy+TT";}
elseif ($goofont2=="OFL Sorts Mill Goudy TT Italic") {$goofurl_2="OFL+Sorts+Mill+Goudy+TT:italic";$goofont2="OFL Sorts Mill Goudy TT";}
elseif ($goofont2=="Old Standard TT") {$goofurl_2="Old+Standard+TT";}
elseif ($goofont2=="Old Standard TT Italic") {$goofurl_2="Old+Standard+TT:italic";$goofont2="Old Standard TT";}
elseif ($goofont2=="Old Standard TT Bold") {$goofurl_2="Old+Standard+TT:bold";$goofont2="Old Standard TT";}
elseif ($goofont2=="Orbitron") {$goofurl_2="Orbitron";}
elseif ($goofont2=="Orbitron Italic") {$goofurl_2="Orbitron:italic";$goofont2="Orbitron";}
elseif ($goofont2=="Orbitron Bold") {$goofurl_2="Orbitron:bold";$goofont2="Orbitron";}
elseif ($goofont2=="Orbitron Bold Italic") {$goofurl_2="Orbitron:bolditalic";$goofont2="Orbitron";}
elseif ($goofont2=="Oswald") {$goofurl_2="Oswald";}
elseif ($goofont2=="Pacifico") {$goofurl_2="Pacifico";}
elseif ($goofont2=="Permanent Marker") {$goofurl_2="Permanent+Marker";}
elseif ($goofont2=="PT Sans") {$goofurl_2="PT+Sans";}
elseif ($goofont2=="PT Sans Italic") {$goofurl_2="PT+Sans:italic";}
elseif ($goofont2=="PT Sans Bold") {$goofurl_2="PT+Sans:bold";}
elseif ($goofont2=="PT Sans Bold Italic") {$goofurl_2="PT+Sans:bolditalic";}
elseif ($goofont2=="PT Sans Caption") {$goofurl_2="PT+Sans+Caption";}
elseif ($goofont2=="PT Sans Caption Bold") {$goofurl_2="PT+Sans+Caption:bold"; $goofont2="PT Sans Caption";}
elseif ($goofont2=="PT Sans Narrow") {$goofurl_2="PT+Sans+Narrow";}
elseif ($goofont2=="PT Sans Narrow Bold") {$goofurl_2="PT+Sans+Narrow:bold"; $goofont2="PT Sans Narrow";}
elseif ($goofont2=="PT Serif") {$goofurl_2="PT+Serif";}
elseif ($goofont2=="PT Serif Italic") {$goofurl_2="PT+Serif:italic";$goofont2="PT Serif";}
elseif ($goofont2=="PT Serif Bold") {$goofurl_2="PT+Serif:bold";$goofont2="PT Serif";}
elseif ($goofont2=="PT Serif Bold Italic") {$goofurl_2="PT+Serif:bolditalic";$goofont2="PT Serif";}
elseif ($goofont2=="PT Serif Caption") {$goofurl_2="PT+Serif+Caption";}
elseif ($goofont2=="PT Serif Caption Bold") {$goofurl_2="PT+Serif+Caption+Bold"; $goofont2="PT Serif Caption";}
elseif ($goofont2=="Philosopher") {$goofurl_2="Philosopher";}
elseif ($goofont2=="Puritan") {$goofurl_2="Puritan";}
elseif ($goofont2=="Puritan Italic") {$goofurl_2="Puritan:italic";$goofont2="Puritan";}
elseif ($goofont2=="Puritan Bold") {$goofurl_2="Puritan:bold";$goofont2="Puritan";}
elseif ($goofont2=="Puritan Bold Italic") {$goofurl_2="Puritan:bolditalic";$goofont2="Puritan";}
elseif ($goofont2=="Quattrocento") {$goofurl_2="Quattrocento";}
elseif ($goofont2=="Raleway") {$goofurl_2="Raleway:100";}
elseif ($goofont2=="Reenie Beanie") {$goofurl_2="Reenie+Beanie";}
elseif ($goofont2=="Rock Salt") {$goofurl_2="Rock+Salt";}
elseif ($goofont2=="Schoolbell") {$goofurl_2="Schoolbell";}
elseif ($goofont2=="Slackey") {$goofurl_2="Slackey";}
elseif ($goofont2=="Sniglet") {$goofurl_2="Sniglet:800";}
elseif ($goofont2=="Sunshiney") {$goofurl_2="Sunshiney";}
elseif ($goofont2=="Syncopate") {$goofurl_2="Syncopate";}
elseif ($goofont2=="Tangerine") {$goofurl_2="Tangerine";}
elseif ($goofont2=="Terminal Dosis Light") {$goofurl_2="Terminal Dosis Light";}
elseif ($goofont2=="Tinos") {$goofurl_2="Tinos";}
elseif ($goofont2=="Tinos Italic") {$goofurl_2="Tinos:italic";$goofont2="Tinos";}
elseif ($goofont2=="Tinos Bold") {$goofurl_2="Tinos:bold";$goofont2="Tinos";}
elseif ($goofont2=="Tinos Bold Italic") {$goofurl_2="Tinos:bolditalic";$goofont2="Tinos";}
elseif ($goofont2=="Ubuntu") {$goofurl_2="Ubuntu";}
elseif ($goofont2=="Ubuntu Italic") {$goofurl_2="Ubuntu:italic";$goofont2="Ubuntu";}
elseif ($goofont2=="Ubuntu Bold") {$goofurl_2="Ubuntu:bold";$goofont2="Ubuntu";}
elseif ($goofont2=="Ubuntu Bold Italic") {$goofurl_2="Ubuntu:bolditalic";$goofont2="Ubuntu";}
elseif ($goofont2=="UnifrakturCook") {$goofurl_2="UnifrakturCook:bold";}
elseif ($goofont2=="UnifrakturMaguntia") {$goofurl_2="UnifrakturMaguntia";}
elseif ($goofont2=="Unkempt") {$goofurl_2="Unkempt";}
elseif ($goofont2=="VT323") {$goofurl_2="VT323";}
elseif ($goofont2=="Vibur") {$goofurl_2="Vibur";}
elseif ($goofont2=="Vollkorn") {$goofurl_2="Vollkorn";}
elseif ($goofont2=="Vollkorn Italic") {$goofurl_2="Vollkorn:italic";$goofont2="Vollkorn";}
elseif ($goofont2=="Vollkorn Bold") {$goofurl_2="Vollkorn:bold";$goofont2="Vollkorn";}
elseif ($goofont2=="Vollkorn Bold Italic") {$goofurl_2="Vollkorn:bolditalic";$goofont2="Vollkorn";}
elseif ($goofont2=="Walter Turncoat") {$goofurl_2="Walter+Turncoat";}
elseif ($goofont2=="Yanone Kaffeesatz") {$goofurl_2="Yanone+Kaffeesatz";}
elseif ($goofont2=="Yanone Kaffeesatz Light") {$goofurl_2="Yanone+Kaffeesatz:light";$goofont2="Yanone Kaffeesatz";}
elseif ($goofont2=="Yanone Kaffeesatz Bold") {$goofurl_2="Yanone+Kaffeesatz:bold";$goofont2="Yanone Kaffeesatz";}
else ;

$goofurl_3 = '';
$goofont3 = '';
$goofont3 = $this->params->get( 'font-face-3' );
if ($goofont3=="Allan") {$goofurl_3="Allan:bold";}
elseif ($goofont3=="Exo") {$goofurl_3="Exo:400";$goofont3="Exo";}
elseif ($goofont3=="Exo Italic") {$goofurl_3="Exo:400italic";$goofont3="Exo";}
elseif ($goofont3=="Exo Bold") {$goofurl_3="Exo:700";$goofont3="Exo";}
elseif ($goofont3=="Exo Bold Italic") {$goofurl_3="Exo:700italic";$goofont3="Exo";}
elseif ($goofont3=="Chelsea Market") {$goofurl_3="Chelsea+Market";}
elseif ($goofont3=="Jim Nightmare") {$goofurl_3="Jim+Nightmare";}
elseif ($goofont3=="Oldenburg") {$goofurl_3="Oldenburg";}
elseif ($goofont3=="Spicy Rice") {$goofurl_3="Spicy+Rice";}
elseif ($goofont3=="Nosifer") {$goofurl_3="Nosifer";}
elseif ($goofont3=="Eater") {$goofurl_3="Eater";}
elseif ($goofont3=="Creepster") {$goofurl_3="Creepster";}
elseif ($goofont3=="Butcherman") {$goofurl_3="Butcherman";}
elseif ($goofont3=="Sofia") {$goofurl_3="Sofia";}
elseif ($goofont3=="Asul") {$goofurl_3="Asul";}
elseif ($goofont3=="Alex Brush") {$goofurl_3="Alex+Brush";}
elseif ($goofont3=="Arizonia") {$goofurl_3="Arizonia";}
elseif ($goofont3=="Italianno") {$goofurl_3="Italianno";}
elseif ($goofont3=="Qwigley") {$goofurl_3="Qwigley";}
elseif ($goofont3=="Ruge Boogie") {$goofurl_3="Ruge+Boogie";}
elseif ($goofont3=="Ruthie") {$goofurl_3="Ruthie";}
elseif ($goofont3=="Playball") {$goofurl_3="Playball";}
elseif ($goofont3=="Dynalight") {$goofurl_3="Dynalight";}
elseif ($goofont3=="Stoke") {$goofurl_3="Stoke";}
elseif ($goofont3=="Sarina") {$goofurl_3="Sarina";}
elseif ($goofont3=="Yesteryear") {$goofurl_3="Yesteryear";}
elseif ($goofont3=="Trade Winds") {$goofurl_3="Trade+Winds";}
elseif ($goofont3=="Frijole") {$goofurl_3="Frijole";}
elseif ($goofont3=="Trykker") {$goofurl_3="Trykker";}
elseif ($goofont3=="Sail") {$goofurl_3="Sail";}
elseif ($goofont3=="Quantico") {$goofurl_3="Quantico";}
elseif ($goofont3=="Patua One") {$goofurl_3="Patua+One";}
elseif ($goofont3=="Overlock") {$goofurl_3="Overlock";}
elseif ($goofont3=="Overlock SC") {$goofurl_3="Overlock+SC";}
elseif ($goofont3=="Habibi") {$goofurl_3="Habibi";}
elseif ($goofont3=="Noticia Text") {$goofurl_3="Noticia+Text";}
elseif ($goofont3=="Miniver") {$goofurl_3="Miniver";}
elseif ($goofont3=="Medula One") {$goofurl_3="Medula+One";}
elseif ($goofont3=="Inder") {$goofurl_3="Inder";}
elseif ($goofont3=="Fugaz One") {$goofurl_3="Fugaz+One";}
elseif ($goofont3=="Flavors") {$goofurl_3="Flavors";}
elseif ($goofont3=="Flamenco") {$goofurl_3="Flamenco";}
elseif ($goofont3=="Duru Sans") {$goofurl_3="Duru+Sans";}
elseif ($goofont3=="Crete Round") {$goofurl_3="Crete+Round";}
elseif ($goofont3=="Caesar Dressing") {$goofurl_3="Caesar+Dressing";}
elseif ($goofont3=="Cambo") {$goofurl_3="Cambo";}
elseif ($goofont3=="Bluenard") {$goofurl_3="Bluenard";}
elseif ($goofont3=="Bree Serif") {$goofurl_3="Bree+Serif";}
elseif ($goofont3=="Boogaloo") {$goofurl_3="Boogaloo";}
elseif ($goofont3=="Belgrano") {$goofurl_3="Belgrano";}
elseif ($goofont3=="Armata") {$goofurl_3="Armata";}
elseif ($goofont3=="Alfa Slab One") {$goofurl_3="Alfa+Slab+One";}
elseif ($goofont3=="Uncial Antiqua") {$goofurl_3="Uncial+Antique";}
elseif ($goofont3=="Almendra") {$goofurl_3="Almendra";}
elseif ($goofont3=="Almendra SC") {$goofurl_3="Almendra+SC";}
elseif ($goofont3=="Acme") {$goofurl_3="Acme";}
elseif ($goofont3=="Squada One") {$goofurl_3="Squada+One";}
elseif ($goofont3=="Basic") {$goofurl_3="Basic";}
elseif ($goofont3=="Bilbo Swash Caps") {$goofurl_3="Bilbo+Swash+Caps";}
elseif ($goofont3=="Marko One") {$goofurl_3="Marko+One";}
elseif ($goofont3=="Bad Script") {$goofurl_3="Bad+Script";}
elseif ($goofont3=="Plaster") {$goofurl_3="Plaster";}
elseif ($goofont3=="Handlee") {$goofurl_3="Handlee";}
elseif ($goofont3=="Bathazar") {$goofurl_3="Bathazar";}
elseif ($goofont3=="Passion One") {$goofurl_3="Passion+One";}
elseif ($goofont3=="Chango") {$goofurl_3="Chango";}
elseif ($goofont3=="Enriqueta") {$goofurl_3="Enriqueta";}
elseif ($goofont3=="Montserrat") {$goofurl_3="Montserrat";}
elseif ($goofont3=="Original Surfer") {$goofurl_3="Original+Surfer";}
elseif ($goofont3=="Baumans") {$goofurl_3="Baumans";}
elseif ($goofont3=="Fascinate") {$goofurl_3="Fascinate";}
elseif ($goofont3=="Fascinate Inline") {$goofurl_3="Fascinate+Inline";}
elseif ($goofont3=="Stint Ultra Condensed") {$goofurl_3="Stint+Ultra+Condensed";}
elseif ($goofont3=="Bonbon") {$goofurl_3="Bonbon";}
elseif ($goofont3=="Arbutus") {$goofurl_3="Arbutus";}
elseif ($goofont3=="Galdeano") {$goofurl_3="Galdeano";}
elseif ($goofont3=="Metamorphous") {$goofurl_3="Metamorphous";}
elseif ($goofont3=="Cevivhe One") {$goofurl_3="Cevivhe+One";}
elseif ($goofont3=="Marmelad") {$goofurl_3="Marmelad";}
elseif ($goofont3=="Engagement") {$goofurl_3="Engagement";}
elseif ($goofont3=="Electrolize") {$goofurl_3="Electrolize";}
elseif ($goofont3=="Fresca") {$goofurl_3="Fresca";}
elseif ($goofont3=="Vigo") {$goofurl_3="Vigo";}
elseif ($goofont3=="Bilbo") {$goofurl_3="Bilbo";}
elseif ($goofont3=="Cabin Condensed") {$goofurl_3="Cabin+Condensed";}
elseif ($goofont3=="Dr Sugiyama") {$goofurl_3="Dr+Sugiyama";}
elseif ($goofont3=="Herr Von Muellerhoff") {$goofurl_3="Herr+Von+Muellerhoff";}
elseif ($goofont3=="Miss Fajardose") {$goofurl_3="Miss+Fajardose";}
elseif ($goofont3=="Miss Saint Delafield") {$goofurl_3="Miss+Saint+Delafield";}
elseif ($goofont3=="Monsieur La Doulaise") {$goofurl_3="Monsieur+La+Doulaise";}
elseif ($goofont3=="Mr Bedford") {$goofurl_3="Mr+Bedford";}
elseif ($goofont3=="Mr Dafoe") {$goofurl_3="Mr+Dafoe";}
elseif ($goofont3=="Mr De Gaviland") {$goofurl_3="Mr+De+Gaviland";}
elseif ($goofont3=="Mrs Sheppards") {$goofurl_3="Mrs+Sheppards";}
elseif ($goofont3=="Aguafina Script") {$goofurl_3="Aguafina+Script";}
elseif ($goofont3=="Piedra") {$goofurl_3="Piedra";}
elseif ($goofont3=="Aladin") {$goofurl_3="Aladin";}
elseif ($goofont3=="Chicle") {$goofurl_3="Chicle";}
elseif ($goofont3=="Cagliostro") {$goofurl_3="Cagliostro";}
elseif ($goofont3=="Lemon") {$goofurl_3="Lemon";}
elseif ($goofont3=="Unlock") {$goofurl_3="Unlock";}
elseif ($goofont3=="Signika") {$goofurl_3="Signika";}
elseif ($goofont3=="Signika Negaive") {$goofurl_3="Signika+Negative";}
elseif ($goofont3=="Niconne") {$goofurl_3="Niconne";}
elseif ($goofont3=="Knewave") {$goofurl_3="Knewave";}
elseif ($goofont3=="Righteous") {$goofurl_3="Righteous";}
elseif ($goofont3=="Ribeye") {$goofurl_3="Ribeye";}
elseif ($goofont3=="Ribeye Marrow") {$goofurl_3="Ribeye+Marrow";}
elseif ($goofont3=="Spirax") {$goofurl_3="Spirax";}
elseif ($goofont3=="Concert One") {$goofurl_3="Concert+One";}
elseif ($goofont3=="Bubblegun Sans") {$goofurl_3="Bubblegun+Sans";}
elseif ($goofont3=="Iceland") {$goofurl_3="Iceland";}
elseif ($goofont3=="Devonshire") {$goofurl_3="Devonshire";}
elseif ($goofont3=="Fondamento") {$goofurl_3="Fondamento";}
elseif ($goofont3=="Bitter") {$goofurl_3="Bitter";}
elseif ($goofont3=="Convergence") {$goofurl_3="Convergence";}
elseif ($goofont3=="Lancelot") {$goofurl_3="Lancelot";}
elseif ($goofont3=="Petrona") {$goofurl_3="Petrona";}
elseif ($goofont3=="Supermercado One") {$goofurl_3="Supermercado+One";}
elseif ($goofont3=="Arapey") {$goofurl_3="Arapey";}
elseif ($goofont3=="Mate") {$goofurl_3="Mate";}
elseif ($goofont3=="Mate SC") {$goofurl_3="Mate+SC";}
elseif ($goofont3=="Rammetto One") {$goofurl_3="Rammetto+One";}
elseif ($goofont3=="Fjord One") {$goofurl_3="Fjord+One";}
elseif ($goofont3=="Cabin Sketch") {$goofurl_3="Cabin+Sketch";}
elseif ($goofont3=="Jockey One") {$goofurl_3="Jockey+One";}
elseif ($goofont3=="Contrail One") {$goofurl_3="Contrail+One";}
elseif ($goofont3=="Atomic Age") {$goofurl_3="Atomic+Age";}
elseif ($goofont3=="Corben") {$goofurl_3="Corben";}
elseif ($goofont3=="Linden Hill") {$goofurl_3="Linden+Hill";}
elseif ($goofont3=="Quicksand") {$goofurl_3="Quicksand";}
elseif ($goofont3=="Amatic SC") {$goofurl_3="Amatic+SC";}
elseif ($goofont3=="Salsa") {$goofurl_3="Salsa";}
elseif ($goofont3=="Marck Script") {$goofurl_3="Marck+Script";}
elseif ($goofont3=="Vast Shadow") {$goofurl_3="Vast+Shadow";}
elseif ($goofont3=="Cookie") {$goofurl_3="Cookie";}
elseif ($goofont3=="Pinyon Script") {$goofurl_3="Pinyon+Script";}
elseif ($goofont3=="Satisfy") {$goofurl_3="Satisfy";}
elseif ($goofont3=="Rancho") {$goofurl_3="Rancho";}
elseif ($goofont3=="Coda") {$goofurl_3="Coda";}
elseif ($goofont3=="Sancheek") {$goofurl_3="Sancheek";}
elseif ($goofont3=="Ubunto Mon") {$goofurl_3="Ubunto+Mon";}
elseif ($goofont3=="Unbunto Condensed") {$goofurl_3="Ubunto+Condensed";}
elseif ($goofont3=="Federant") {$goofurl_3="Federant";}
elseif ($goofont3=="Andada") {$goofurl_3="Andada";}
elseif ($goofont3=="Poly") {$goofurl_3="Poly";}
elseif ($goofont3=="Gochi Hand") {$goofurl_3="Gochi+Hand";}
elseif ($goofont3=="Alike Angular") {$goofurl_3="Alike+Angular";}
elseif ($goofont3=="Poller One") {$goofurl_3="Poller+One";}
elseif ($goofont3=="Chivo") {$goofurl_3="Chivo";}
elseif ($goofont3=="Sanista One") {$goofurl_3="Sanista+One";}
elseif ($goofont3=="Terminal Dosis") {$goofurl_3="Terminal+Dosis";}
elseif ($goofont3=="Sorts Mill Goudy") {$goofurl_3="Sorts+Mill+Goudy";}
elseif ($goofont3=="Adamina") {$goofurl_3="Adamina";}
elseif ($goofont3=="Prata") {$goofurl_3="Prata";}
elseif ($goofont3=="Julee") {$goofurl_3="Julee";}
elseif ($goofont3=="Changa One") {$goofurl_3="Changa+One";}
elseif ($goofont3=="Merienda One") {$goofurl_3="Merienda+One";}
elseif ($goofont3=="Prociono") {$goofurl_3="Prociono";}
elseif ($goofont3=="Passero One") {$goofurl_3="Passero+One";}
elseif ($goofont3=="Antic") {$goofurl_3="Antic";}
elseif ($goofont3=="Dorsa") {$goofurl_3="Dorsa";}
elseif ($goofont3=="Abril Fatface") {$goofurl_3="Abril+Fatface";}
elseif ($goofont3=="Delius Unicase") {$goofurl_3="Delius+Unicase";}
elseif ($goofont3=="Alike") {$goofurl_3="Alike";}
elseif ($goofont3=="Monoton") {$goofurl_3="Monoton";}
elseif ($goofont3=="Days One") {$goofurl_3="Days One";}
elseif ($goofont3=="Numans") {$goofurl_3="Numans";}
elseif ($goofont3=="Aldrich") {$goofurl_3="Aldrich";}
elseif ($goofont3=="Vidaloka") {$goofurl_3="Vidaloka";}
elseif ($goofont3=="Short Stack") {$goofurl_3="Short+Stack";}
elseif ($goofont3=="Montez") {$goofurl_3="Montez";}
elseif ($goofont3=="Voltaire") {$goofurl_3="Voltaire";}
elseif ($goofont3=="Geostar Fill") {$goofurl_3="Geostar+Fill";}
elseif ($goofont3=="Geostar") {$goofurl_3="Geostar";}
elseif ($goofont3=="Questrial") {$goofurl_3="Questrial";}
elseif ($goofont3=="Alice") {$goofurl_3="Alice";}
elseif ($goofont3=="Andika") {$goofurl_3="Andika";}
elseif ($goofont3=="Tulpen One") {$goofurl_3="Tulpen+One";}
elseif ($goofont3=="Smokum") {$goofurl_3="Smokum";}
elseif ($goofont3=="Delius Swash Caps") {$goofurl_3="Delius+Swash+Caps";}
elseif ($goofont3=="Actor") {$goofurl_3="Actor";}
elseif ($goofont3=="Abel") {$goofurl_3="Abel";}
elseif ($goofont3=="Rationale") {$goofurl_3="Rationale";}
elseif ($goofont3=="Rochester") {$goofurl_3="Rochester";}
elseif ($goofont3=="Delius") {$goofurl_3="Delius";}
elseif ($goofont3=="Federo") {$goofurl_3="Federo";}
elseif ($goofont3=="Aubrey") {$goofurl_3="Aubrey";}
elseif ($goofont3=="Carme") {$goofurl_3="Carme";}
elseif ($goofont3=="Black Ops One") {$goofurl_3="Black+Ops+One";}
elseif ($goofont3=="Kelly Slab") {$goofurl_3="Kelly+Slab";}
elseif ($goofont3=="Gloria Hallelujah") {$goofurl_3="Gloria+Hallelujah";}
elseif ($goofont3=="Ovo") {$goofurl_3="Ovo";}
elseif ($goofont3=="Snippet") {$goofurl_3="Snippet";}
elseif ($goofont3=="Leckerli One") {$goofurl_3="Leckerli+One";}
elseif ($goofont3=="Rosario") {$goofurl_3="Rosario";}
elseif ($goofont3=="Unna") {$goofurl_3="Unna";}
elseif ($goofont3=="Pompiere") {$goofurl_3="Pompiere";}
elseif ($goofont3=="Yellowtail") {$goofurl_3="Yellowtail";}
elseif ($goofont3=="Modern Antiqua") {$goofurl_3="Modern+Antiqua";}
elseif ($goofont3=="Give You Glory") {$goofurl_3="Give+You+Glory";}
elseif ($goofont3=="Yeseva One") {$goofurl_3="Yeseva+One";}
elseif ($goofont3=="Varela Round") {$goofurl_3="Varela+Round";}
elseif ($goofont3=="Patrick Hand") {$goofurl_3="Patrick+Hand";}
elseif ($goofont3=="Forum") {$goofurl_3="Forum";}
elseif ($goofont3=="Bowlby One") {$goofurl_3="Bowlby+One";}
elseif ($goofont3=="Bowlby One SC") {$goofurl_3="Bowlby+One+SC";}
elseif ($goofont3=="Loved by the King") {$goofurl_3="Loved+by+the+King";}
elseif ($goofont3=="Love Ya Like A Sister") {$goofurl_3="Love+Ya+Like+A+Sister";}
elseif ($goofont3=="Stardos Stencil") {$goofurl_3="Stardos+Stencil";}
elseif ($goofont3=="Hammersmith One") {$goofurl_3="Hammersmith+One";}
elseif ($goofont3=="Gravitas One") {$goofurl_3="Gravitas+One";}
elseif ($goofont3=="Asset") {$goofurl_3="Asset";}
elseif ($goofont3=="Goblin One") {$goofurl_3="Goblin+One";}
elseif ($goofont3=="Varela") {$goofurl_3="Varela";}
elseif ($goofont3=="Fanwood Text") {$goofurl_3="Fanwood+Text";$goofont3="Fanwood Text";}
elseif ($goofont3=="Fanwood Text") {$goofurl_3="Fanwood+Text:400italic";$goofont3="Fanwood Text";}
elseif ($goofont3=="Gentium Basic") {$goofurl_3="Gentium+Basic";$goofont3="Gentium Basic";}
elseif ($goofont3=="Gentium Basic Italic") {$goofurl_3="Gentium+Basic:400italic";$goofont3="Gentium Basic";}
elseif ($goofont3=="Gentium Basic Bold") {$goofurl_3="Gentium+Basic:700";$goofont3="Gentium Basic";}
elseif ($goofont3=="Gentium Basic Bold Italic") {$goofurl_3="Gentium+Basic:700italic";$goofont3="Gentium Basic";}
elseif ($goofont3=="Gentium Book Basic") {$goofurl_3="Gentium+Book+Basic";$goofont3="Gentium Book Basic";}
elseif ($goofont3=="Gentium Book Basic Italic") {$goofurl_3="Gentium+Book+Basic:400italic";$goofont3="Gentium Book Basic";}
elseif ($goofont3=="Gentium Book Basic Bold") {$goofurl_3="Gentium+Book+Basic:700";$goofont3="Gentium Book Basic";}
elseif ($goofont3=="Gentium Book Basic Bold Italic") {$goofurl_3="Gentium+Book+Basic:700italic";$goofont3="Gentium Book Basic";}
elseif ($goofont3=="Volkhov") {$goofurl_3="Volkhov";$goofont3="Volkhov";}
elseif ($goofont3=="Volkhov Italic") {$goofurl_3="Volkhov:400italic";$goofont3="Volkhov";}
elseif ($goofont3=="Volkhov Bold") {$goofurl_3="Volkhov:700";$goofont3="Volkhov";}
elseif ($goofont3=="Volkhov Bold Italic") {$goofurl_3="Volkhov:700italic";$goofont3="Volkhov";}
elseif ($goofont3=="Comfortaa Book") {$goofurl_3="Comfortaa:300";$goofont3="Comfortaa";}
elseif ($goofont3=="Comfortaa Normal") {$goofurl_3="Comfortaa";$goofont3="Comfortaa";}
elseif ($goofont3=="Comfortaa Bold") {$goofurl_3="Comfortaa:700";$goofont3="Comfortaa";}
elseif ($goofont3=="Coustard") {$goofurl_3="Coustard";$goofont3="Coustard";}
elseif ($goofont3=="Coustard Ultra Bold") {$goofurl_3="Coustard:900";$goofont3="Coustard";}
elseif ($goofont3=="Marvel") {$goofurl_3="Marvel";$goofont3="Marvel";}
elseif ($goofont3=="Marvel Italic") {$goofurl_3="Marvel:400italic";$goofont3="Marvel";}
elseif ($goofont3=="Marvel Bold") {$goofurl_3="Marvel:700";$goofont3="Marvel";}
elseif ($goofont3=="Marvel Bold Italic") {$goofurl_3="Marvel:700italic";$goofont3="Marvel";}
elseif ($goofont3=="Istok Web") {$goofurl_3="Istok+Web";$goofont3="Istok Web";}
elseif ($goofont3=="Istok Web Italic") {$goofurl_3="Istok+Web:400italic";$goofont3="Istok Web";}
elseif ($goofont3=="Istok Web Bold") {$goofurl_3="Istok+Web:700";$goofont3="Istok Web";}
elseif ($goofont3=="Istok Web Bold Italic") {$goofurl_3="Istok+Web:700italic";$goofont3="Istok Web";}
elseif ($goofont3=="Tienne") {$goofurl_3="Tienne";$goofont3="Tienne";}
elseif ($goofont3=="Tienne Bold") {$goofurl_3="Tienne:700";$goofont3="Tienne";}
elseif ($goofont3=="Tienne Ultra Bold") {$goofurl_3="Tienne:900";$goofont3="Tienne";}

elseif ($goofont3=="Nixie One") {$goofurl_3="Nixie+One";}
elseif ($goofont3=="Redressed") {$goofurl_3="Redressed";}
elseif ($goofont3=="Lobster Two") {$goofurl_3="Lobster+Two";$goofont3="Lobster Two";}
elseif ($goofont3=="Lobster Two Italic") {$goofurl_3="Lobster+Two:400italic";$goofont3="Lobster Two";}
elseif ($goofont3=="Lobster Two Bold") {$goofurl_3="Lobster+Two:700";$goofont3="Lobster Two";}
elseif ($goofont3=="Lobster Two Bold Italic") {$goofurl_3="Lobster+Two:700italic";$goofont3="Lobster Two";}
elseif ($goofont3=="Caudex") {$goofurl_3="Caudex";}
elseif ($goofont3=="Jura") {$goofurl_3="Jura";}
elseif ($goofont3=="Ruslan Display") {$goofurl_3="Ruslan+Display";}
elseif ($goofont3=="Brawler") {$goofurl_3="Brawler";}
elseif ($goofont3=="Nunito") {$goofurl_3="Nunito";}
elseif ($goofont3=="Wire One") {$goofurl_3="Wire+One";}
elseif ($goofont3=="Podkova") {$goofurl_3="Podkova";}
elseif ($goofont3=="Muli") {$goofurl_3="Muli";}
elseif ($goofont3=="Maven Pro") {$goofurl_3="Maven+Pro";}
elseif ($goofont3=="Tenor Sans") {$goofurl_3="Tenor+Sans";}
elseif ($goofont3=="Limelight") {$goofurl_3="Limelight";}
elseif ($goofont3=="Playfair Display") {$goofurl_3="Playfair+Display";}
elseif ($goofont3=="Artifika") {$goofurl_3="Artifika";}
elseif ($goofont3=="Lora") {$goofurl_3="Lora";}
elseif ($goofont3=="Kameron") {$goofurl_3="Kameron";}
elseif ($goofont3=="Cedarville Cursive") {$goofurl_3="Cedarville+Cursive";}
elseif ($goofont3=="Zeyada") {$goofurl_3="Zeyada";}
elseif ($goofont3=="La Belle Aurore") {$goofurl_3="La+Belle+Aurore";}
elseif ($goofont3=="Shadows into Light") {$goofurl_3="Shadows+Into+Light";}
elseif ($goofont3=="Shanti") {$goofurl_3="Shanti";}
elseif ($goofont3=="Mako") {$goofurl_3="Mako";}
elseif ($goofont3=="Metrophobic") {$goofurl_3="Metrophobic";}
elseif ($goofont3=="Ultra") {$goofurl_3="Ultra";}
elseif ($goofont3=="Play") {$goofurl_3="Play";}
elseif ($goofont3=="Didact Gothic") {$goofurl_3="Didact+Gothic";}
elseif ($goofont3=="Judson") {$goofurl_3="Judson";}
elseif ($goofont3=="Megrim") {$goofurl_3="Megrim";}
elseif ($goofont3=="Rokkitt") {$goofurl_3="Rokkitt";}
elseif ($goofont3=="Monofett") {$goofurl_3="Monofett";}
elseif ($goofont3=="Paytone One") {$goofurl_3="Paytone+One";}
elseif ($goofont3=="Holtwood One SC") {$goofurl_3="Holtwood+One+SC";}
elseif ($goofont3=="Carter One") {$goofurl_3="Carter+One";}
elseif ($goofont3=="Francois One") {$goofurl_3="Francois+One";}
elseif ($goofont3=="Bigshot One") {$goofurl_3="Bigshot+One";}
elseif ($goofont3=="Sigmar One") {$goofurl_3="Sigmar+One";}
elseif ($goofont3=="Swanky and Moo Moo") {$goofurl_3="Swanky+and+Moo+Moo";}
elseif ($goofont3=="Over the Rainbow") {$goofurl_3="Over+the+Rainbow";}
elseif ($goofont3=="Wallpoet") {$goofurl_3="Wallpoet";}
elseif ($goofont3=="Damion") {$goofurl_3="Damion";}
elseif ($goofont3=="News Cycle") {$goofurl_3="News+Cycle";}
elseif ($goofont3=="Aclonica") {$goofurl_3="Aclonica";}
elseif ($goofont3=="Special Elite") {$goofurl_3="Special+Elite";}
elseif ($goofont3=="Smythe") {$goofurl_3="Smythe";}
elseif ($goofont3=="Quattrocento Sans") {$goofurl_3="Quattrocento+Sans";}
elseif ($goofont3=="The Girl Next Door") {$goofurl_3="The+Girl+Next+Door";}
elseif ($goofont3=="Sue Ellen Francisco") {$goofurl_3="Sue+Ellen+Francisco";}
elseif ($goofont3=="Dawning of a New Day") {$goofurl_3="Dawning+of+a+New+Day";}
elseif ($goofont3=="Waiting for the Sunrise") {$goofurl_3="Waiting+for+the+Sunrise";}
elseif ($goofont3=="Annie Use Your Telescope") {$goofurl_3="Annie+Use+Your+Telescope";}
elseif ($goofont3=="Maiden Orange") {$goofurl_3="Maiden+Orange";}
elseif ($goofont3=="Luckiest Guy") {$goofurl_3="Luckiest+Guy";}
elseif ($goofont3=="Bangers") {$goofurl_3="Bangers";}
elseif ($goofont3=="Miltonian") {$goofurl_3="Miltonian";}
elseif ($goofont3=="Miltonian Tattoo") {$goofurl_3="Miltonian+Tattoo";}
elseif ($goofont3=="Allerta") {$goofurl_3="Allerta";}
elseif ($goofont3=="Allerta Stencil") {$goofurl_3="Allerta+Stencil";}
elseif ($goofont3=="Amaranth") {$goofurl_3="Amaranth";}
elseif ($goofont3=="Anonymous Pro") {$goofurl_3="Anonymous+Pro";}
elseif ($goofont3=="Anonymous Pro Italic") {$goofurl_3="Anonymous+Pro:italic";$goofont3="Anonymous Pro";}
elseif ($goofont3=="Anonymous Pro Bold") {$goofurl_3="Anonymous+Pro:bold";$goofont3="Anonymous Pro";}
elseif ($goofont3=="Anonymous Pro Bold Italic") {$goofurl_3="Anonymous+Pro:bolditalic";$goofont3="Anonymous Pro";}
elseif ($goofont3=="Anton") {$goofurl_3="Anton";}
elseif ($goofont3=="Architects Daughter") {$goofurl_3="Architects+Daughter";}
elseif ($goofont3=="Arimo") {$goofurl_3="Arimo";}
elseif ($goofont3=="Arimo Italic") {$goofurl_3="Arimo:italic";$goofont3="Arimo";}
elseif ($goofont3=="Arimo Bold") {$goofurl_3="Arimo:bold";$goofont3="Arimo";}
elseif ($goofont3=="Arimo Bold Italic") {$goofurl_3="Arimo:bolditalic";$goofont3="Arimo";}
elseif ($goofont3=="Arvo") {$goofurl_3="Arvo"; $goofont3="Arvo";}
elseif ($goofont3=="Arvo Italic") {$goofurl_3="Arvo:italic"; $goofont3="Arvo";}
elseif ($goofont3=="Arvo Bold") {$goofurl_3="Arvo:bold"; $goofont3="Arvo";}
elseif ($goofont3=="Arvo Bold Italic") {$goofurl_3="Arvo:bolditalic"; $goofont3="Arvo";}
elseif ($goofont3=="Astloch") {$goofurl_3="Astloch";}
elseif ($goofont3=="Astloch Bold") {$goofurl_3="Astloch:bold"; $goofont3="Astloch";}
elseif ($goofont3=="Bentham") {$goofurl_3="Bentham";}
elseif ($goofont3=="Bevan") {$goofurl_3="Bevan";}
elseif ($goofont3=="Buda") {$goofurl_3="Buda:light";}
elseif ($goofont3=="Cabin") {$goofurl_3="Cabin:regular";}
elseif ($goofont3=="Cabin Italic") {$goofurl_3="Cabin:regularitalic";$goofont3="Cabin";}
elseif ($goofont3=="Cabin Bold") {$goofurl_3="Cabin:bold";$goofont3="Cabin";}
elseif ($goofont3=="Cabin Bold Italic") {$goofurl_3="Cabin:bolditalic";$goofont3="Cabin";}
elseif ($goofont3=="Cabin Sketch") {$goofurl_3="Cabin+Sketch:bold";}
elseif ($goofont3=="Calligraffitti") {$goofurl_3="Calligraffitti";}
elseif ($goofont3=="Candal") {$goofurl_3="Candal";}
elseif ($goofont3=="Cantarell") {$goofurl_3="Cantarell";}
elseif ($goofont3=="Cantarell Italic") {$goofurl_3="Cantarell:italic";$goofont3="Cantarell";}
elseif ($goofont3=="Cantarell Bold") {$goofurl_3="Cantarell:bold";$goofont3="Cantarell";}
elseif ($goofont3=="Cantarell Bold Italic") {$goofurl_3="Cantarell:bolditalic";$goofont3="Cantarell";}
elseif ($goofont3=="Cardo") {$goofurl_3="Cardo";}
elseif ($goofont3=="Cherry Cream Soda") {$goofurl_3="Cherry+Cream+Soda";}
elseif ($goofont3=="Chewy") {$goofurl_3="Chewy";}
elseif ($goofont3=="Coda") {$goofurl_3="Coda:800";}
elseif ($goofont3=="Coda Caption") {$goofurl_3="Coda+Caption:800";}
elseif ($goofont3=="Coming Soon") {$goofurl_3="Coming+Soon";}
elseif ($goofont3=="Copse") {$goofurl_3="Copse";}
elseif ($goofont3=="Corben") {$goofurl_3="Corben:bold";}
elseif ($goofont3=="Cousine") {$goofurl_3="Cousine";}
elseif ($goofont3=="Cousine Italic") {$goofurl_3="Cousine:italic";$goofont3="Cousine";}
elseif ($goofont3=="Cousine Bold") {$goofurl_3="Cousine:bold";$goofont3="Cousine";}
elseif ($goofont3=="Cousine Bold Italic") {$goofurl_3="Cousine:bolditalic";$goofont3="Cousine";}
elseif ($goofont3=="Covered By Your Grace") {$goofurl_3="Covered+By+Your+Grace";}
elseif ($goofont3=="Crafty Girls") {$goofurl_3="Crafty+Girls";}
elseif ($goofont3=="Crimson Text") {$goofurl_3="Crimson+Text";}
elseif ($goofont3=="Crimson Text Italic") {$goofurl_3="Crimson+Text:italic";$goofont3="Crimson Text";}
elseif ($goofont3=="Crimson Text Bold") {$goofurl_3="Crimson+Text:bold";$goofont3="Crimson Text";}
elseif ($goofont3=="Crimson Text Bold Italic") {$goofurl_3="Crimson+Text:bolditalic";$goofont3="Crimson Text";}
elseif ($goofont3=="Crushed") {$goofurl_3="Crushed";}
elseif ($goofont3=="Cuprum") {$goofurl_3="Cuprum";}
elseif ($goofont3=="Droid Sans") {$goofurl_3="Droid+Sans";}
elseif ($goofont3=="Droid Sans Bold") {$goofurl_3="Droid+Sans:bold"; $goofont3="Droid Sans";}
elseif ($goofont3=="Droid Sans Mono") {$goofurl_3="Droid+Sans+Mono";}
elseif ($goofont3=="Droid Serif") {$goofurl_3="Droid+Serif";}
elseif ($goofont3=="Droid Serif Italic") {$goofurl_3="Droid+Serif:italic";$goofont3="Droid Serif";}
elseif ($goofont3=="Droid Serif Bold") {$goofurl_3="Droid+Serif:bold";$goofont3="Droid Serif";}
elseif ($goofont3=="Droid Serif Bold Italic") {$goofurl_3="Droid+Serif:bolditalic";$goofont3="Droid Serif";}
elseif ($goofont3=="EB Garamond") {$goofurl_3="EB+Garamond";}
elseif ($goofont3=="Expletus Sans") {$goofurl_3="Expletus+Sans";}
elseif ($goofont3=="Expletus Sans Bold") {$goofurl_3="Expletus+Sans:bold";$goofont3="Expletus Sans";}
elseif ($goofont3=="Fontdiner Swanky") {$goofurl_3="Fontdiner+Swanky";}
elseif ($goofont3=="Geo") {$goofurl_3="Geo";}
elseif ($goofont3=="Goudy Bookletter 1911") {$goofurl_3="Goudy+Bookletter+1911";}
elseif ($goofont3=="Gruppo") {$goofurl_3="Gruppo";}
elseif ($goofont3=="Homemade Apple") {$goofurl_3="Homemade+Apple";}
elseif ($goofont3=="IM Fell Double Pica") {$goofurl_3="IM+Fell+Double+Pica";$goofont3="IM Fell Double Pica";}
elseif ($goofont3=="IM Fell Double Pica Italic") {$goofurl_3="IM+Fell+Double+Pica:italic";$goofont3="IM Fell Double Pica";}
elseif ($goofont3=="IM Fell Double Pica SC") {$goofurl_3="IM+Fell+Double+Pica+SC";}
elseif ($goofont3=="IM Fell DW Pica") {$goofurl_3="IM+Fell+DW+Pica";$goofont3="IM Fell DW Pica";}
elseif ($goofont3=="IM Fell DW Pica Italic") {$goofurl_3="IM+Fell+DW+Pica:italic";$goofont3="IM Fell DW Pica";}
elseif ($goofont3=="IM Fell DW Pica SC") {$goofurl_3="IM+Fell+DW+Pica+SC";}
elseif ($goofont3=="IM Fell English") {$goofurl_3="IM+Fell+English";$goofont3="IM Fell English";}
elseif ($goofont3=="IM Fell English Italic") {$goofurl_3="IM+Fell+English:italic";$goofont3="IM Fell English";}
elseif ($goofont3=="IM Fell English SC") {$goofurl_3="IM+Fell+English+SC";}
elseif ($goofont3=="IM Fell French Canon") {$goofurl_3="IM+Fell+French+Canon";$goofont3="IM Fell French Canon";}
elseif ($goofont3=="IM Fell French Canon Italic") {$goofurl_3="IM+Fell+French+Canon:italic";$goofont3="IM Fell French Canon";}
elseif ($goofont3=="IM Fell French Canon SC") {$goofurl_3="IM+Fell+French+Canon+SC";}
elseif ($goofont3=="IM Fell Great Primer") {$goofurl_3="IM+Fell+Great+Primer";$goofont3="IM Fell Great Primer";}
elseif ($goofont3=="IM Fell Great Primer Italic") {$goofurl_3="IM+Fell+Great+Primer:italic";$goofont3="IM Fell Great Primer";}
elseif ($goofont3=="IM Fell Great Primer SC") {$goofurl_3="IM+Fell+Great+Primera+SC";}
elseif ($goofont3=="Inconsolata") {$goofurl_3="Inconsolata";}
elseif ($goofont3=="Indie Flower") {$goofurl_3="Indie+Flower";}
elseif ($goofont3=="Irish Grover") {$goofurl_3="Irish+Grover";}
elseif ($goofont3=="Josefin Sans") {$goofurl_3="Josefin+Sans";}
elseif ($goofont3=="Josefin Sans Italic") {$goofurl_3="Josefin+Sans:regularitalic"; $goofont3="Josefin Sans";}
elseif ($goofont3=="Josefin Sans Bold") {$goofurl_3="Josefin+Sans:bold"; $goofont3="Josefin Sans";}
elseif ($goofont3=="Josefin Sans Bold Italic") {$goofurl_3="Josefin+Sans:bolditalic"; $goofont3="Josefin Sans";}
elseif ($goofont3=="Josefin Slab") {$goofurl_3="Josefin+Slab";}
elseif ($goofont3=="Just Another Hand") {$goofurl_3="Just+Another+Hand";}
elseif ($goofont3=="Just Me Again Down Here") {$goofurl_3="Just+Me+Again+Down+Here";}
elseif ($goofont3=="Kenia") {$goofurl_3="Kenia";}
elseif ($goofont3=="Kranky") {$goofurl_3="Kranky";}
elseif ($goofont3=="Kreon") {$goofurl_3="Kreon";}
elseif ($goofont3=="Kreon Bold") {$goofurl_3="Kreon:bold"; $goofont3="Kreon";}
elseif ($goofont3=="Kristi") {$goofurl_3="Kristi";}
elseif ($goofont3=="Lato") {$goofurl_3="Lato";}
elseif ($goofont3=="Lato Italic") {$goofurl_3="Lato:regularitalic";$goofont3="Lato";}
elseif ($goofont3=="Lato Bold") {$goofurl_3="Lato:bold";$goofont3="Lato";}
elseif ($goofont3=="Lato Bold Italic") {$goofurl_3="Lato:bolditalic";$goofont3="Lato";}
elseif ($goofont3=="League Script") {$goofurl_3="League+Script";}
elseif ($goofont3=="Lekton") {$goofurl_3="Lekton";}
elseif ($goofont3=="Lekton Italic") {$goofurl_3="Lekton:italic"; $goofont3="Lekton";}
elseif ($goofont3=="Lekton Bold") {$goofurl_3="Lekton:bold"; $goofont3="Lekton";}
elseif ($goofont3=="Lobster") {$goofurl_3="Lobster";}
elseif ($goofont3=="MedievalSharp") {$goofurl_3="MedievalSharp";}
elseif ($goofont3=="Merriweather") {$goofurl_3="Merriweather";}
elseif ($goofont3=="Michroma") {$goofurl_3="Michroma";}
elseif ($goofont3=="Molengo") {$goofurl_3="Molengo";}
elseif ($goofont3=="Mountains of Christmas") {$goofurl_3="Mountains+of+Christmas";}
elseif ($goofont3=="Neucha") {$goofurl_3="Neucha";}
elseif ($goofont3=="Neuton") {$goofurl_3="Neuton";}
elseif ($goofont3=="Neuton Italic") {$goofurl_3="Neuton:italic"; $goofont3="Neuton";}
elseif ($goofont3=="Nobile") {$goofurl_3="Nobile";}
elseif ($goofont3=="Nobile Italic") {$goofurl_3="Nobile:italic"; $goofont3="Nobile";}
elseif ($goofont3=="Nobile Bold") {$goofurl_3="Nobile:bold"; $goofont3="Nobile";}
elseif ($goofont3=="Nobile Bold Italic") {$goofurl_3="Nobile:bolditalic"; $goofont3="Nobile";}
elseif ($goofont3=="Nova Round") {$goofurl_3="Nova+Round";}
elseif ($goofont3=="Nova Script") {$goofurl_3="Nova+Script";}
elseif ($goofont3=="Nova Slim") {$goofurl_3="Nova+Slim";}
elseif ($goofont3=="Nova Cut") {$goofurl_3="Nova+Cut";}
elseif ($goofont3=="Nova Oval") {$goofurl_3="Nova+Oval";}
elseif ($goofont3=="Nova Mono") {$goofurl_3="Nova+Mono";}
elseif ($goofont3=="Nova Flat") {$goofurl_3="Nova+Flat";}
elseif ($goofont3=="OFL Sorts Mill Goudy TT") {$goofurl_3="OFL+Sorts+Mill+Goudy+TT";}
elseif ($goofont3=="OFL Sorts Mill Goudy TT Italic") {$goofurl_3="OFL+Sorts+Mill+Goudy+TT:italic";$goofont3="OFL Sorts Mill Goudy TT";}
elseif ($goofont3=="Old Standard TT") {$goofurl_3="Old+Standard+TT";}
elseif ($goofont3=="Old Standard TT Italic") {$goofurl_3="Old+Standard+TT:italic";$goofont3="Old Standard TT";}
elseif ($goofont3=="Old Standard TT Bold") {$goofurl_3="Old+Standard+TT:bold";$goofont3="Old Standard TT";}
elseif ($goofont3=="Orbitron") {$goofurl_3="Orbitron";}
elseif ($goofont3=="Orbitron Italic") {$goofurl_3="Orbitron:italic";$goofont3="Orbitron";}
elseif ($goofont3=="Orbitron Bold") {$goofurl_3="Orbitron:bold";$goofont3="Orbitron";}
elseif ($goofont3=="Orbitron Bold Italic") {$goofurl_3="Orbitron:bolditalic";$goofont3="Orbitron";}
elseif ($goofont3=="Oswald") {$goofurl_3="Oswald";}
elseif ($goofont3=="Pacifico") {$goofurl_3="Pacifico";}
elseif ($goofont3=="Permanent Marker") {$goofurl_3="Permanent+Marker";}
elseif ($goofont3=="PT Sans") {$goofurl_3="PT+Sans";}
elseif ($goofont3=="PT Sans Italic") {$goofurl_3="PT+Sans:italic";}
elseif ($goofont3=="PT Sans Bold") {$goofurl_3="PT+Sans:bold";}
elseif ($goofont3=="PT Sans Bold Italic") {$goofurl_3="PT+Sans:bolditalic";}
elseif ($goofont3=="PT Sans Caption") {$goofurl_3="PT+Sans+Caption";}
elseif ($goofont3=="PT Sans Caption Bold") {$goofurl_3="PT+Sans+Caption:bold"; $goofont3="PT Sans Caption";}
elseif ($goofont3=="PT Sans Narrow") {$goofurl_3="PT+Sans+Narrow";}
elseif ($goofont3=="PT Sans Narrow Bold") {$goofurl_3="PT+Sans+Narrow:bold"; $goofont3="PT Sans Narrow";}
elseif ($goofont3=="PT Serif") {$goofurl_3="PT+Serif";}
elseif ($goofont3=="PT Serif Italic") {$goofurl_3="PT+Serif:italic";$goofont3="PT Serif";}
elseif ($goofont3=="PT Serif Bold") {$goofurl_3="PT+Serif:bold";$goofont3="PT Serif";}
elseif ($goofont3=="PT Serif Bold Italic") {$goofurl_3="PT+Serif:bolditalic";$goofont3="PT Serif";}
elseif ($goofont3=="PT Serif Caption") {$goofurl_3="PT+Serif+Caption";}
elseif ($goofont3=="PT Serif Caption Bold") {$goofurl_3="PT+Serif+Caption+Bold"; $goofont3="PT Serif Caption";}
elseif ($goofont3=="Philosopher") {$goofurl_3="Philosopher";}
elseif ($goofont3=="Puritan") {$goofurl_3="Puritan";}
elseif ($goofont3=="Puritan Italic") {$goofurl_3="Puritan:italic";$goofont3="Puritan";}
elseif ($goofont3=="Puritan Bold") {$goofurl_3="Puritan:bold";$goofont3="Puritan";}
elseif ($goofont3=="Puritan Bold Italic") {$goofurl_3="Puritan:bolditalic";$goofont3="Puritan";}
elseif ($goofont3=="Quattrocento") {$goofurl_3="Quattrocento";}
elseif ($goofont3=="Raleway") {$goofurl_3="Raleway:100";}
elseif ($goofont3=="Reenie Beanie") {$goofurl_3="Reenie+Beanie";}
elseif ($goofont3=="Rock Salt") {$goofurl_3="Rock+Salt";}
elseif ($goofont3=="Schoolbell") {$goofurl_3="Schoolbell";}
elseif ($goofont3=="Slackey") {$goofurl_3="Slackey";}
elseif ($goofont3=="Sniglet") {$goofurl_3="Sniglet:800";}
elseif ($goofont3=="Sunshiney") {$goofurl_3="Sunshiney";}
elseif ($goofont3=="Syncopate") {$goofurl_3="Syncopate";}
elseif ($goofont3=="Tangerine") {$goofurl_3="Tangerine";}
elseif ($goofont3=="Terminal Dosis Light") {$goofurl_3="Terminal Dosis Light";}
elseif ($goofont3=="Tinos") {$goofurl_3="Tinos";}
elseif ($goofont3=="Tinos Italic") {$goofurl_3="Tinos:italic";$goofont3="Tinos";}
elseif ($goofont3=="Tinos Bold") {$goofurl_3="Tinos:bold";$goofont3="Tinos";}
elseif ($goofont3=="Tinos Bold Italic") {$goofurl_3="Tinos:bolditalic";$goofont3="Tinos";}
elseif ($goofont3=="Ubuntu") {$goofurl_3="Ubuntu";}
elseif ($goofont3=="Ubuntu Italic") {$goofurl_3="Ubuntu:italic";$goofont3="Ubuntu";}
elseif ($goofont3=="Ubuntu Bold") {$goofurl_3="Ubuntu:bold";$goofont3="Ubuntu";}
elseif ($goofont3=="Ubuntu Bold Italic") {$goofurl_3="Ubuntu:bolditalic";$goofont3="Ubuntu";}
elseif ($goofont3=="UnifrakturCook") {$goofurl_3="UnifrakturCook:bold";}
elseif ($goofont3=="UnifrakturMaguntia") {$goofurl_3="UnifrakturMaguntia";}
elseif ($goofont3=="Unkempt") {$goofurl_3="Unkempt";}
elseif ($goofont3=="VT323") {$goofurl_3="VT323";}
elseif ($goofont3=="Vibur") {$goofurl_3="Vibur";}
elseif ($goofont3=="Vollkorn") {$goofurl_3="Vollkorn";}
elseif ($goofont3=="Vollkorn Italic") {$goofurl_3="Vollkorn:italic";$goofont3="Vollkorn";}
elseif ($goofont3=="Vollkorn Bold") {$goofurl_3="Vollkorn:bold";$goofont3="Vollkorn";}
elseif ($goofont3=="Vollkorn Bold Italic") {$goofurl_3="Vollkorn:bolditalic";$goofont3="Vollkorn";}
elseif ($goofont3=="Walter Turncoat") {$goofurl_3="Walter+Turncoat";}
elseif ($goofont3=="Yanone Kaffeesatz") {$goofurl_3="Yanone+Kaffeesatz";}
elseif ($goofont3=="Yanone Kaffeesatz Light") {$goofurl_3="Yanone+Kaffeesatz:light";$goofont3="Yanone Kaffeesatz";}
elseif ($goofont3=="Yanone Kaffeesatz Bold") {$goofurl_3="Yanone+Kaffeesatz:bold";$goofont3="Yanone Kaffeesatz";}
else ;

$goofurl_4 = '';
$goofont4 = '';
$goofont4 = $this->params->get( 'font-face-4' );

if ($goofont4=="Allan") {$goofurl_4="Allan:bold";}
elseif ($goofont4=="Exo") {$goofurl_4="Exo:400";$goofont4="Exo";}
elseif ($goofont4=="Exo Italic") {$goofurl_4="Exo:400italic";$goofont4="Exo";}
elseif ($goofont4=="Exo Bold") {$goofurl_4="Exo:700";$goofont4="Exo";}
elseif ($goofont4=="Exo Bold Italic") {$goofurl_4="Exo:700italic";$goofont4="Exo";}
elseif ($goofont4=="Chelsea Market") {$goofurl_4="Chelsea+Market";}
elseif ($goofont4=="Jim Nightmare") {$goofurl_4="Jim+Nightmare";}
elseif ($goofont4=="Oldenburg") {$goofurl_4="Oldenburg";}
elseif ($goofont4=="Spicy Rice") {$goofurl_4="Spicy+Rice";}
elseif ($goofont4=="Nosifer") {$goofurl_4="Nosifer";}
elseif ($goofont4=="Eater") {$goofurl_4="Eater";}
elseif ($goofont4=="Creepster") {$goofurl_4="Creepster";}
elseif ($goofont4=="Butcherman") {$goofurl_4="Butcherman";}
elseif ($goofont4=="Sofia") {$goofurl_4="Sofia";}
elseif ($goofont4=="Asul") {$goofurl_4="Asul";}
elseif ($goofont4=="Alex Brush") {$goofurl_4="Alex+Brush";}
elseif ($goofont4=="Arizonia") {$goofurl_4="Arizonia";}
elseif ($goofont4=="Italianno") {$goofurl_4="Italianno";}
elseif ($goofont4=="Qwigley") {$goofurl_4="Qwigley";}
elseif ($goofont4=="Ruge Boogie") {$goofurl_4="Ruge+Boogie";}
elseif ($goofont4=="Ruthie") {$goofurl_4="Ruthie";}
elseif ($goofont4=="Playball") {$goofurl_4="Playball";}
elseif ($goofont4=="Dynalight") {$goofurl_4="Dynalight";}
elseif ($goofont4=="Stoke") {$goofurl_4="Stoke";}
elseif ($goofont4=="Sarina") {$goofurl_4="Sarina";}
elseif ($goofont4=="Yesteryear") {$goofurl_4="Yesteryear";}
elseif ($goofont4=="Trade Winds") {$goofurl_4="Trade+Winds";}
elseif ($goofont4=="Frijole") {$goofurl_4="Frijole";}
elseif ($goofont4=="Trykker") {$goofurl_4="Trykker";}
elseif ($goofont4=="Sail") {$goofurl_4="Sail";}
elseif ($goofont4=="Quantico") {$goofurl_4="Quantico";}
elseif ($goofont4=="Patua One") {$goofurl_4="Patua+One";}
elseif ($goofont4=="Overlock") {$goofurl_4="Overlock";}
elseif ($goofont4=="Overlock SC") {$goofurl_4="Overlock+SC";}
elseif ($goofont4=="Habibi") {$goofurl_4="Habibi";}
elseif ($goofont4=="Noticia Text") {$goofurl_4="Noticia+Text";}
elseif ($goofont4=="Miniver") {$goofurl_4="Miniver";}
elseif ($goofont4=="Medula One") {$goofurl_4="Medula+One";}
elseif ($goofont4=="Inder") {$goofurl_4="Inder";}
elseif ($goofont4=="Fugaz One") {$goofurl_4="Fugaz+One";}
elseif ($goofont4=="Flavors") {$goofurl_4="Flavors";}
elseif ($goofont4=="Flamenco") {$goofurl_4="Flamenco";}
elseif ($goofont4=="Duru Sans") {$goofurl_4="Duru+Sans";}
elseif ($goofont4=="Crete Round") {$goofurl_4="Crete+Round";}
elseif ($goofont4=="Caesar Dressing") {$goofurl_4="Caesar+Dressing";}
elseif ($goofont4=="Cambo") {$goofurl_4="Cambo";}
elseif ($goofont4=="Bluenard") {$goofurl_4="Bluenard";}
elseif ($goofont4=="Bree Serif") {$goofurl_4="Bree+Serif";}
elseif ($goofont4=="Boogaloo") {$goofurl_4="Boogaloo";}
elseif ($goofont4=="Belgrano") {$goofurl_4="Belgrano";}
elseif ($goofont4=="Armata") {$goofurl_4="Armata";}
elseif ($goofont4=="Alfa Slab One") {$goofurl_4="Alfa+Slab+One";}
elseif ($goofont4=="Uncial Antiqua") {$goofurl_4="Uncial+Antique";}
elseif ($goofont4=="Almendra") {$goofurl_4="Almendra";}
elseif ($goofont4=="Almendra SC") {$goofurl_4="Almendra+SC";}
elseif ($goofont4=="Acme") {$goofurl_4="Acme";}
elseif ($goofont4=="Squada One") {$goofurl_4="Squada+One";}
elseif ($goofont4=="Basic") {$goofurl_4="Basic";}
elseif ($goofont4=="Bilbo Swash Caps") {$goofurl_4="Bilbo+Swash+Caps";}
elseif ($goofont4=="Marko One") {$goofurl_4="Marko+One";}
elseif ($goofont4=="Bad Script") {$goofurl_4="Bad+Script";}
elseif ($goofont4=="Plaster") {$goofurl_4="Plaster";}
elseif ($goofont4=="Handlee") {$goofurl_4="Handlee";}
elseif ($goofont4=="Bathazar") {$goofurl_4="Bathazar";}
elseif ($goofont4=="Passion One") {$goofurl_4="Passion+One";}
elseif ($goofont4=="Chango") {$goofurl_4="Chango";}
elseif ($goofont4=="Enriqueta") {$goofurl_4="Enriqueta";}
elseif ($goofont4=="Montserrat") {$goofurl_4="Montserrat";}
elseif ($goofont4=="Original Surfer") {$goofurl_4="Original+Surfer";}
elseif ($goofont4=="Baumans") {$goofurl_4="Baumans";}
elseif ($goofont4=="Fascinate") {$goofurl_4="Fascinate";}
elseif ($goofont4=="Fascinate Inline") {$goofurl_4="Fascinate+Inline";}
elseif ($goofont4=="Stint Ultra Condensed") {$goofurl_4="Stint+Ultra+Condensed";}
elseif ($goofont4=="Bonbon") {$goofurl_4="Bonbon";}
elseif ($goofont4=="Arbutus") {$goofurl_4="Arbutus";}
elseif ($goofont4=="Galdeano") {$goofurl_4="Galdeano";}
elseif ($goofont4=="Metamorphous") {$goofurl_4="Metamorphous";}
elseif ($goofont4=="Cevivhe One") {$goofurl_4="Cevivhe+One";}
elseif ($goofont4=="Marmelad") {$goofurl_4="Marmelad";}
elseif ($goofont4=="Engagement") {$goofurl_4="Engagement";}
elseif ($goofont4=="Electrolize") {$goofurl_4="Electrolize";}
elseif ($goofont4=="Fresca") {$goofurl_4="Fresca";}
elseif ($goofont4=="Vigo") {$goofurl_4="Vigo";}
elseif ($goofont4=="Bilbo") {$goofurl_4="Bilbo";}
elseif ($goofont4=="Cabin Condensed") {$goofurl_4="Cabin+Condensed";}
elseif ($goofont4=="Dr Sugiyama") {$goofurl_4="Dr+Sugiyama";}
elseif ($goofont4=="Herr Von Muellerhoff") {$goofurl_4="Herr+Von+Muellerhoff";}
elseif ($goofont4=="Miss Fajardose") {$goofurl_4="Miss+Fajardose";}
elseif ($goofont4=="Miss Saint Delafield") {$goofurl_4="Miss+Saint+Delafield";}
elseif ($goofont4=="Monsieur La Doulaise") {$goofurl_4="Monsieur+La+Doulaise";}
elseif ($goofont4=="Mr Bedford") {$goofurl_4="Mr+Bedford";}
elseif ($goofont4=="Mr Dafoe") {$goofurl_4="Mr+Dafoe";}
elseif ($goofont4=="Mr De Gaviland") {$goofurl_4="Mr+De+Gaviland";}
elseif ($goofont4=="Mrs Sheppards") {$goofurl_4="Mrs+Sheppards";}
elseif ($goofont4=="Aguafina Script") {$goofurl_4="Aguafina+Script";}
elseif ($goofont4=="Piedra") {$goofurl_4="Piedra";}
elseif ($goofont4=="Aladin") {$goofurl_4="Aladin";}
elseif ($goofont4=="Chicle") {$goofurl_4="Chicle";}
elseif ($goofont4=="Cagliostro") {$goofurl_4="Cagliostro";}
elseif ($goofont4=="Lemon") {$goofurl_4="Lemon";}
elseif ($goofont4=="Unlock") {$goofurl_4="Unlock";}
elseif ($goofont4=="Signika") {$goofurl_4="Signika";}
elseif ($goofont4=="Signika Negaive") {$goofurl_4="Signika+Negative";}
elseif ($goofont4=="Niconne") {$goofurl_4="Niconne";}
elseif ($goofont4=="Knewave") {$goofurl_4="Knewave";}
elseif ($goofont4=="Righteous") {$goofurl_4="Righteous";}
elseif ($goofont4=="Ribeye") {$goofurl_4="Ribeye";}
elseif ($goofont4=="Ribeye Marrow") {$goofurl_4="Ribeye+Marrow";}
elseif ($goofont4=="Spirax") {$goofurl_4="Spirax";}
elseif ($goofont4=="Concert One") {$goofurl_4="Concert+One";}
elseif ($goofont4=="Bubblegun Sans") {$goofurl_4="Bubblegun+Sans";}
elseif ($goofont4=="Iceland") {$goofurl_4="Iceland";}
elseif ($goofont4=="Devonshire") {$goofurl_4="Devonshire";}
elseif ($goofont4=="Fondamento") {$goofurl_4="Fondamento";}
elseif ($goofont4=="Bitter") {$goofurl_4="Bitter";}
elseif ($goofont4=="Convergence") {$goofurl_4="Convergence";}
elseif ($goofont4=="Lancelot") {$goofurl_4="Lancelot";}
elseif ($goofont4=="Petrona") {$goofurl_4="Petrona";}
elseif ($goofont4=="Supermercado One") {$goofurl_4="Supermercado+One";}
elseif ($goofont4=="Arapey") {$goofurl_4="Arapey";}
elseif ($goofont4=="Mate") {$goofurl_4="Mate";}
elseif ($goofont4=="Mate SC") {$goofurl_4="Mate+SC";}
elseif ($goofont4=="Rammetto One") {$goofurl_4="Rammetto+One";}
elseif ($goofont4=="Fjord One") {$goofurl_4="Fjord+One";}
elseif ($goofont4=="Cabin Sketch") {$goofurl_4="Cabin+Sketch";}
elseif ($goofont4=="Jockey One") {$goofurl_4="Jockey+One";}
elseif ($goofont4=="Contrail One") {$goofurl_4="Contrail+One";}
elseif ($goofont4=="Atomic Age") {$goofurl_4="Atomic+Age";}
elseif ($goofont4=="Corben") {$goofurl_4="Corben";}
elseif ($goofont4=="Linden Hill") {$goofurl_4="Linden+Hill";}
elseif ($goofont4=="Quicksand") {$goofurl_4="Quicksand";}
elseif ($goofont4=="Amatic SC") {$goofurl_4="Amatic+SC";}
elseif ($goofont4=="Salsa") {$goofurl_4="Salsa";}
elseif ($goofont4=="Marck Script") {$goofurl_4="Marck+Script";}
elseif ($goofont4=="Vast Shadow") {$goofurl_4="Vast+Shadow";}
elseif ($goofont4=="Cookie") {$goofurl_4="Cookie";}
elseif ($goofont4=="Pinyon Script") {$goofurl_4="Pinyon+Script";}
elseif ($goofont4=="Satisfy") {$goofurl_4="Satisfy";}
elseif ($goofont4=="Rancho") {$goofurl_4="Rancho";}
elseif ($goofont4=="Coda") {$goofurl_4="Coda";}
elseif ($goofont4=="Sancheek") {$goofurl_4="Sancheek";}
elseif ($goofont4=="Ubunto Mon") {$goofurl_4="Ubunto+Mon";}
elseif ($goofont4=="Unbunto Condensed") {$goofurl_4="Ubunto+Condensed";}
elseif ($goofont4=="Federant") {$goofurl_4="Federant";}
elseif ($goofont4=="Andada") {$goofurl_4="Andada";}
elseif ($goofont4=="Poly") {$goofurl_4="Poly";}
elseif ($goofont4=="Gochi Hand") {$goofurl_4="Gochi+Hand";}
elseif ($goofont4=="Alike Angular") {$goofurl_4="Alike+Angular";}
elseif ($goofont4=="Poller One") {$goofurl_4="Poller+One";}
elseif ($goofont4=="Chivo") {$goofurl_4="Chivo";}
elseif ($goofont4=="Sanista One") {$goofurl_4="Sanista+One";}
elseif ($goofont4=="Terminal Dosis") {$goofurl_4="Terminal+Dosis";}
elseif ($goofont4=="Sorts Mill Goudy") {$goofurl_4="Sorts+Mill+Goudy";}
elseif ($goofont4=="Adamina") {$goofurl_4="Adamina";}
elseif ($goofont4=="Prata") {$goofurl_4="Prata";}
elseif ($goofont4=="Julee") {$goofurl_4="Julee";}
elseif ($goofont4=="Changa One") {$goofurl_4="Changa+One";}
elseif ($goofont4=="Merienda One") {$goofurl_4="Merienda+One";}
elseif ($goofont4=="Prociono") {$goofurl_4="Prociono";}
elseif ($goofont4=="Passero One") {$goofurl_4="Passero+One";}
elseif ($goofont4=="Antic") {$goofurl_4="Antic";}
elseif ($goofont4=="Dorsa") {$goofurl_4="Dorsa";}
elseif ($goofont4=="Abril Fatface") {$goofurl_4="Abril+Fatface";}
elseif ($goofont4=="Delius Unicase") {$goofurl_4="Delius+Unicase";}
elseif ($goofont4=="Alike") {$goofurl_4="Alike";}
elseif ($goofont4=="Monoton") {$goofurl_4="Monoton";}
elseif ($goofont4=="Days One") {$goofurl_4="Days One";}
elseif ($goofont4=="Numans") {$goofurl_4="Numans";}
elseif ($goofont4=="Aldrich") {$goofurl_4="Aldrich";}
elseif ($goofont4=="Vidaloka") {$goofurl_4="Vidaloka";}
elseif ($goofont4=="Short Stack") {$goofurl_4="Short+Stack";}
elseif ($goofont4=="Montez") {$goofurl_4="Montez";}
elseif ($goofont4=="Voltaire") {$goofurl_4="Voltaire";}
elseif ($goofont4=="Geostar Fill") {$goofurl_4="Geostar+Fill";}
elseif ($goofont4=="Geostar") {$goofurl_4="Geostar";}
elseif ($goofont4=="Questrial") {$goofurl_4="Questrial";}
elseif ($goofont4=="Alice") {$goofurl_4="Alice";}
elseif ($goofont4=="Andika") {$goofurl_4="Andika";}
elseif ($goofont4=="Tulpen One") {$goofurl_4="Tulpen+One";}
elseif ($goofont4=="Smokum") {$goofurl_4="Smokum";}
elseif ($goofont4=="Delius Swash Caps") {$goofurl_4="Delius+Swash+Caps";}
elseif ($goofont4=="Actor") {$goofurl_4="Actor";}
elseif ($goofont4=="Abel") {$goofurl_4="Abel";}
elseif ($goofont4=="Rationale") {$goofurl_4="Rationale";}
elseif ($goofont4=="Rochester") {$goofurl_4="Rochester";}
elseif ($goofont4=="Delius") {$goofurl_4="Delius";}
elseif ($goofont4=="Federo") {$goofurl_4="Federo";}
elseif ($goofont4=="Aubrey") {$goofurl_4="Aubrey";}
elseif ($goofont4=="Carme") {$goofurl_4="Carme";}
elseif ($goofont4=="Black Ops One") {$goofurl_4="Black+Ops+One";}
elseif ($goofont4=="Kelly Slab") {$goofurl_4="Kelly+Slab";}
elseif ($goofont4=="Gloria Hallelujah") {$goofurl_4="Gloria+Hallelujah";}
elseif ($goofont4=="Ovo") {$goofurl_4="Ovo";}
elseif ($goofont4=="Snippet") {$goofurl_4="Snippet";}
elseif ($goofont4=="Leckerli One") {$goofurl_4="Leckerli+One";}
elseif ($goofont4=="Rosario") {$goofurl_4="Rosario";}
elseif ($goofont4=="Unna") {$goofurl_4="Unna";}
elseif ($goofont4=="Pompiere") {$goofurl_4="Pompiere";}
elseif ($goofont4=="Yellowtail") {$goofurl_4="Yellowtail";}
elseif ($goofont4=="Modern Antiqua") {$goofurl_4="Modern+Antiqua";}
elseif ($goofont4=="Give You Glory") {$goofurl_4="Give+You+Glory";}
elseif ($goofont4=="Yeseva One") {$goofurl_4="Yeseva+One";}
elseif ($goofont4=="Varela Round") {$goofurl_4="Varela+Round";}
elseif ($goofont4=="Patrick Hand") {$goofurl_4="Patrick+Hand";}
elseif ($goofont4=="Forum") {$goofurl_4="Forum";}
elseif ($goofont4=="Bowlby One") {$goofurl_4="Bowlby+One";}
elseif ($goofont4=="Bowlby One SC") {$goofurl_4="Bowlby+One+SC";}
elseif ($goofont4=="Loved by the King") {$goofurl_4="Loved+by+the+King";}
elseif ($goofont4=="Love Ya Like A Sister") {$goofurl_4="Love+Ya+Like+A+Sister";}
elseif ($goofont4=="Stardos Stencil") {$goofurl_4="Stardos+Stencil";}
elseif ($goofont4=="Hammersmith One") {$goofurl_4="Hammersmith+One";}
elseif ($goofont4=="Gravitas One") {$goofurl_4="Gravitas+One";}
elseif ($goofont4=="Asset") {$goofurl_4="Asset";}
elseif ($goofont4=="Goblin One") {$goofurl_4="Goblin+One";}
elseif ($goofont4=="Varela") {$goofurl_4="Varela";}
elseif ($goofont4=="Fanwood Text") {$goofurl_4="Fanwood+Text";$goofont4="Fanwood Text";}
elseif ($goofont4=="Fanwood Text") {$goofurl_4="Fanwood+Text:400italic";$goofont4="Fanwood Text";}
elseif ($goofont4=="Gentium Basic") {$goofurl_4="Gentium+Basic";$goofont4="Gentium Basic";}
elseif ($goofont4=="Gentium Basic Italic") {$goofurl_4="Gentium+Basic:400italic";$goofont4="Gentium Basic";}
elseif ($goofont4=="Gentium Basic Bold") {$goofurl_4="Gentium+Basic:700";$goofont4="Gentium Basic";}
elseif ($goofont4=="Gentium Basic Bold Italic") {$goofurl_4="Gentium+Basic:700italic";$goofont4="Gentium Basic";}
elseif ($goofont4=="Gentium Book Basic") {$goofurl_4="Gentium+Book+Basic";$goofont4="Gentium Book Basic";}
elseif ($goofont4=="Gentium Book Basic Italic") {$goofurl_4="Gentium+Book+Basic:400italic";$goofont4="Gentium Book Basic";}
elseif ($goofont4=="Gentium Book Basic Bold") {$goofurl_4="Gentium+Book+Basic:700";$goofont4="Gentium Book Basic";}
elseif ($goofont4=="Gentium Book Basic Bold Italic") {$goofurl_4="Gentium+Book+Basic:700italic";$goofont4="Gentium Book Basic";}
elseif ($goofont4=="Volkhov") {$goofurl_4="Volkhov";$goofont4="Volkhov";}
elseif ($goofont4=="Volkhov Italic") {$goofurl_4="Volkhov:400italic";$goofont4="Volkhov";}
elseif ($goofont4=="Volkhov Bold") {$goofurl_4="Volkhov:700";$goofont4="Volkhov";}
elseif ($goofont4=="Volkhov Bold Italic") {$goofurl_4="Volkhov:700italic";$goofont4="Volkhov";}
elseif ($goofont4=="Comfortaa Book") {$goofurl_4="Comfortaa:300";$goofont4="Comfortaa";}
elseif ($goofont4=="Comfortaa Normal") {$goofurl_4="Comfortaa";$goofont4="Comfortaa";}
elseif ($goofont4=="Comfortaa Bold") {$goofurl_4="Comfortaa:700";$goofont4="Comfortaa";}
elseif ($goofont4=="Coustard") {$goofurl_4="Coustard";$goofont4="Coustard";}
elseif ($goofont4=="Coustard Ultra Bold") {$goofurl_4="Coustard:900";$goofont4="Coustard";}
elseif ($goofont4=="Marvel") {$goofurl_4="Marvel";$goofont4="Marvel";}
elseif ($goofont4=="Marvel Italic") {$goofurl_4="Marvel:400italic";$goofont4="Marvel";}
elseif ($goofont4=="Marvel Bold") {$goofurl_4="Marvel:700";$goofont4="Marvel";}
elseif ($goofont4=="Marvel Bold Italic") {$goofurl_4="Marvel:700italic";$goofont4="Marvel";}
elseif ($goofont4=="Istok Web") {$goofurl_4="Istok+Web";$goofont4="Istok Web";}
elseif ($goofont4=="Istok Web Italic") {$goofurl_4="Istok+Web:400italic";$goofont4="Istok Web";}
elseif ($goofont4=="Istok Web Bold") {$goofurl_4="Istok+Web:700";$goofont4="Istok Web";}
elseif ($goofont4=="Istok Web Bold Italic") {$goofurl_4="Istok+Web:700italic";$goofont4="Istok Web";}
elseif ($goofont4=="Tienne") {$goofurl_4="Tienne";$goofont4="Tienne";}
elseif ($goofont4=="Tienne Bold") {$goofurl_4="Tienne:700";$goofont4="Tienne";}
elseif ($goofont4=="Tienne Ultra Bold") {$goofurl_4="Tienne:900";$goofont4="Tienne";}
elseif ($goofont4=="Nixie One") {$goofurl_4="Nixie+One";}
elseif ($goofont4=="Redressed") {$goofurl_4="Redressed";}
elseif ($goofont4=="Lobster Two") {$goofurl_4="Lobster+Two";$goofont4="Lobster Two";}
elseif ($goofont4=="Lobster Two Italic") {$goofurl_4="Lobster+Two:400italic";$goofont4="Lobster Two";}
elseif ($goofont4=="Lobster Two Bold") {$goofurl_4="Lobster+Two:700";$goofont4="Lobster Two";}
elseif ($goofont4=="Lobster Two Bold Italic") {$goofurl_4="Lobster+Two:700italic";$goofont4="Lobster Two";}
elseif ($goofont4=="Caudex") {$goofurl_4="Caudex";}
elseif ($goofont4=="Jura") {$goofurl_4="Jura";}
elseif ($goofont4=="Ruslan Display") {$goofurl_4="Ruslan+Display";}
elseif ($goofont4=="Brawler") {$goofurl_4="Brawler";}
elseif ($goofont4=="Nunito") {$goofurl_4="Nunito";}
elseif ($goofont4=="Wire One") {$goofurl_4="Wire+One";}
elseif ($goofont4=="Podkova") {$goofurl_4="Podkova";}
elseif ($goofont4=="Muli") {$goofurl_4="Muli";}
elseif ($goofont4=="Maven Pro") {$goofurl_4="Maven+Pro";}
elseif ($goofont4=="Tenor Sans") {$goofurl_4="Tenor+Sans";}
elseif ($goofont4=="Limelight") {$goofurl_4="Limelight";}
elseif ($goofont4=="Playfair Display") {$goofurl_4="Playfair+Display";}
elseif ($goofont4=="Artifika") {$goofurl_4="Artifika";}
elseif ($goofont4=="Lora") {$goofurl_4="Lora";}
elseif ($goofont4=="Kameron") {$goofurl_4="Kameron";}
elseif ($goofont4=="Cedarville Cursive") {$goofurl_4="Cedarville+Cursive";}
elseif ($goofont4=="Zeyada") {$goofurl_4="Zeyada";}
elseif ($goofont4=="La Belle Aurore") {$goofurl_4="La+Belle+Aurore";}
elseif ($goofont4=="Shadows into Light") {$goofurl_4="Shadows+Into+Light";}
elseif ($goofont4=="Shanti") {$goofurl_4="Shanti";}
elseif ($goofont4=="Mako") {$goofurl_4="Mako";}
elseif ($goofont4=="Metrophobic") {$goofurl_4="Metrophobic";}
elseif ($goofont4=="Ultra") {$goofurl_4="Ultra";}
elseif ($goofont4=="Play") {$goofurl_4="Play";}
elseif ($goofont4=="Didact Gothic") {$goofurl_4="Didact+Gothic";}
elseif ($goofont4=="Judson") {$goofurl_4="Judson";}
elseif ($goofont4=="Megrim") {$goofurl_4="Megrim";}
elseif ($goofont4=="Rokkitt") {$goofurl_4="Rokkitt";}
elseif ($goofont4=="Monofett") {$goofurl_4="Monofett";}
elseif ($goofont4=="Paytone One") {$goofurl_4="Paytone+One";}
elseif ($goofont4=="Holtwood One SC") {$goofurl_4="Holtwood+One+SC";}
elseif ($goofont4=="Carter One") {$goofurl_4="Carter+One";}
elseif ($goofont4=="Francois One") {$goofurl_4="Francois+One";}
elseif ($goofont4=="Bigshot One") {$goofurl_4="Bigshot+One";}
elseif ($goofont4=="Sigmar One") {$goofurl_4="Sigmar+One";}
elseif ($goofont4=="Swanky and Moo Moo") {$goofurl_4="Swanky+and+Moo+Moo";}
elseif ($goofont4=="Over the Rainbow") {$goofurl_4="Over+the+Rainbow";}
elseif ($goofont4=="Wallpoet") {$goofurl_4="Wallpoet";}
elseif ($goofont4=="Damion") {$goofurl_4="Damion";}
elseif ($goofont4=="News Cycle") {$goofurl_4="News+Cycle";}
elseif ($goofont4=="Aclonica") {$goofurl_4="Aclonica";}
elseif ($goofont4=="Special Elite") {$goofurl_4="Special+Elite";}
elseif ($goofont4=="Smythe") {$goofurl_4="Smythe";}
elseif ($goofont4=="Quattrocento Sans") {$goofurl_4="Quattrocento+Sans";}
elseif ($goofont4=="The Girl Next Door") {$goofurl_4="The+Girl+Next+Door";}
elseif ($goofont4=="Sue Ellen Francisco") {$goofurl_4="Sue+Ellen+Francisco";}
elseif ($goofont4=="Dawning of a New Day") {$goofurl_4="Dawning+of+a+New+Day";}
elseif ($goofont4=="Waiting for the Sunrise") {$goofurl_4="Waiting+for+the+Sunrise";}
elseif ($goofont4=="Annie Use Your Telescope") {$goofurl_4="Annie+Use+Your+Telescope";}
elseif ($goofont4=="Maiden Orange") {$goofurl_4="Maiden+Orange";}
elseif ($goofont4=="Luckiest Guy") {$goofurl_4="Luckiest+Guy";}
elseif ($goofont4=="Bangers") {$goofurl_4="Bangers";}
elseif ($goofont4=="Miltonian") {$goofurl_4="Miltonian";}
elseif ($goofont4=="Miltonian Tattoo") {$goofurl_4="Miltonian+Tattoo";}
elseif ($goofont4=="Allerta") {$goofurl_4="Allerta";}
elseif ($goofont4=="Allerta Stencil") {$goofurl_4="Allerta+Stencil";}
elseif ($goofont4=="Amaranth") {$goofurl_4="Amaranth";}
elseif ($goofont4=="Anonymous Pro") {$goofurl_4="Anonymous+Pro";}
elseif ($goofont4=="Anonymous Pro Italic") {$goofurl_4="Anonymous+Pro:italic";$goofont4="Anonymous Pro";}
elseif ($goofont4=="Anonymous Pro Bold") {$goofurl_4="Anonymous+Pro:bold";$goofont4="Anonymous Pro";}
elseif ($goofont4=="Anonymous Pro Bold Italic") {$goofurl_4="Anonymous+Pro:bolditalic";$goofont4="Anonymous Pro";}
elseif ($goofont4=="Anton") {$goofurl_4="Anton";}
elseif ($goofont4=="Architects Daughter") {$goofurl_4="Architects+Daughter";}
elseif ($goofont4=="Arimo") {$goofurl_4="Arimo";}
elseif ($goofont4=="Arimo Italic") {$goofurl_4="Arimo:italic";$goofont4="Arimo";}
elseif ($goofont4=="Arimo Bold") {$goofurl_4="Arimo:bold";$goofont4="Arimo";}
elseif ($goofont4=="Arimo Bold Italic") {$goofurl_4="Arimo:bolditalic";$goofont4="Arimo";}
elseif ($goofont4=="Arvo") {$goofurl_4="Arvo"; $goofont4="Arvo";}
elseif ($goofont4=="Arvo Italic") {$goofurl_4="Arvo:italic"; $goofont4="Arvo";}
elseif ($goofont4=="Arvo Bold") {$goofurl_4="Arvo:bold"; $goofont4="Arvo";}
elseif ($goofont4=="Arvo Bold Italic") {$goofurl_4="Arvo:bolditalic"; $goofont4="Arvo";}
elseif ($goofont4=="Astloch") {$goofurl_4="Astloch";}
elseif ($goofont4=="Astloch Bold") {$goofurl_4="Astloch:bold"; $goofont4="Astloch";}
elseif ($goofont4=="Bentham") {$goofurl_4="Bentham";}
elseif ($goofont4=="Bevan") {$goofurl_4="Bevan";}
elseif ($goofont4=="Buda") {$goofurl_4="Buda:light";}
elseif ($goofont4=="Cabin") {$goofurl_4="Cabin:regular";}
elseif ($goofont4=="Cabin Italic") {$goofurl_4="Cabin:regularitalic";$goofont4="Cabin";}
elseif ($goofont4=="Cabin Bold") {$goofurl_4="Cabin:bold";$goofont4="Cabin";}
elseif ($goofont4=="Cabin Bold Italic") {$goofurl_4="Cabin:bolditalic";$goofont4="Cabin";}
elseif ($goofont4=="Cabin Sketch") {$goofurl_4="Cabin+Sketch:bold";}
elseif ($goofont4=="Calligraffitti") {$goofurl_4="Calligraffitti";}
elseif ($goofont4=="Candal") {$goofurl_4="Candal";}
elseif ($goofont4=="Cantarell") {$goofurl_4="Cantarell";}
elseif ($goofont4=="Cantarell Italic") {$goofurl_4="Cantarell:italic";$goofont4="Cantarell";}
elseif ($goofont4=="Cantarell Bold") {$goofurl_4="Cantarell:bold";$goofont4="Cantarell";}
elseif ($goofont4=="Cantarell Bold Italic") {$goofurl_4="Cantarell:bolditalic";$goofont4="Cantarell";}
elseif ($goofont4=="Cardo") {$goofurl_4="Cardo";}
elseif ($goofont4=="Cherry Cream Soda") {$goofurl_4="Cherry+Cream+Soda";}
elseif ($goofont4=="Chewy") {$goofurl_4="Chewy";}
elseif ($goofont4=="Coda") {$goofurl_4="Coda:800";}
elseif ($goofont4=="Coda Caption") {$goofurl_4="Coda+Caption:800";}
elseif ($goofont4=="Coming Soon") {$goofurl_4="Coming+Soon";}
elseif ($goofont4=="Copse") {$goofurl_4="Copse";}
elseif ($goofont4=="Corben") {$goofurl_4="Corben:bold";}
elseif ($goofont4=="Cousine") {$goofurl_4="Cousine";}
elseif ($goofont4=="Cousine Italic") {$goofurl_4="Cousine:italic";$goofont4="Cousine";}
elseif ($goofont4=="Cousine Bold") {$goofurl_4="Cousine:bold";$goofont4="Cousine";}
elseif ($goofont4=="Cousine Bold Italic") {$goofurl_4="Cousine:bolditalic";$goofont4="Cousine";}
elseif ($goofont4=="Covered By Your Grace") {$goofurl_4="Covered+By+Your+Grace";}
elseif ($goofont4=="Crafty Girls") {$goofurl_4="Crafty+Girls";}
elseif ($goofont4=="Crimson Text") {$goofurl_4="Crimson+Text";}
elseif ($goofont4=="Crimson Text Italic") {$goofurl_4="Crimson+Text:italic";$goofont4="Crimson Text";}
elseif ($goofont4=="Crimson Text Bold") {$goofurl_4="Crimson+Text:bold";$goofont4="Crimson Text";}
elseif ($goofont4=="Crimson Text Bold Italic") {$goofurl_4="Crimson+Text:bolditalic";$goofont4="Crimson Text";}
elseif ($goofont4=="Crushed") {$goofurl_4="Crushed";}
elseif ($goofont4=="Cuprum") {$goofurl_4="Cuprum";}
elseif ($goofont4=="Droid Sans") {$goofurl_4="Droid+Sans";}
elseif ($goofont4=="Droid Sans Bold") {$goofurl_4="Droid+Sans:bold"; $goofont4="Droid Sans";}
elseif ($goofont4=="Droid Sans Mono") {$goofurl_4="Droid+Sans+Mono";}
elseif ($goofont4=="Droid Serif") {$goofurl_4="Droid+Serif";}
elseif ($goofont4=="Droid Serif Italic") {$goofurl_4="Droid+Serif:italic";$goofont4="Droid Serif";}
elseif ($goofont4=="Droid Serif Bold") {$goofurl_4="Droid+Serif:bold";$goofont4="Droid Serif";}
elseif ($goofont4=="Droid Serif Bold Italic") {$goofurl_4="Droid+Serif:bolditalic";$goofont4="Droid Serif";}
elseif ($goofont4=="EB Garamond") {$goofurl_4="EB+Garamond";}
elseif ($goofont4=="Expletus Sans") {$goofurl_4="Expletus+Sans";}
elseif ($goofont4=="Expletus Sans Bold") {$goofurl_4="Expletus+Sans:bold";$goofont4="Expletus Sans";}
elseif ($goofont4=="Fontdiner Swanky") {$goofurl_4="Fontdiner+Swanky";}
elseif ($goofont4=="Geo") {$goofurl_4="Geo";}
elseif ($goofont4=="Goudy Bookletter 1911") {$goofurl_4="Goudy+Bookletter+1911";}
elseif ($goofont4=="Gruppo") {$goofurl_4="Gruppo";}
elseif ($goofont4=="Homemade Apple") {$goofurl_4="Homemade+Apple";}
elseif ($goofont4=="IM Fell Double Pica") {$goofurl_4="IM+Fell+Double+Pica";$goofont4="IM Fell Double Pica";}
elseif ($goofont4=="IM Fell Double Pica Italic") {$goofurl_4="IM+Fell+Double+Pica:italic";$goofont4="IM Fell Double Pica";}
elseif ($goofont4=="IM Fell Double Pica SC") {$goofurl_4="IM+Fell+Double+Pica+SC";}
elseif ($goofont4=="IM Fell DW Pica") {$goofurl_4="IM+Fell+DW+Pica";$goofont4="IM Fell DW Pica";}
elseif ($goofont4=="IM Fell DW Pica Italic") {$goofurl_4="IM+Fell+DW+Pica:italic";$goofont4="IM Fell DW Pica";}
elseif ($goofont4=="IM Fell DW Pica SC") {$goofurl_4="IM+Fell+DW+Pica+SC";}
elseif ($goofont4=="IM Fell English") {$goofurl_4="IM+Fell+English";$goofont4="IM Fell English";}
elseif ($goofont4=="IM Fell English Italic") {$goofurl_4="IM+Fell+English:italic";$goofont4="IM Fell English";}
elseif ($goofont4=="IM Fell English SC") {$goofurl_4="IM+Fell+English+SC";}
elseif ($goofont4=="IM Fell French Canon") {$goofurl_4="IM+Fell+French+Canon";$goofont4="IM Fell French Canon";}
elseif ($goofont4=="IM Fell French Canon Italic") {$goofurl_4="IM+Fell+French+Canon:italic";$goofont4="IM Fell French Canon";}
elseif ($goofont4=="IM Fell French Canon SC") {$goofurl_4="IM+Fell+French+Canon+SC";}
elseif ($goofont4=="IM Fell Great Primer") {$goofurl_4="IM+Fell+Great+Primer";$goofont4="IM Fell Great Primer";}
elseif ($goofont4=="IM Fell Great Primer Italic") {$goofurl_4="IM+Fell+Great+Primer:italic";$goofont4="IM Fell Great Primer";}
elseif ($goofont4=="IM Fell Great Primer SC") {$goofurl_4="IM+Fell+Great+Primera+SC";}
elseif ($goofont4=="Inconsolata") {$goofurl_4="Inconsolata";}
elseif ($goofont4=="Indie Flower") {$goofurl_4="Indie+Flower";}
elseif ($goofont4=="Irish Grover") {$goofurl_4="Irish+Grover";}
elseif ($goofont4=="Josefin Sans") {$goofurl_4="Josefin+Sans";}
elseif ($goofont4=="Josefin Sans Italic") {$goofurl_4="Josefin+Sans:regularitalic"; $goofont4="Josefin Sans";}
elseif ($goofont4=="Josefin Sans Bold") {$goofurl_4="Josefin+Sans:bold"; $goofont4="Josefin Sans";}
elseif ($goofont4=="Josefin Sans Bold Italic") {$goofurl_4="Josefin+Sans:bolditalic"; $goofont4="Josefin Sans";}
elseif ($goofont4=="Josefin Slab") {$goofurl_4="Josefin+Slab";}
elseif ($goofont4=="Just Another Hand") {$goofurl_4="Just+Another+Hand";}
elseif ($goofont4=="Just Me Again Down Here") {$goofurl_4="Just+Me+Again+Down+Here";}
elseif ($goofont4=="Kenia") {$goofurl_4="Kenia";}
elseif ($goofont4=="Kranky") {$goofurl_4="Kranky";}
elseif ($goofont4=="Kreon") {$goofurl_4="Kreon";}
elseif ($goofont4=="Kreon Bold") {$goofurl_4="Kreon:bold"; $goofont4="Kreon";}
elseif ($goofont4=="Kristi") {$goofurl_4="Kristi";}
elseif ($goofont4=="Lato") {$goofurl_4="Lato";}
elseif ($goofont4=="Lato Italic") {$goofurl_4="Lato:regularitalic";$goofont4="Lato";}
elseif ($goofont4=="Lato Bold") {$goofurl_4="Lato:bold";$goofont4="Lato";}
elseif ($goofont4=="Lato Bold Italic") {$goofurl_4="Lato:bolditalic";$goofont4="Lato";}
elseif ($goofont4=="League Script") {$goofurl_4="League+Script";}
elseif ($goofont4=="Lekton") {$goofurl_4="Lekton";}
elseif ($goofont4=="Lekton Italic") {$goofurl_4="Lekton:italic"; $goofont4="Lekton";}
elseif ($goofont4=="Lekton Bold") {$goofurl_4="Lekton:bold"; $goofont4="Lekton";}
elseif ($goofont4=="Lobster") {$goofurl_4="Lobster";}
elseif ($goofont4=="MedievalSharp") {$goofurl_4="MedievalSharp";}
elseif ($goofont4=="Merriweather") {$goofurl_4="Merriweather";}
elseif ($goofont4=="Michroma") {$goofurl_4="Michroma";}
elseif ($goofont4=="Molengo") {$goofurl_4="Molengo";}
elseif ($goofont4=="Mountains of Christmas") {$goofurl_4="Mountains+of+Christmas";}
elseif ($goofont4=="Neucha") {$goofurl_4="Neucha";}
elseif ($goofont4=="Neuton") {$goofurl_4="Neuton";}
elseif ($goofont4=="Neuton Italic") {$goofurl_4="Neuton:italic"; $goofont4="Neuton";}
elseif ($goofont4=="Nobile") {$goofurl_4="Nobile";}
elseif ($goofont4=="Nobile Italic") {$goofurl_4="Nobile:italic"; $goofont4="Nobile";}
elseif ($goofont4=="Nobile Bold") {$goofurl_4="Nobile:bold"; $goofont4="Nobile";}
elseif ($goofont4=="Nobile Bold Italic") {$goofurl_4="Nobile:bolditalic"; $goofont4="Nobile";}
elseif ($goofont4=="Nova Round") {$goofurl_4="Nova+Round";}
elseif ($goofont4=="Nova Script") {$goofurl_4="Nova+Script";}
elseif ($goofont4=="Nova Slim") {$goofurl_4="Nova+Slim";}
elseif ($goofont4=="Nova Cut") {$goofurl_4="Nova+Cut";}
elseif ($goofont4=="Nova Oval") {$goofurl_4="Nova+Oval";}
elseif ($goofont4=="Nova Mono") {$goofurl_4="Nova+Mono";}
elseif ($goofont4=="Nova Flat") {$goofurl_4="Nova+Flat";}
elseif ($goofont4=="OFL Sorts Mill Goudy TT") {$goofurl_4="OFL+Sorts+Mill+Goudy+TT";}
elseif ($goofont4=="OFL Sorts Mill Goudy TT Italic") {$goofurl_4="OFL+Sorts+Mill+Goudy+TT:italic";$goofont4="OFL Sorts Mill Goudy TT";}
elseif ($goofont4=="Old Standard TT") {$goofurl_4="Old+Standard+TT";}
elseif ($goofont4=="Old Standard TT Italic") {$goofurl_4="Old+Standard+TT:italic";$goofont4="Old Standard TT";}
elseif ($goofont4=="Old Standard TT Bold") {$goofurl_4="Old+Standard+TT:bold";$goofont4="Old Standard TT";}
elseif ($goofont4=="Orbitron") {$goofurl_4="Orbitron";}
elseif ($goofont4=="Orbitron Italic") {$goofurl_4="Orbitron:italic";$goofont4="Orbitron";}
elseif ($goofont4=="Orbitron Bold") {$goofurl_4="Orbitron:bold";$goofont4="Orbitron";}
elseif ($goofont4=="Orbitron Bold Italic") {$goofurl_4="Orbitron:bolditalic";$goofont4="Orbitron";}
elseif ($goofont4=="Oswald") {$goofurl_4="Oswald";}
elseif ($goofont4=="Pacifico") {$goofurl_4="Pacifico";}
elseif ($goofont4=="Permanent Marker") {$goofurl_4="Permanent+Marker";}
elseif ($goofont4=="PT Sans") {$goofurl_4="PT+Sans";}
elseif ($goofont4=="PT Sans Italic") {$goofurl_4="PT+Sans:italic";}
elseif ($goofont4=="PT Sans Bold") {$goofurl_4="PT+Sans:bold";}
elseif ($goofont4=="PT Sans Bold Italic") {$goofurl_4="PT+Sans:bolditalic";}
elseif ($goofont4=="PT Sans Caption") {$goofurl_4="PT+Sans+Caption";}
elseif ($goofont4=="PT Sans Caption Bold") {$goofurl_4="PT+Sans+Caption:bold"; $goofont4="PT Sans Caption";}
elseif ($goofont4=="PT Sans Narrow") {$goofurl_4="PT+Sans+Narrow";}
elseif ($goofont4=="PT Sans Narrow Bold") {$goofurl_4="PT+Sans+Narrow:bold"; $goofont4="PT Sans Narrow";}
elseif ($goofont4=="PT Serif") {$goofurl_4="PT+Serif";}
elseif ($goofont4=="PT Serif Italic") {$goofurl_4="PT+Serif:italic";$goofont4="PT Serif";}
elseif ($goofont4=="PT Serif Bold") {$goofurl_4="PT+Serif:bold";$goofont4="PT Serif";}
elseif ($goofont4=="PT Serif Bold Italic") {$goofurl_4="PT+Serif:bolditalic";$goofont4="PT Serif";}
elseif ($goofont4=="PT Serif Caption") {$goofurl_4="PT+Serif+Caption";}
elseif ($goofont4=="PT Serif Caption Bold") {$goofurl_4="PT+Serif+Caption+Bold"; $goofont4="PT Serif Caption";}
elseif ($goofont4=="Philosopher") {$goofurl_4="Philosopher";}
elseif ($goofont4=="Puritan") {$goofurl_4="Puritan";}
elseif ($goofont4=="Puritan Italic") {$goofurl_4="Puritan:italic";$goofont4="Puritan";}
elseif ($goofont4=="Puritan Bold") {$goofurl_4="Puritan:bold";$goofont4="Puritan";}
elseif ($goofont4=="Puritan Bold Italic") {$goofurl_4="Puritan:bolditalic";$goofont4="Puritan";}
elseif ($goofont4=="Quattrocento") {$goofurl_4="Quattrocento";}
elseif ($goofont4=="Raleway") {$goofurl_4="Raleway:100";}
elseif ($goofont4=="Reenie Beanie") {$goofurl_4="Reenie+Beanie";}
elseif ($goofont4=="Rock Salt") {$goofurl_4="Rock+Salt";}
elseif ($goofont4=="Schoolbell") {$goofurl_4="Schoolbell";}
elseif ($goofont4=="Slackey") {$goofurl_4="Slackey";}
elseif ($goofont4=="Sniglet") {$goofurl_4="Sniglet:800";}
elseif ($goofont4=="Sunshiney") {$goofurl_4="Sunshiney";}
elseif ($goofont4=="Syncopate") {$goofurl_4="Syncopate";}
elseif ($goofont4=="Tangerine") {$goofurl_4="Tangerine";}
elseif ($goofont4=="Terminal Dosis Light") {$goofurl_4="Terminal Dosis Light";}
elseif ($goofont4=="Tinos") {$goofurl_4="Tinos";}
elseif ($goofont4=="Tinos Italic") {$goofurl_4="Tinos:italic";$goofont4="Tinos";}
elseif ($goofont4=="Tinos Bold") {$goofurl_4="Tinos:bold";$goofont4="Tinos";}
elseif ($goofont4=="Tinos Bold Italic") {$goofurl_4="Tinos:bolditalic";$goofont4="Tinos";}
elseif ($goofont4=="Ubuntu") {$goofurl_4="Ubuntu";}
elseif ($goofont4=="Ubuntu Italic") {$goofurl_4="Ubuntu:italic";$goofont4="Ubuntu";}
elseif ($goofont4=="Ubuntu Bold") {$goofurl_4="Ubuntu:bold";$goofont4="Ubuntu";}
elseif ($goofont4=="Ubuntu Bold Italic") {$goofurl_4="Ubuntu:bolditalic";$goofont4="Ubuntu";}
elseif ($goofont4=="UnifrakturCook") {$goofurl_4="UnifrakturCook:bold";}
elseif ($goofont4=="UnifrakturMaguntia") {$goofurl_4="UnifrakturMaguntia";}
elseif ($goofont4=="Unkempt") {$goofurl_4="Unkempt";}
elseif ($goofont4=="VT323") {$goofurl_4="VT323";}
elseif ($goofont4=="Vibur") {$goofurl_4="Vibur";}
elseif ($goofont4=="Vollkorn") {$goofurl_4="Vollkorn";}
elseif ($goofont4=="Vollkorn Italic") {$goofurl_4="Vollkorn:italic";$goofont4="Vollkorn";}
elseif ($goofont4=="Vollkorn Bold") {$goofurl_4="Vollkorn:bold";$goofont4="Vollkorn";}
elseif ($goofont4=="Vollkorn Bold Italic") {$goofurl_4="Vollkorn:bolditalic";$goofont4="Vollkorn";}
elseif ($goofont4=="Walter Turncoat") {$goofurl_4="Walter+Turncoat";}
elseif ($goofont4=="Yanone Kaffeesatz") {$goofurl_4="Yanone+Kaffeesatz";}
elseif ($goofont4=="Yanone Kaffeesatz Light") {$goofurl_4="Yanone+Kaffeesatz:light";$goofont4="Yanone Kaffeesatz";}
elseif ($goofont4=="Yanone Kaffeesatz Bold") {$goofurl_4="Yanone+Kaffeesatz:bold";$goofont4="Yanone Kaffeesatz";}
else ;

$goofurl_5 = '';
$goofont5 = '';
$goofont5 = $this->params->get( 'font-face-5' );
if ($goofont5=="Allan") {$goofurl_5="Allan:bold";}
elseif ($goofont5=="Exo") {$goofurl_5="Exo:400";$goofont1="Exo";}
elseif ($goofont5=="Exo Italic") {$goofurl_5="Exo:400italic";$goofont1="Exo";}
elseif ($goofont5=="Exo Bold") {$goofurl_5="Exo:700";$goofont1="Exo";}
elseif ($goofont5=="Exo Bold Italic") {$goofurl_5="Exo:700italic";$goofont1="Exo";}
elseif ($goofont5=="Chelsea Market") {$goofurl_5="Chelsea+Market";}
elseif ($goofont5=="Jim Nightmare") {$goofurl_5="Jim+Nightmare";}
elseif ($goofont5=="Oldenburg") {$goofurl_5="Oldenburg";}
elseif ($goofont5=="Spicy Rice") {$goofurl_5="Spicy+Rice";}
elseif ($goofont5=="Nosifer") {$goofurl_5="Nosifer";}
elseif ($goofont5=="Eater") {$goofurl_5="Eater";}
elseif ($goofont5=="Creepster") {$goofurl_5="Creepster";}
elseif ($goofont5=="Butcherman") {$goofurl_5="Butcherman";}
elseif ($goofont5=="Sofia") {$goofurl_5="Sofia";}
elseif ($goofont5=="Asul") {$goofurl_5="Asul";}
elseif ($goofont5=="Alex Brush") {$goofurl_5="Alex+Brush";}
elseif ($goofont5=="Arizonia") {$goofurl_5="Arizonia";}
elseif ($goofont5=="Italianno") {$goofurl_5="Italianno";}
elseif ($goofont5=="Qwigley") {$goofurl_5="Qwigley";}
elseif ($goofont5=="Ruge Boogie") {$goofurl_5="Ruge+Boogie";}
elseif ($goofont5=="Ruthie") {$goofurl_5="Ruthie";}
elseif ($goofont5=="Playball") {$goofurl_5="Playball";}
elseif ($goofont5=="Dynalight") {$goofurl_5="Dynalight";}
elseif ($goofont5=="Stoke") {$goofurl_5="Stoke";}
elseif ($goofont5=="Sarina") {$goofurl_5="Sarina";}
elseif ($goofont5=="Yesteryear") {$goofurl_5="Yesteryear";}
elseif ($goofont5=="Trade Winds") {$goofurl_5="Trade+Winds";}
elseif ($goofont5=="Frijole") {$goofurl_5="Frijole";}
elseif ($goofont5=="Trykker") {$goofurl_5="Trykker";}
elseif ($goofont5=="Sail") {$goofurl_5="Sail";}
elseif ($goofont5=="Quantico") {$goofurl_5="Quantico";}
elseif ($goofont5=="Patua One") {$goofurl_5="Patua+One";}
elseif ($goofont5=="Overlock") {$goofurl_5="Overlock";}
elseif ($goofont5=="Overlock SC") {$goofurl_5="Overlock+SC";}
elseif ($goofont5=="Habibi") {$goofurl_5="Habibi";}
elseif ($goofont5=="Noticia Text") {$goofurl_5="Noticia+Text";}
elseif ($goofont5=="Miniver") {$goofurl_5="Miniver";}
elseif ($goofont5=="Medula One") {$goofurl_5="Medula+One";}
elseif ($goofont5=="Inder") {$goofurl_5="Inder";}
elseif ($goofont5=="Fugaz One") {$goofurl_5="Fugaz+One";}
elseif ($goofont5=="Flavors") {$goofurl_5="Flavors";}
elseif ($goofont5=="Flamenco") {$goofurl_5="Flamenco";}
elseif ($goofont5=="Duru Sans") {$goofurl_5="Duru+Sans";}
elseif ($goofont5=="Crete Round") {$goofurl_5="Crete+Round";}
elseif ($goofont5=="Caesar Dressing") {$goofurl_5="Caesar+Dressing";}
elseif ($goofont5=="Cambo") {$goofurl_5="Cambo";}
elseif ($goofont5=="Bluenard") {$goofurl_5="Bluenard";}
elseif ($goofont5=="Bree Serif") {$goofurl_5="Bree+Serif";}
elseif ($goofont5=="Boogaloo") {$goofurl_5="Boogaloo";}
elseif ($goofont5=="Belgrano") {$goofurl_5="Belgrano";}
elseif ($goofont5=="Armata") {$goofurl_5="Armata";}
elseif ($goofont5=="Alfa Slab One") {$goofurl_5="Alfa+Slab+One";}
elseif ($goofont5=="Uncial Antiqua") {$goofurl_5="Uncial+Antique";}
elseif ($goofont5=="Almendra") {$goofurl_5="Almendra";}
elseif ($goofont5=="Almendra SC") {$goofurl_5="Almendra+SC";}
elseif ($goofont5=="Acme") {$goofurl_5="Acme";}
elseif ($goofont5=="Squada One") {$goofurl_5="Squada+One";}
elseif ($goofont5=="Basic") {$goofurl_5="Basic";}
elseif ($goofont5=="Bilbo Swash Caps") {$goofurl_5="Bilbo+Swash+Caps";}
elseif ($goofont5=="Marko One") {$goofurl_5="Marko+One";}
elseif ($goofont5=="Bad Script") {$goofurl_5="Bad+Script";}
elseif ($goofont5=="Plaster") {$goofurl_5="Plaster";}
elseif ($goofont5=="Handlee") {$goofurl_5="Handlee";}
elseif ($goofont5=="Bathazar") {$goofurl_5="Bathazar";}
elseif ($goofont5=="Passion One") {$goofurl_5="Passion+One";}
elseif ($goofont5=="Chango") {$goofurl_5="Chango";}
elseif ($goofont5=="Enriqueta") {$goofurl_5="Enriqueta";}
elseif ($goofont5=="Montserrat") {$goofurl_5="Montserrat";}
elseif ($goofont5=="Original Surfer") {$goofurl_5="Original+Surfer";}
elseif ($goofont5=="Baumans") {$goofurl_5="Baumans";}
elseif ($goofont5=="Fascinate") {$goofurl_5="Fascinate";}
elseif ($goofont5=="Fascinate Inline") {$goofurl_5="Fascinate+Inline";}
elseif ($goofont5=="Stint Ultra Condensed") {$goofurl_5="Stint+Ultra+Condensed";}
elseif ($goofont5=="Bonbon") {$goofurl_5="Bonbon";}
elseif ($goofont5=="Arbutus") {$goofurl_5="Arbutus";}
elseif ($goofont5=="Galdeano") {$goofurl_5="Galdeano";}
elseif ($goofont5=="Metamorphous") {$goofurl_5="Metamorphous";}
elseif ($goofont5=="Cevivhe One") {$goofurl_5="Cevivhe+One";}
elseif ($goofont5=="Marmelad") {$goofurl_5="Marmelad";}
elseif ($goofont5=="Engagement") {$goofurl_5="Engagement";}
elseif ($goofont5=="Electrolize") {$goofurl_5="Electrolize";}
elseif ($goofont5=="Fresca") {$goofurl_5="Fresca";}
elseif ($goofont5=="Vigo") {$goofurl_5="Vigo";}
elseif ($goofont5=="Bilbo") {$goofurl_5="Bilbo";}
elseif ($goofont5=="Cabin Condensed") {$goofurl_5="Cabin+Condensed";}
elseif ($goofont5=="Dr Sugiyama") {$goofurl_5="Dr+Sugiyama";}
elseif ($goofont5=="Herr Von Muellerhoff") {$goofurl_5="Herr+Von+Muellerhoff";}
elseif ($goofont5=="Miss Fajardose") {$goofurl_5="Miss+Fajardose";}
elseif ($goofont5=="Miss Saint Delafield") {$goofurl_5="Miss+Saint+Delafield";}
elseif ($goofont5=="Monsieur La Doulaise") {$goofurl_5="Monsieur+La+Doulaise";}
elseif ($goofont5=="Mr Bedford") {$goofurl_5="Mr+Bedford";}
elseif ($goofont5=="Mr Dafoe") {$goofurl_5="Mr+Dafoe";}
elseif ($goofont5=="Mr De Gaviland") {$goofurl_5="Mr+De+Gaviland";}
elseif ($goofont5=="Mrs Sheppards") {$goofurl_5="Mrs+Sheppards";}
elseif ($goofont5=="Aguafina Script") {$goofurl_5="Aguafina+Script";}
elseif ($goofont5=="Piedra") {$goofurl_5="Piedra";}
elseif ($goofont5=="Aladin") {$goofurl_5="Aladin";}
elseif ($goofont5=="Chicle") {$goofurl_5="Chicle";}
elseif ($goofont5=="Cagliostro") {$goofurl_5="Cagliostro";}
elseif ($goofont5=="Lemon") {$goofurl_5="Lemon";}
elseif ($goofont5=="Unlock") {$goofurl_5="Unlock";}
elseif ($goofont5=="Signika") {$goofurl_5="Signika";}
elseif ($goofont5=="Signika Negaive") {$goofurl_5="Signika+Negative";}
elseif ($goofont5=="Niconne") {$goofurl_5="Niconne";}
elseif ($goofont5=="Knewave") {$goofurl_5="Knewave";}
elseif ($goofont5=="Righteous") {$goofurl_5="Righteous";}
elseif ($goofont5=="Ribeye") {$goofurl_5="Ribeye";}
elseif ($goofont5=="Ribeye Marrow") {$goofurl_5="Ribeye+Marrow";}
elseif ($goofont5=="Spirax") {$goofurl_5="Spirax";}
elseif ($goofont5=="Concert One") {$goofurl_5="Concert+One";}
elseif ($goofont5=="Bubblegun Sans") {$goofurl_5="Bubblegun+Sans";}
elseif ($goofont5=="Iceland") {$goofurl_5="Iceland";}
elseif ($goofont5=="Devonshire") {$goofurl_5="Devonshire";}
elseif ($goofont5=="Fondamento") {$goofurl_5="Fondamento";}
elseif ($goofont5=="Bitter") {$goofurl_5="Bitter";}
elseif ($goofont5=="Convergence") {$goofurl_5="Convergence";}
elseif ($goofont5=="Lancelot") {$goofurl_5="Lancelot";}
elseif ($goofont5=="Petrona") {$goofurl_5="Petrona";}
elseif ($goofont5=="Supermercado One") {$goofurl_5="Supermercado+One";}
elseif ($goofont5=="Arapey") {$goofurl_5="Arapey";}
elseif ($goofont5=="Mate") {$goofurl_5="Mate";}
elseif ($goofont5=="Mate SC") {$goofurl_5="Mate+SC";}
elseif ($goofont5=="Rammetto One") {$goofurl_5="Rammetto+One";}
elseif ($goofont5=="Fjord One") {$goofurl_5="Fjord+One";}
elseif ($goofont5=="Cabin Sketch") {$goofurl_5="Cabin+Sketch";}
elseif ($goofont5=="Jockey One") {$goofurl_5="Jockey+One";}
elseif ($goofont5=="Contrail One") {$goofurl_5="Contrail+One";}
elseif ($goofont5=="Atomic Age") {$goofurl_5="Atomic+Age";}
elseif ($goofont5=="Corben") {$goofurl_5="Corben";}
elseif ($goofont5=="Linden Hill") {$goofurl_5="Linden+Hill";}
elseif ($goofont5=="Quicksand") {$goofurl_5="Quicksand";}
elseif ($goofont5=="Amatic SC") {$goofurl_5="Amatic+SC";}
elseif ($goofont5=="Salsa") {$goofurl_5="Salsa";}
elseif ($goofont5=="Marck Script") {$goofurl_5="Marck+Script";}
elseif ($goofont5=="Vast Shadow") {$goofurl_5="Vast+Shadow";}
elseif ($goofont5=="Cookie") {$goofurl_5="Cookie";}
elseif ($goofont5=="Pinyon Script") {$goofurl_5="Pinyon+Script";}
elseif ($goofont5=="Satisfy") {$goofurl_5="Satisfy";}
elseif ($goofont5=="Rancho") {$goofurl_5="Rancho";}
elseif ($goofont5=="Coda") {$goofurl_5="Coda";}
elseif ($goofont5=="Sancheek") {$goofurl_5="Sancheek";}
elseif ($goofont5=="Ubunto Mon") {$goofurl_5="Ubunto+Mon";}
elseif ($goofont5=="Unbunto Condensed") {$goofurl_5="Ubunto+Condensed";}
elseif ($goofont5=="Federant") {$goofurl_5="Federant";}
elseif ($goofont5=="Andada") {$goofurl_5="Andada";}
elseif ($goofont5=="Poly") {$goofurl_5="Poly";}
elseif ($goofont5=="Gochi Hand") {$goofurl_5="Gochi+Hand";}
elseif ($goofont5=="Alike Angular") {$goofurl_5="Alike+Angular";}
elseif ($goofont5=="Poller One") {$goofurl_5="Poller+One";}
elseif ($goofont5=="Chivo") {$goofurl_5="Chivo";}
elseif ($goofont5=="Sanista One") {$goofurl_5="Sanista+One";}
elseif ($goofont5=="Terminal Dosis") {$goofurl_5="Terminal+Dosis";}
elseif ($goofont5=="Sorts Mill Goudy") {$goofurl_5="Sorts+Mill+Goudy";}
elseif ($goofont5=="Adamina") {$goofurl_5="Adamina";}
elseif ($goofont5=="Prata") {$goofurl_5="Prata";}
elseif ($goofont5=="Julee") {$goofurl_5="Julee";}
elseif ($goofont5=="Changa One") {$goofurl_5="Changa+One";}
elseif ($goofont5=="Merienda One") {$goofurl_5="Merienda+One";}
elseif ($goofont5=="Prociono") {$goofurl_5="Prociono";}
elseif ($goofont5=="Passero One") {$goofurl_5="Passero+One";}
elseif ($goofont5=="Antic") {$goofurl_5="Antic";}
elseif ($goofont5=="Dorsa") {$goofurl_5="Dorsa";}
elseif ($goofont5=="Abril Fatface") {$goofurl_5="Abril+Fatface";}
elseif ($goofont5=="Delius Unicase") {$goofurl_5="Delius+Unicase";}
elseif ($goofont5=="Alike") {$goofurl_5="Alike";}
elseif ($goofont5=="Monoton") {$goofurl_5="Monoton";}
elseif ($goofont5=="Days One") {$goofurl_5="Days One";}
elseif ($goofont5=="Numans") {$goofurl_5="Numans";}
elseif ($goofont5=="Aldrich") {$goofurl_5="Aldrich";}
elseif ($goofont5=="Vidaloka") {$goofurl_5="Vidaloka";}
elseif ($goofont5=="Short Stack") {$goofurl_5="Short+Stack";}
elseif ($goofont5=="Montez") {$goofurl_5="Montez";}
elseif ($goofont5=="Voltaire") {$goofurl_5="Voltaire";}
elseif ($goofont5=="Geostar Fill") {$goofurl_5="Geostar+Fill";}
elseif ($goofont5=="Geostar") {$goofurl_5="Geostar";}
elseif ($goofont5=="Questrial") {$goofurl_5="Questrial";}
elseif ($goofont5=="Alice") {$goofurl_5="Alice";}
elseif ($goofont5=="Andika") {$goofurl_5="Andika";}
elseif ($goofont5=="Tulpen One") {$goofurl_5="Tulpen+One";}
elseif ($goofont5=="Smokum") {$goofurl_5="Smokum";}
elseif ($goofont5=="Delius Swash Caps") {$goofurl_5="Delius+Swash+Caps";}
elseif ($goofont5=="Actor") {$goofurl_5="Actor";}
elseif ($goofont5=="Abel") {$goofurl_5="Abel";}
elseif ($goofont5=="Rationale") {$goofurl_5="Rationale";}
elseif ($goofont5=="Rochester") {$goofurl_5="Rochester";}
elseif ($goofont5=="Delius") {$goofurl_5="Delius";}
elseif ($goofont5=="Federo") {$goofurl_5="Federo";}
elseif ($goofont5=="Aubrey") {$goofurl_5="Aubrey";}
elseif ($goofont5=="Carme") {$goofurl_5="Carme";}
elseif ($goofont5=="Black Ops One") {$goofurl_5="Black+Ops+One";}
elseif ($goofont5=="Kelly Slab") {$goofurl_5="Kelly+Slab";}
elseif ($goofont5=="Gloria Hallelujah") {$goofurl_5="Gloria+Hallelujah";}
elseif ($goofont5=="Ovo") {$goofurl_5="Ovo";}
elseif ($goofont5=="Snippet") {$goofurl_5="Snippet";}
elseif ($goofont5=="Leckerli One") {$goofurl_5="Leckerli+One";}
elseif ($goofont5=="Rosario") {$goofurl_5="Rosario";}
elseif ($goofont5=="Unna") {$goofurl_5="Unna";}
elseif ($goofont5=="Pompiere") {$goofurl_5="Pompiere";}
elseif ($goofont5=="Yellowtail") {$goofurl_5="Yellowtail";}
elseif ($goofont5=="Modern Antiqua") {$goofurl_5="Modern+Antiqua";}
elseif ($goofont5=="Give You Glory") {$goofurl_5="Give+You+Glory";}
elseif ($goofont5=="Yeseva One") {$goofurl_5="Yeseva+One";}
elseif ($goofont5=="Varela Round") {$goofurl_5="Varela+Round";}
elseif ($goofont5=="Patrick Hand") {$goofurl_5="Patrick+Hand";}
elseif ($goofont5=="Forum") {$goofurl_5="Forum";}
elseif ($goofont5=="Bowlby One") {$goofurl_5="Bowlby+One";}
elseif ($goofont5=="Bowlby One SC") {$goofurl_5="Bowlby+One+SC";}
elseif ($goofont5=="Loved by the King") {$goofurl_5="Loved+by+the+King";}
elseif ($goofont5=="Love Ya Like A Sister") {$goofurl_5="Love+Ya+Like+A+Sister";}
elseif ($goofont5=="Stardos Stencil") {$goofurl_5="Stardos+Stencil";}
elseif ($goofont5=="Hammersmith One") {$goofurl_5="Hammersmith+One";}
elseif ($goofont5=="Gravitas One") {$goofurl_5="Gravitas+One";}
elseif ($goofont5=="Asset") {$goofurl_5="Asset";}
elseif ($goofont5=="Goblin One") {$goofurl_5="Goblin+One";}
elseif ($goofont5=="Varela") {$goofurl_5="Varela";}
elseif ($goofont5=="Fanwood Text") {$goofurl_5="Fanwood+Text";$goofont5="Fanwood Text";}
elseif ($goofont5=="Fanwood Text") {$goofurl_5="Fanwood+Text:400italic";$goofont5="Fanwood Text";}
elseif ($goofont5=="Gentium Basic") {$goofurl_5="Gentium+Basic";$goofont5="Gentium Basic";}
elseif ($goofont5=="Gentium Basic Italic") {$goofurl_5="Gentium+Basic:400italic";$goofont5="Gentium Basic";}
elseif ($goofont5=="Gentium Basic Bold") {$goofurl_5="Gentium+Basic:700";$goofont5="Gentium Basic";}
elseif ($goofont5=="Gentium Basic Bold Italic") {$goofurl_5="Gentium+Basic:700italic";$goofont5="Gentium Basic";}
elseif ($goofont5=="Gentium Book Basic") {$goofurl_5="Gentium+Book+Basic";$goofont5="Gentium Book Basic";}
elseif ($goofont5=="Gentium Book Basic Italic") {$goofurl_5="Gentium+Book+Basic:400italic";$goofont5="Gentium Book Basic";}
elseif ($goofont5=="Gentium Book Basic Bold") {$goofurl_5="Gentium+Book+Basic:700";$goofont5="Gentium Book Basic";}
elseif ($goofont5=="Gentium Book Basic Bold Italic") {$goofurl_5="Gentium+Book+Basic:700italic";$goofont5="Gentium Book Basic";}
elseif ($goofont5=="Volkhov") {$goofurl_5="Volkhov";$goofont5="Volkhov";}
elseif ($goofont5=="Volkhov Italic") {$goofurl_5="Volkhov:400italic";$goofont5="Volkhov";}
elseif ($goofont5=="Volkhov Bold") {$goofurl_5="Volkhov:700";$goofont5="Volkhov";}
elseif ($goofont5=="Volkhov Bold Italic") {$goofurl_5="Volkhov:700italic";$goofont5="Volkhov";}
elseif ($goofont5=="Comfortaa Book") {$goofurl_5="Comfortaa:300";$goofont5="Comfortaa";}
elseif ($goofont5=="Comfortaa Normal") {$goofurl_5="Comfortaa";$goofont5="Comfortaa";}
elseif ($goofont5=="Comfortaa Bold") {$goofurl_5="Comfortaa:700";$goofont5="Comfortaa";}
elseif ($goofont5=="Coustard") {$goofurl_5="Coustard";$goofont5="Coustard";}
elseif ($goofont5=="Coustard Ultra Bold") {$goofurl_5="Coustard:900";$goofont5="Coustard";}
elseif ($goofont5=="Marvel") {$goofurl_5="Marvel";$goofont5="Marvel";}
elseif ($goofont5=="Marvel Italic") {$goofurl_5="Marvel:400italic";$goofont5="Marvel";}
elseif ($goofont5=="Marvel Bold") {$goofurl_5="Marvel:700";$goofont5="Marvel";}
elseif ($goofont5=="Marvel Bold Italic") {$goofurl_5="Marvel:700italic";$goofont5="Marvel";}
elseif ($goofont5=="Istok Web") {$goofurl_5="Istok+Web";$goofont5="Istok Web";}
elseif ($goofont5=="Istok Web Italic") {$goofurl_5="Istok+Web:400italic";$goofont5="Istok Web";}
elseif ($goofont5=="Istok Web Bold") {$goofurl_5="Istok+Web:700";$goofont5="Istok Web";}
elseif ($goofont5=="Istok Web Bold Italic") {$goofurl_5="Istok+Web:700italic";$goofont5="Istok Web";}
elseif ($goofont5=="Tienne") {$goofurl_5="Tienne";$goofont5="Tienne";}
elseif ($goofont5=="Tienne Bold") {$goofurl_5="Tienne:700";$goofont5="Tienne";}
elseif ($goofont5=="Tienne Ultra Bold") {$goofurl_5="Tienne:900";$goofont5="Tienne";}
elseif ($goofont5=="Nixie One") {$goofurl_5="Nixie+One";}
elseif ($goofont5=="Redressed") {$goofurl_5="Redressed";}
elseif ($goofont5=="Lobster Two") {$goofurl_5="Lobster+Two";$goofont5="Lobster Two";}
elseif ($goofont5=="Lobster Two Italic") {$goofurl_5="Lobster+Two:400italic";$goofont5="Lobster Two";}
elseif ($goofont5=="Lobster Two Bold") {$goofurl_5="Lobster+Two:700";$goofont5="Lobster Two";}
elseif ($goofont5=="Lobster Two Bold Italic") {$goofurl_5="Lobster+Two:700italic";$goofont5="Lobster Two";}
elseif ($goofont5=="Caudex") {$goofurl_5="Caudex";}
elseif ($goofont5=="Jura") {$goofurl_5="Jura";}
elseif ($goofont5=="Ruslan Display") {$goofurl_5="Ruslan+Display";}
elseif ($goofont5=="Brawler") {$goofurl_5="Brawler";}
elseif ($goofont5=="Nunito") {$goofurl_5="Nunito";}
elseif ($goofont5=="Wire One") {$goofurl_5="Wire+One";}
elseif ($goofont5=="Podkova") {$goofurl_5="Podkova";}
elseif ($goofont5=="Muli") {$goofurl_5="Muli";}
elseif ($goofont5=="Maven Pro") {$goofurl_5="Maven+Pro";}
elseif ($goofont5=="Tenor Sans") {$goofurl_5="Tenor+Sans";}
elseif ($goofont5=="Limelight") {$goofurl_5="Limelight";}
elseif ($goofont5=="Playfair Display") {$goofurl_5="Playfair+Display";}
elseif ($goofont5=="Artifika") {$goofurl_5="Artifika";}
elseif ($goofont5=="Lora") {$goofurl_5="Lora";}
elseif ($goofont5=="Kameron") {$goofurl_5="Kameron";}
elseif ($goofont5=="Cedarville Cursive") {$goofurl_5="Cedarville+Cursive";}
elseif ($goofont5=="Zeyada") {$goofurl_5="Zeyada";}
elseif ($goofont5=="La Belle Aurore") {$goofurl_5="La+Belle+Aurore";}
elseif ($goofont5=="Shadows into Light") {$goofurl_5="Shadows+Into+Light";}
elseif ($goofont5=="Shanti") {$goofurl_5="Shanti";}
elseif ($goofont5=="Mako") {$goofurl_5="Mako";}
elseif ($goofont5=="Metrophobic") {$goofurl_5="Metrophobic";}
elseif ($goofont5=="Ultra") {$goofurl_5="Ultra";}
elseif ($goofont5=="Play") {$goofurl_5="Play";}
elseif ($goofont5=="Didact Gothic") {$goofurl_5="Didact+Gothic";}
elseif ($goofont5=="Judson") {$goofurl_5="Judson";}
elseif ($goofont5=="Megrim") {$goofurl_5="Megrim";}
elseif ($goofont5=="Rokkitt") {$goofurl_5="Rokkitt";}
elseif ($goofont5=="Monofett") {$goofurl_5="Monofett";}
elseif ($goofont5=="Paytone One") {$goofurl_5="Paytone+One";}
elseif ($goofont5=="Holtwood One SC") {$goofurl_5="Holtwood+One+SC";}
elseif ($goofont5=="Carter One") {$goofurl_5="Carter+One";}
elseif ($goofont5=="Francois One") {$goofurl_5="Francois+One";}
elseif ($goofont5=="Bigshot One") {$goofurl_5="Bigshot+One";}
elseif ($goofont5=="Sigmar One") {$goofurl_5="Sigmar+One";}
elseif ($goofont5=="Swanky and Moo Moo") {$goofurl_5="Swanky+and+Moo+Moo";}
elseif ($goofont5=="Over the Rainbow") {$goofurl_5="Over+the+Rainbow";}
elseif ($goofont5=="Wallpoet") {$goofurl_5="Wallpoet";}
elseif ($goofont5=="Damion") {$goofurl_5="Damion";}
elseif ($goofont5=="News Cycle") {$goofurl_5="News+Cycle";}
elseif ($goofont5=="Aclonica") {$goofurl_5="Aclonica";}
elseif ($goofont5=="Special Elite") {$goofurl_5="Special+Elite";}
elseif ($goofont5=="Smythe") {$goofurl_5="Smythe";}
elseif ($goofont5=="Quattrocento Sans") {$goofurl_5="Quattrocento+Sans";}
elseif ($goofont5=="The Girl Next Door") {$goofurl_5="The+Girl+Next+Door";}
elseif ($goofont5=="Sue Ellen Francisco") {$goofurl_5="Sue+Ellen+Francisco";}
elseif ($goofont5=="Dawning of a New Day") {$goofurl_5="Dawning+of+a+New+Day";}
elseif ($goofont5=="Waiting for the Sunrise") {$goofurl_5="Waiting+for+the+Sunrise";}
elseif ($goofont5=="Annie Use Your Telescope") {$goofurl_5="Annie+Use+Your+Telescope";}
elseif ($goofont5=="Maiden Orange") {$goofurl_5="Maiden+Orange";}
elseif ($goofont5=="Luckiest Guy") {$goofurl_5="Luckiest+Guy";}
elseif ($goofont5=="Bangers") {$goofurl_5="Bangers";}
elseif ($goofont5=="Miltonian") {$goofurl_5="Miltonian";}
elseif ($goofont5=="Miltonian Tattoo") {$goofurl_5="Miltonian+Tattoo";}
elseif ($goofont5=="Allerta") {$goofurl_5="Allerta";}
elseif ($goofont5=="Allerta Stencil") {$goofurl_5="Allerta+Stencil";}
elseif ($goofont5=="Amaranth") {$goofurl_5="Amaranth";}
elseif ($goofont5=="Anonymous Pro") {$goofurl_5="Anonymous+Pro";}
elseif ($goofont5=="Anonymous Pro Italic") {$goofurl_5="Anonymous+Pro:italic";$goofont5="Anonymous Pro";}
elseif ($goofont5=="Anonymous Pro Bold") {$goofurl_5="Anonymous+Pro:bold";$goofont5="Anonymous Pro";}
elseif ($goofont5=="Anonymous Pro Bold Italic") {$goofurl_5="Anonymous+Pro:bolditalic";$goofont5="Anonymous Pro";}
elseif ($goofont5=="Anton") {$goofurl_5="Anton";}
elseif ($goofont5=="Architects Daughter") {$goofurl_5="Architects+Daughter";}
elseif ($goofont5=="Arimo") {$goofurl_5="Arimo";}
elseif ($goofont5=="Arimo Italic") {$goofurl_5="Arimo:italic";$goofont5="Arimo";}
elseif ($goofont5=="Arimo Bold") {$goofurl_5="Arimo:bold";$goofont5="Arimo";}
elseif ($goofont5=="Arimo Bold Italic") {$goofurl_5="Arimo:bolditalic";$goofont5="Arimo";}
elseif ($goofont5=="Arvo") {$goofurl_5="Arvo"; $goofont5="Arvo";}
elseif ($goofont5=="Arvo Italic") {$goofurl_5="Arvo:italic"; $goofont5="Arvo";}
elseif ($goofont5=="Arvo Bold") {$goofurl_5="Arvo:bold"; $goofont5="Arvo";}
elseif ($goofont5=="Arvo Bold Italic") {$goofurl_5="Arvo:bolditalic"; $goofont5="Arvo";}
elseif ($goofont5=="Astloch") {$goofurl_5="Astloch";}
elseif ($goofont5=="Astloch Bold") {$goofurl_5="Astloch:bold"; $goofont5="Astloch";}
elseif ($goofont5=="Bentham") {$goofurl_5="Bentham";}
elseif ($goofont5=="Bevan") {$goofurl_5="Bevan";}
elseif ($goofont5=="Buda") {$goofurl_5="Buda:light";}
elseif ($goofont5=="Cabin") {$goofurl_5="Cabin:regular";}
elseif ($goofont5=="Cabin Italic") {$goofurl_5="Cabin:regularitalic";$goofont5="Cabin";}
elseif ($goofont5=="Cabin Bold") {$goofurl_5="Cabin:bold";$goofont5="Cabin";}
elseif ($goofont5=="Cabin Bold Italic") {$goofurl_5="Cabin:bolditalic";$goofont5="Cabin";}
elseif ($goofont5=="Cabin Sketch") {$goofurl_5="Cabin+Sketch:bold";}
elseif ($goofont5=="Calligraffitti") {$goofurl_5="Calligraffitti";}
elseif ($goofont5=="Candal") {$goofurl_5="Candal";}
elseif ($goofont5=="Cantarell") {$goofurl_5="Cantarell";}
elseif ($goofont5=="Cantarell Italic") {$goofurl_5="Cantarell:italic";$goofont5="Cantarell";}
elseif ($goofont5=="Cantarell Bold") {$goofurl_5="Cantarell:bold";$goofont5="Cantarell";}
elseif ($goofont5=="Cantarell Bold Italic") {$goofurl_5="Cantarell:bolditalic";$goofont5="Cantarell";}
elseif ($goofont5=="Cardo") {$goofurl_5="Cardo";}
elseif ($goofont5=="Cherry Cream Soda") {$goofurl_5="Cherry+Cream+Soda";}
elseif ($goofont5=="Chewy") {$goofurl_5="Chewy";}
elseif ($goofont5=="Coda") {$goofurl_5="Coda:800";}
elseif ($goofont5=="Coda Caption") {$goofurl_5="Coda+Caption:800";}
elseif ($goofont5=="Coming Soon") {$goofurl_5="Coming+Soon";}
elseif ($goofont5=="Copse") {$goofurl_5="Copse";}
elseif ($goofont5=="Corben") {$goofurl_5="Corben:bold";}
elseif ($goofont5=="Cousine") {$goofurl_5="Cousine";}
elseif ($goofont5=="Cousine Italic") {$goofurl_5="Cousine:italic";$goofont5="Cousine";}
elseif ($goofont5=="Cousine Bold") {$goofurl_5="Cousine:bold";$goofont5="Cousine";}
elseif ($goofont5=="Cousine Bold Italic") {$goofurl_5="Cousine:bolditalic";$goofont5="Cousine";}
elseif ($goofont5=="Covered By Your Grace") {$goofurl_5="Covered+By+Your+Grace";}
elseif ($goofont5=="Crafty Girls") {$goofurl_5="Crafty+Girls";}
elseif ($goofont5=="Crimson Text") {$goofurl_5="Crimson+Text";}
elseif ($goofont5=="Crimson Text Italic") {$goofurl_5="Crimson+Text:italic";$goofont5="Crimson Text";}
elseif ($goofont5=="Crimson Text Bold") {$goofurl_5="Crimson+Text:bold";$goofont5="Crimson Text";}
elseif ($goofont5=="Crimson Text Bold Italic") {$goofurl_5="Crimson+Text:bolditalic";$goofont5="Crimson Text";}
elseif ($goofont5=="Crushed") {$goofurl_5="Crushed";}
elseif ($goofont5=="Cuprum") {$goofurl_5="Cuprum";}
elseif ($goofont5=="Droid Sans") {$goofurl_5="Droid+Sans";}
elseif ($goofont5=="Droid Sans Bold") {$goofurl_5="Droid+Sans:bold"; $goofont5="Droid Sans";}
elseif ($goofont5=="Droid Sans Mono") {$goofurl_5="Droid+Sans+Mono";}
elseif ($goofont5=="Droid Serif") {$goofurl_5="Droid+Serif";}
elseif ($goofont5=="Droid Serif Italic") {$goofurl_5="Droid+Serif:italic";$goofont5="Droid Serif";}
elseif ($goofont5=="Droid Serif Bold") {$goofurl_5="Droid+Serif:bold";$goofont5="Droid Serif";}
elseif ($goofont5=="Droid Serif Bold Italic") {$goofurl_5="Droid+Serif:bolditalic";$goofont5="Droid Serif";}
elseif ($goofont5=="EB Garamond") {$goofurl_5="EB+Garamond";}
elseif ($goofont5=="Expletus Sans") {$goofurl_5="Expletus+Sans";}
elseif ($goofont5=="Expletus Sans Bold") {$goofurl_5="Expletus+Sans:bold";$goofont5="Expletus Sans";}
elseif ($goofont5=="Fontdiner Swanky") {$goofurl_5="Fontdiner+Swanky";}
elseif ($goofont5=="Geo") {$goofurl_5="Geo";}
elseif ($goofont5=="Goudy Bookletter 1911") {$goofurl_5="Goudy+Bookletter+1911";}
elseif ($goofont5=="Gruppo") {$goofurl_5="Gruppo";}
elseif ($goofont5=="Homemade Apple") {$goofurl_5="Homemade+Apple";}
elseif ($goofont5=="IM Fell Double Pica") {$goofurl_5="IM+Fell+Double+Pica";$goofont5="IM Fell Double Pica";}
elseif ($goofont5=="IM Fell Double Pica Italic") {$goofurl_5="IM+Fell+Double+Pica:italic";$goofont5="IM Fell Double Pica";}
elseif ($goofont5=="IM Fell Double Pica SC") {$goofurl_5="IM+Fell+Double+Pica+SC";}
elseif ($goofont5=="IM Fell DW Pica") {$goofurl_5="IM+Fell+DW+Pica";$goofont5="IM Fell DW Pica";}
elseif ($goofont5=="IM Fell DW Pica Italic") {$goofurl_5="IM+Fell+DW+Pica:italic";$goofont5="IM Fell DW Pica";}
elseif ($goofont5=="IM Fell DW Pica SC") {$goofurl_5="IM+Fell+DW+Pica+SC";}
elseif ($goofont5=="IM Fell English") {$goofurl_5="IM+Fell+English";$goofont5="IM Fell English";}
elseif ($goofont5=="IM Fell English Italic") {$goofurl_5="IM+Fell+English:italic";$goofont5="IM Fell English";}
elseif ($goofont5=="IM Fell English SC") {$goofurl_5="IM+Fell+English+SC";}
elseif ($goofont5=="IM Fell French Canon") {$goofurl_5="IM+Fell+French+Canon";$goofont5="IM Fell French Canon";}
elseif ($goofont5=="IM Fell French Canon Italic") {$goofurl_5="IM+Fell+French+Canon:italic";$goofont5="IM Fell French Canon";}
elseif ($goofont5=="IM Fell French Canon SC") {$goofurl_5="IM+Fell+French+Canon+SC";}
elseif ($goofont5=="IM Fell Great Primer") {$goofurl_5="IM+Fell+Great+Primer";$goofont5="IM Fell Great Primer";}
elseif ($goofont5=="IM Fell Great Primer Italic") {$goofurl_5="IM+Fell+Great+Primer:italic";$goofont5="IM Fell Great Primer";}
elseif ($goofont5=="IM Fell Great Primer SC") {$goofurl_5="IM+Fell+Great+Primera+SC";}
elseif ($goofont5=="Inconsolata") {$goofurl_5="Inconsolata";}
elseif ($goofont5=="Indie Flower") {$goofurl_5="Indie+Flower";}
elseif ($goofont5=="Irish Grover") {$goofurl_5="Irish+Grover";}
elseif ($goofont5=="Josefin Sans") {$goofurl_5="Josefin+Sans";}
elseif ($goofont5=="Josefin Sans Italic") {$goofurl_5="Josefin+Sans:regularitalic"; $goofont5="Josefin Sans";}
elseif ($goofont5=="Josefin Sans Bold") {$goofurl_5="Josefin+Sans:bold"; $goofont5="Josefin Sans";}
elseif ($goofont5=="Josefin Sans Bold Italic") {$goofurl_5="Josefin+Sans:bolditalic"; $goofont5="Josefin Sans";}
elseif ($goofont5=="Josefin Slab") {$goofurl_5="Josefin+Slab";}
elseif ($goofont5=="Just Another Hand") {$goofurl_5="Just+Another+Hand";}
elseif ($goofont5=="Just Me Again Down Here") {$goofurl_5="Just+Me+Again+Down+Here";}
elseif ($goofont5=="Kenia") {$goofurl_5="Kenia";}
elseif ($goofont5=="Kranky") {$goofurl_5="Kranky";}
elseif ($goofont5=="Kreon") {$goofurl_5="Kreon";}
elseif ($goofont5=="Kreon Bold") {$goofurl_5="Kreon:bold"; $goofont5="Kreon";}
elseif ($goofont5=="Kristi") {$goofurl_5="Kristi";}
elseif ($goofont5=="Lato") {$goofurl_5="Lato";}
elseif ($goofont5=="Lato Italic") {$goofurl_5="Lato:regularitalic";$goofont5="Lato";}
elseif ($goofont5=="Lato Bold") {$goofurl_5="Lato:bold";$goofont5="Lato";}
elseif ($goofont5=="Lato Bold Italic") {$goofurl_5="Lato:bolditalic";$goofont5="Lato";}
elseif ($goofont5=="League Script") {$goofurl_5="League+Script";}
elseif ($goofont5=="Lekton") {$goofurl_5="Lekton";}
elseif ($goofont5=="Lekton Italic") {$goofurl_5="Lekton:italic"; $goofont5="Lekton";}
elseif ($goofont5=="Lekton Bold") {$goofurl_5="Lekton:bold"; $goofont5="Lekton";}
elseif ($goofont5=="Lobster") {$goofurl_5="Lobster";}
elseif ($goofont5=="MedievalSharp") {$goofurl_5="MedievalSharp";}
elseif ($goofont5=="Merriweather") {$goofurl_5="Merriweather";}
elseif ($goofont5=="Michroma") {$goofurl_5="Michroma";}
elseif ($goofont5=="Molengo") {$goofurl_5="Molengo";}
elseif ($goofont5=="Mountains of Christmas") {$goofurl_5="Mountains+of+Christmas";}
elseif ($goofont5=="Neucha") {$goofurl_5="Neucha";}
elseif ($goofont5=="Neuton") {$goofurl_5="Neuton";}
elseif ($goofont5=="Neuton Italic") {$goofurl_5="Neuton:italic"; $goofont5="Neuton";}
elseif ($goofont5=="Nobile") {$goofurl_5="Nobile";}
elseif ($goofont5=="Nobile Italic") {$goofurl_5="Nobile:italic"; $goofont5="Nobile";}
elseif ($goofont5=="Nobile Bold") {$goofurl_5="Nobile:bold"; $goofont5="Nobile";}
elseif ($goofont5=="Nobile Bold Italic") {$goofurl_5="Nobile:bolditalic"; $goofont5="Nobile";}
elseif ($goofont5=="Nova Round") {$goofurl_5="Nova+Round";}
elseif ($goofont5=="Nova Script") {$goofurl_5="Nova+Script";}
elseif ($goofont5=="Nova Slim") {$goofurl_5="Nova+Slim";}
elseif ($goofont5=="Nova Cut") {$goofurl_5="Nova+Cut";}
elseif ($goofont5=="Nova Oval") {$goofurl_5="Nova+Oval";}
elseif ($goofont5=="Nova Mono") {$goofurl_5="Nova+Mono";}
elseif ($goofont5=="Nova Flat") {$goofurl_5="Nova+Flat";}
elseif ($goofont5=="OFL Sorts Mill Goudy TT") {$goofurl_5="OFL+Sorts+Mill+Goudy+TT";}
elseif ($goofont5=="OFL Sorts Mill Goudy TT Italic") {$goofurl_5="OFL+Sorts+Mill+Goudy+TT:italic";$goofont5="OFL Sorts Mill Goudy TT";}
elseif ($goofont5=="Old Standard TT") {$goofurl_5="Old+Standard+TT";}
elseif ($goofont5=="Old Standard TT Italic") {$goofurl_5="Old+Standard+TT:italic";$goofont5="Old Standard TT";}
elseif ($goofont5=="Old Standard TT Bold") {$goofurl_5="Old+Standard+TT:bold";$goofont5="Old Standard TT";}
elseif ($goofont5=="Orbitron") {$goofurl_5="Orbitron";}
elseif ($goofont5=="Orbitron Italic") {$goofurl_5="Orbitron:italic";$goofont5="Orbitron";}
elseif ($goofont5=="Orbitron Bold") {$goofurl_5="Orbitron:bold";$goofont5="Orbitron";}
elseif ($goofont5=="Orbitron Bold Italic") {$goofurl_5="Orbitron:bolditalic";$goofont5="Orbitron";}
elseif ($goofont5=="Oswald") {$goofurl_5="Oswald";}
elseif ($goofont5=="Pacifico") {$goofurl_5="Pacifico";}
elseif ($goofont5=="Permanent Marker") {$goofurl_5="Permanent+Marker";}
elseif ($goofont5=="PT Sans") {$goofurl_5="PT+Sans";}
elseif ($goofont5=="PT Sans Italic") {$goofurl_5="PT+Sans:italic";}
elseif ($goofont5=="PT Sans Bold") {$goofurl_5="PT+Sans:bold";}
elseif ($goofont5=="PT Sans Bold Italic") {$goofurl_5="PT+Sans:bolditalic";}
elseif ($goofont5=="PT Sans Caption") {$goofurl_5="PT+Sans+Caption";}
elseif ($goofont5=="PT Sans Caption Bold") {$goofurl_5="PT+Sans+Caption:bold"; $goofont5="PT Sans Caption";}
elseif ($goofont5=="PT Sans Narrow") {$goofurl_5="PT+Sans+Narrow";}
elseif ($goofont5=="PT Sans Narrow Bold") {$goofurl_5="PT+Sans+Narrow:bold"; $goofont5="PT Sans Narrow";}
elseif ($goofont5=="PT Serif") {$goofurl_5="PT+Serif";}
elseif ($goofont5=="PT Serif Italic") {$goofurl_5="PT+Serif:italic";$goofont5="PT Serif";}
elseif ($goofont5=="PT Serif Bold") {$goofurl_5="PT+Serif:bold";$goofont5="PT Serif";}
elseif ($goofont5=="PT Serif Bold Italic") {$goofurl_5="PT+Serif:bolditalic";$goofont5="PT Serif";}
elseif ($goofont5=="PT Serif Caption") {$goofurl_5="PT+Serif+Caption";}
elseif ($goofont5=="PT Serif Caption Bold") {$goofurl_5="PT+Serif+Caption+Bold"; $goofont5="PT Serif Caption";}
elseif ($goofont5=="Philosopher") {$goofurl_5="Philosopher";}
elseif ($goofont5=="Puritan") {$goofurl_5="Puritan";}
elseif ($goofont5=="Puritan Italic") {$goofurl_5="Puritan:italic";$goofont5="Puritan";}
elseif ($goofont5=="Puritan Bold") {$goofurl_5="Puritan:bold";$goofont5="Puritan";}
elseif ($goofont5=="Puritan Bold Italic") {$goofurl_5="Puritan:bolditalic";$goofont5="Puritan";}
elseif ($goofont5=="Quattrocento") {$goofurl_5="Quattrocento";}
elseif ($goofont5=="Raleway") {$goofurl_5="Raleway:100";}
elseif ($goofont5=="Reenie Beanie") {$goofurl_5="Reenie+Beanie";}
elseif ($goofont5=="Rock Salt") {$goofurl_5="Rock+Salt";}
elseif ($goofont5=="Schoolbell") {$goofurl_5="Schoolbell";}
elseif ($goofont5=="Slackey") {$goofurl_5="Slackey";}
elseif ($goofont5=="Sniglet") {$goofurl_5="Sniglet:800";}
elseif ($goofont5=="Sunshiney") {$goofurl_5="Sunshiney";}
elseif ($goofont5=="Syncopate") {$goofurl_5="Syncopate";}
elseif ($goofont5=="Tangerine") {$goofurl_5="Tangerine";}
elseif ($goofont5=="Terminal Dosis Light") {$goofurl_5="Terminal Dosis Light";}
elseif ($goofont5=="Tinos") {$goofurl_5="Tinos";}
elseif ($goofont5=="Tinos Italic") {$goofurl_5="Tinos:italic";$goofont5="Tinos";}
elseif ($goofont5=="Tinos Bold") {$goofurl_5="Tinos:bold";$goofont5="Tinos";}
elseif ($goofont5=="Tinos Bold Italic") {$goofurl_5="Tinos:bolditalic";$goofont5="Tinos";}
elseif ($goofont5=="Ubuntu") {$goofurl_5="Ubuntu";}
elseif ($goofont5=="Ubuntu Italic") {$goofurl_5="Ubuntu:italic";$goofont5="Ubuntu";}
elseif ($goofont5=="Ubuntu Bold") {$goofurl_5="Ubuntu:bold";$goofont5="Ubuntu";}
elseif ($goofont5=="Ubuntu Bold Italic") {$goofurl_5="Ubuntu:bolditalic";$goofont5="Ubuntu";}
elseif ($goofont5=="UnifrakturCook") {$goofurl_5="UnifrakturCook:bold";}
elseif ($goofont5=="UnifrakturMaguntia") {$goofurl_5="UnifrakturMaguntia";}
elseif ($goofont5=="Unkempt") {$goofurl_5="Unkempt";}
elseif ($goofont5=="VT323") {$goofurl_5="VT323";}
elseif ($goofont5=="Vibur") {$goofurl_5="Vibur";}
elseif ($goofont5=="Vollkorn") {$goofurl_5="Vollkorn";}
elseif ($goofont5=="Vollkorn Italic") {$goofurl_5="Vollkorn:italic";$goofont5="Vollkorn";}
elseif ($goofont5=="Vollkorn Bold") {$goofurl_5="Vollkorn:bold";$goofont5="Vollkorn";}
elseif ($goofont5=="Vollkorn Bold Italic") {$goofurl_5="Vollkorn:bolditalic";$goofont5="Vollkorn";}
elseif ($goofont5=="Walter Turncoat") {$goofurl_5="Walter+Turncoat";}
elseif ($goofont5=="Yanone Kaffeesatz") {$goofurl_5="Yanone+Kaffeesatz";}
elseif ($goofont5=="Yanone Kaffeesatz Light") {$goofurl_5="Yanone+Kaffeesatz:light";$goofont5="Yanone Kaffeesatz";}
elseif ($goofont5=="Yanone Kaffeesatz Bold") {$goofurl_5="Yanone+Kaffeesatz:bold";$goofont5="Yanone Kaffeesatz";}
else ;

$activate_second = '';
$activate_second = $this->params->get( 'use_second' );

$activate_third = '';
$activate_third = $this->params->get( 'use_third' );

$activate_fourth = '';
$activate_fourth = $this->params->get( 'use_fourth' );

$activate_fifth = '';
$activate_fifth = $this->params->get( 'use_fifth' );

$hd_gfont1 = '<link href="http://fonts.googleapis.com/css?family='. $goofurl_1.'" rel="stylesheet" type="text/css">
<style type="text/css">'. $this->params->get( 'font-class-1' ).' {font-family: \''. $goofont1.'\', arial, serif; '. $this->params->get( 'font-css-1' ).'}</style>'
;

if ($activate_second=="1") {$hd_gfont2 = '<link href="http://fonts.googleapis.com/css?family='. $goofurl_2.'" rel="stylesheet" type="text/css">
<style type="text/css">'. $this->params->get( 'font-class-2' ).' {font-family: \''. $goofont2.'\', arial, serif; '. $this->params->get( 'font-css-2' ).'}</style>'
;}
else {$hd_gfont2 = ' ';}

if ($activate_third=="1") {$hd_gfont3 = '<link href="http://fonts.googleapis.com/css?family='. $goofurl_3.'" rel="stylesheet" type="text/css">
<style type="text/css">'. $this->params->get( 'font-class-3' ).' {font-family: \''. $goofont3.'\', arial, serif; '. $this->params->get( 'font-css-3' ).'}</style>'
;}
else {$hd_gfont3 = ' ';}

if ($activate_fourth=="1") {$hd_gfont4 = '<link href="http://fonts.googleapis.com/css?family='. $goofurl_4.'" rel="stylesheet" type="text/css">
<style type="text/css">'. $this->params->get( 'font-class-4' ).' {font-family: \''. $goofont4.'\', arial, serif; '. $this->params->get( 'font-css-4' ).'}</style>'
;}
else {$hd_gfont4 = ' ';}

if ($activate_fifth=="1") {$hd_gfont5 = '<link href="http://fonts.googleapis.com/css?family='. $goofurl_5.'" rel="stylesheet" type="text/css">
<style type="text/css">'. $this->params->get( 'font-class-5' ).' {font-family: \''. $goofont5.'\', arial, serif; '. $this->params->get( 'font-css-5' ).'}</style>'
;}
else {$hd_gfont5 = ' ';}

$google_fontage=$hd_gfont1.$hd_gfont2.$hd_gfont3.$hd_gfont4.$hd_gfont5;
		
		$buffer = str_replace ("</head>", $google_fontage."</head>", $buffer);
		JResponse::setBody($buffer);
		
		return true;
	}
}
}
?>