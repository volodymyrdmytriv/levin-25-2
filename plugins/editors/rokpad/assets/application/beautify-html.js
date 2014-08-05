/*
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
function style_html(o,c){var r,l,k,e,f;c=c||{};l=c.indent_size||4;k=c.indent_char||" ";f=c.brace_style||"collapse";e=c.max_char===0?Infinity:c.max_char||70;
unformatted=c.unformatted||["a"];function b(){this.pos=0;this.token="";this.current_mode="CONTENT";this.tags={parent:"parent1",parentcount:1,parent1:""};
this.tag_type="";this.token_text=this.last_token=this.last_text=this.token_type="";this.Utils={whitespace:"\n\r\t ".split(""),single_token:"br,input,link,meta,!doctype,basefont,base,area,hr,wbr,param,img,isindex,?xml,embed".split(","),extra_liners:"head,body,/html".split(","),in_array:function(u,s){for(var t=0;
t<s.length;t++){if(u===s[t]){return true;}}return false;}};this.get_content=function(){var s="";var u=[];var v=false;while(this.input.charAt(this.pos)!=="<"){if(this.pos>=this.input.length){return u.length?u.join(""):["","TK_EOF"];
}s=this.input.charAt(this.pos);this.pos++;this.line_char_count++;if(this.Utils.in_array(s,this.Utils.whitespace)){if(u.length){v=true;}this.line_char_count--;
continue;}else{if(v){if(this.line_char_count>=this.max_char){u.push("\n");for(var t=0;t<this.indent_level;t++){u.push(this.indent_string);}this.line_char_count=0;
}else{u.push(" ");this.line_char_count++;}v=false;}}u.push(s);}return u.length?u.join(""):"";};this.get_contents_to=function(u){if(this.pos==this.input.length){return["","TK_EOF"];
}var s="";var v="";var w=new RegExp("</"+u+"\\s*>","igm");w.lastIndex=this.pos;var t=w.exec(this.input);var x=t?t.index:this.input.length;if(this.pos<x){v=this.input.substring(this.pos,x);
this.pos=x;}return v;};this.record_tag=function(s){if(this.tags[s+"count"]){this.tags[s+"count"]++;this.tags[s+this.tags[s+"count"]]=this.indent_level;
}else{this.tags[s+"count"]=1;this.tags[s+this.tags[s+"count"]]=this.indent_level;}this.tags[s+this.tags[s+"count"]+"parent"]=this.tags.parent;this.tags.parent=s+this.tags[s+"count"];
};this.retrieve_tag=function(s){if(this.tags[s+"count"]){var t=this.tags.parent;while(t){if(s+this.tags[s+"count"]===t){break;}t=this.tags[t+"parent"];
}if(t){this.indent_level=this.tags[s+this.tags[s+"count"]];this.tags.parent=this.tags[t+"parent"];}delete this.tags[s+this.tags[s+"count"]+"parent"];delete this.tags[s+this.tags[s+"count"]];
if(this.tags[s+"count"]==1){delete this.tags[s+"count"];}else{this.tags[s+"count"]--;}}};this.get_tag=function(){var s="";var u=[];var w=false;do{if(this.pos>=this.input.length){return u.length?u.join(""):["","TK_EOF"];
}s=this.input.charAt(this.pos);this.pos++;this.line_char_count++;if(this.Utils.in_array(s,this.Utils.whitespace)){w=true;this.line_char_count--;continue;
}if(s==="'"||s==='"'){if(!u[1]||u[1]!=="!"){s+=this.get_unformatted(s);w=true;}}if(s==="="){w=false;}if(u.length&&u[u.length-1]!=="="&&s!==">"&&w){if(this.line_char_count>=this.max_char){this.print_newline(false,u);
this.line_char_count=0;}else{u.push(" ");this.line_char_count++;}w=false;}u.push(s);}while(s!==">");var x=u.join("");var v;if(x.indexOf(" ")!=-1){v=x.indexOf(" ");
}else{v=x.indexOf(">");}var t=x.substring(1,v).toLowerCase();if(x.charAt(x.length-2)==="/"||this.Utils.in_array(t,this.Utils.single_token)){this.tag_type="SINGLE";
}else{if(t==="script"){this.record_tag(t);this.tag_type="SCRIPT";}else{if(t==="style"){this.record_tag(t);this.tag_type="STYLE";}else{if(this.Utils.in_array(t,unformatted)){var y=this.get_unformatted("</"+t+">",x);
u.push(y);this.tag_type="SINGLE";}else{if(t.charAt(0)==="!"){if(t.indexOf("[if")!=-1){if(x.indexOf("!IE")!=-1){var y=this.get_unformatted("-->",x);u.push(y);
}this.tag_type="START";}else{if(t.indexOf("[endif")!=-1){this.tag_type="END";this.unindent();}else{if(t.indexOf("[cdata[")!=-1){var y=this.get_unformatted("]]>",x);
u.push(y);this.tag_type="SINGLE";}else{var y=this.get_unformatted("-->",x);u.push(y);this.tag_type="SINGLE";}}}}else{if(t.charAt(0)==="/"){this.retrieve_tag(t.substring(1));
this.tag_type="END";}else{this.record_tag(t);this.tag_type="START";}if(this.Utils.in_array(t,this.Utils.extra_liners)){this.print_newline(true,this.output);
}}}}}}return u.join("");};this.get_unformatted=function(t,u){if(u&&u.indexOf(t)!=-1){return"";}var s="";var v="";var w=true;do{if(this.pos>=this.input.length){return v;
}s=this.input.charAt(this.pos);this.pos++;if(this.Utils.in_array(s,this.Utils.whitespace)){if(!w){this.line_char_count--;continue;}if(s==="\n"||s==="\r"){v+="\n";
this.line_char_count=0;continue;}}v+=s;this.line_char_count++;w=true;}while(v.indexOf(t)==-1);return v;};this.get_token=function(){var s;if(this.last_token==="TK_TAG_SCRIPT"||this.last_token==="TK_TAG_STYLE"){var t=this.last_token.substr(7);
s=this.get_contents_to(t);if(typeof s!=="string"){return s;}return[s,"TK_"+t];}if(this.current_mode==="CONTENT"){s=this.get_content();if(typeof s!=="string"){return s;
}else{return[s,"TK_CONTENT"];}}if(this.current_mode==="TAG"){s=this.get_tag();if(typeof s!=="string"){return s;}else{var u="TK_TAG_"+this.tag_type;return[s,u];
}}};this.get_full_indent=function(s){s=this.indent_level+s||0;if(s<1){return"";}return Array(s+1).join(this.indent_string);};this.printer=function(v,u,s,x,w){this.input=v||"";
this.output=[];this.indent_character=u;this.indent_string="";this.indent_size=s;this.brace_style=w;this.indent_level=0;this.max_char=x;this.line_char_count=0;
for(var t=0;t<this.indent_size;t++){this.indent_string+=this.indent_character;}this.print_newline=function(A,y){this.line_char_count=0;if(!y||!y.length){return;
}if(!A){while(this.Utils.in_array(y[y.length-1],this.Utils.whitespace)){y.pop();}}y.push("\n");for(var z=0;z<this.indent_level;z++){y.push(this.indent_string);
}};this.print_token=function(y){this.output.push(y);};this.indent=function(){this.indent_level++;};this.unindent=function(){if(this.indent_level>0){this.indent_level--;
}};};return this;}r=new b();r.printer(o,k,l,e,f);while(true){var g=r.get_token();r.token_text=g[0];r.token_type=g[1];if(r.token_type==="TK_EOF"){break;
}switch(r.token_type){case"TK_TAG_START":r.print_newline(false,r.output);r.print_token(r.token_text);r.indent();r.current_mode="CONTENT";break;case"TK_TAG_STYLE":case"TK_TAG_SCRIPT":r.print_newline(false,r.output);
r.print_token(r.token_text);r.current_mode="CONTENT";break;case"TK_TAG_END":if(r.last_token==="TK_CONTENT"&&r.last_text===""){var q=r.token_text.match(/\w+/)[0];
var i=r.output[r.output.length-1].match(/<\s*(\w+)/);if(i===null||i[1]!==q){r.print_newline(true,r.output);}}r.print_token(r.token_text);r.current_mode="CONTENT";
break;case"TK_TAG_SINGLE":r.print_newline(false,r.output);r.print_token(r.token_text);r.current_mode="CONTENT";break;case"TK_CONTENT":if(r.token_text!==""){r.print_token(r.token_text);
}r.current_mode="TAG";break;case"TK_STYLE":case"TK_SCRIPT":if(r.token_text!==""){r.output.push("\n");var h=r.token_text;if(r.token_type=="TK_SCRIPT"){var n=typeof js_beautify=="function"&&js_beautify;
}else{if(r.token_type=="TK_STYLE"){var n=typeof css_beautify=="function"&&css_beautify;}}if(c.indent_scripts=="keep"){var j=0;}else{if(c.indent_scripts=="separate"){var j=-r.indent_level;
}else{var j=1;}}var a=r.get_full_indent(j);if(n){h=n(h.replace(/^\s*/,a),c);}else{var d=h.match(/^\s*/)[0];var m=d.match(/[^\n\r]*$/)[0].split(r.indent_string).length-1;
var p=r.get_full_indent(j-m);h=h.replace(/^\s*/,a).replace(/\r\n|\r|\n/g,"\n"+p).replace(/\s*$/,"");}if(h){r.print_token(h);r.print_newline(true,r.output);
}}r.current_mode="TAG";break;}r.last_token=r.token_type;r.last_text=r.token_text;}return r.output.join("");}