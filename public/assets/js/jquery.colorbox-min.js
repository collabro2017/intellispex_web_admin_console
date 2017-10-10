/*!
	jQuery Colorbox v1.4.14 - 2013-04-16
	(c) 2013 Jack Moore - jacklmoore.com/colorbox
	license: http://www.opensource.org/licenses/mit-license.php
*/
(function(M,l,Z){var N={transition:"elastic",speed:300,fadeOut:300,width:false,initialWidth:"600",innerWidth:false,maxWidth:false,height:false,initialHeight:"450",innerHeight:false,maxHeight:false,scalePhotos:true,scrolling:true,inline:false,html:false,iframe:false,fastIframe:true,photo:false,href:false,title:false,rel:false,opacity:0.9,preloading:true,className:false,retinaImage:false,retinaUrl:false,retinaSuffix:"@2x.$1",current:"image {current} of {total}",previous:"previous",next:"next",close:"close",xhrError:"This content failed to load.",imgError:"This image failed to load.",open:false,returnFocus:true,reposition:true,loop:true,slideshow:false,slideshowAuto:true,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",photoRegex:/\.(gif|png|jp(e|g|eg)|bmp|ico)((#|\?).*)?$/i,onOpen:false,onLoad:false,onComplete:false,onCleanup:false,onClosed:false,overlayClose:true,escKey:true,arrowKey:true,top:false,bottom:false,left:false,right:false,fixed:false,data:undefined},x="colorbox",V="cbox",r=V+"Element",Y=V+"_open",e=V+"_load",X=V+"_complete",v=V+"_cleanup",ae=V+"_closed",i=V+"_purge",T,aj,ak,d,K,p,b,S,c,ac,Q,k,h,o,u,aa,t,U,z,B,I=M("<a/>"),ah,al,m,g,a,w,L,n,D,ab,P,A,O,ag="div",af,G=0,ad;function J(am,ap,ao){var an=l.createElement(am);if(ap){an.id=V+ap}if(ao){an.style.cssText=ao}return M(an)}function s(){return Z.innerHeight?Z.innerHeight:M(Z).height()}function F(an){var am=c.length,ao=(L+an)%am;return(ao<0)?am+ao:ao}function R(am,an){return Math.round((/%/.test(am)?((an==="x"?ac.width():s())/100):1)*parseInt(am,10))}function C(an,am){return an.photo||an.photoRegex.test(am)}function E(an,am){return an.retinaUrl&&Z.devicePixelRatio>1?am.replace(an.photoRegex,an.retinaSuffix):am}function ai(am){if("contains" in aj[0]&&!aj[0].contains(am.target)){am.stopPropagation();aj.focus()}}function W(){var am,an=M.data(w,x);if(an==null){ah=M.extend({},N);if(console&&console.log){console.log("Error: cboxElement missing settings object")}}else{ah=M.extend({},an)}for(am in ah){if(M.isFunction(ah[am])&&am.slice(0,2)!=="on"){ah[am]=ah[am].call(w)}}ah.rel=ah.rel||w.rel||M(w).data("rel")||"nofollow";ah.href=ah.href||M(w).attr("href");ah.title=ah.title||w.title;if(typeof ah.href==="string"){ah.href=M.trim(ah.href)}}function H(am,an){M(l).trigger(am);I.trigger(am);if(M.isFunction(an)){an.call(w)}}function y(){var an,ap=V+"Slideshow_",aq="click."+V,am,at,ar,ao;if(ah.slideshow&&c[1]){am=function(){clearTimeout(an)};at=function(){if(ah.loop||c[L+1]){an=setTimeout(O.next,ah.slideshowSpeed)}};ar=function(){aa.html(ah.slideshowStop).unbind(aq).one(aq,ao);I.bind(X,at).bind(e,am).bind(v,ao);aj.removeClass(ap+"off").addClass(ap+"on")};ao=function(){am();I.unbind(X,at).unbind(e,am).unbind(v,ao);aa.html(ah.slideshowStart).unbind(aq).one(aq,function(){O.next();ar()});aj.removeClass(ap+"on").addClass(ap+"off")};if(ah.slideshowAuto){ar()}else{ao()}}else{aj.removeClass(ap+"off "+ap+"on")}}function f(am){if(!P){w=am;W();c=M(w);L=0;if(ah.rel!=="nofollow"){c=M("."+r).filter(function(){var ao=M.data(this,x),an;if(ao){an=M(this).data("rel")||ao.rel||this.rel}return(an===ah.rel)});L=c.index(w);if(L===-1){c=c.add(w);L=c.length-1}}T.css({opacity:parseFloat(ah.opacity),cursor:ah.overlayClose?"pointer":"auto",visibility:"visible"}).show();if(af){aj.add(T).removeClass(af)}if(ah.className){aj.add(T).addClass(ah.className)}af=ah.className;z.html(ah.close).show();if(!D){D=ab=true;aj.css({visibility:"hidden",display:"block"});Q=J(ag,"LoadedContent","width:0; height:0; overflow:hidden").appendTo(d);al=K.height()+S.height()+d.outerHeight(true)-d.height();m=p.width()+b.width()+d.outerWidth(true)-d.width();g=Q.outerHeight(true);a=Q.outerWidth(true);ah.w=R(ah.initialWidth,"x");ah.h=R(ah.initialHeight,"y");O.position();y();H(Y,ah.onOpen);B.add(o).hide();aj.focus();if(l.addEventListener){l.addEventListener("focus",ai,true);I.one(ae,function(){l.removeEventListener("focus",ai,true)})}if(ah.returnFocus){I.one(ae,function(){M(w).focus()})}}O.load()}}function q(){if(!aj&&l.body){ad=false;ac=M(Z);aj=J(ag).attr({id:x,"class":M.support.opacity===false?V+"IE":"",role:"dialog",tabindex:"-1"}).hide();T=J(ag,"Overlay").hide();h=J(ag,"LoadingOverlay").add(J(ag,"LoadingGraphic"));ak=J(ag,"Wrapper");d=J(ag,"Content").append(o=J(ag,"Title"),u=J(ag,"Current"),U=M('<button type="button"/>').attr({id:V+"Previous"}),t=M('<button type="button"/>').attr({id:V+"Next"}),aa=J("button","Slideshow"),h,z=M('<button type="button"/>').attr({id:V+"Close"}));ak.append(J(ag).append(J(ag,"TopLeft"),K=J(ag,"TopCenter"),J(ag,"TopRight")),J(ag,false,"clear:left").append(p=J(ag,"MiddleLeft"),d,b=J(ag,"MiddleRight")),J(ag,false,"clear:left").append(J(ag,"BottomLeft"),S=J(ag,"BottomCenter"),J(ag,"BottomRight"))).find("div div").css({"float":"left"});k=J(ag,false,"position:absolute; width:9999px; visibility:hidden; display:none");B=t.add(U).add(u).add(aa);M(l.body).append(T,aj.append(ak,k))}}function j(){function am(an){if(!(an.which>1||an.shiftKey||an.altKey||an.metaKey||an.control)){an.preventDefault();f(this)}}if(aj){if(!ad){ad=true;t.click(function(){O.next()});U.click(function(){O.prev()});z.click(function(){O.close()});T.click(function(){if(ah.overlayClose){O.close()}});M(l).bind("keydown."+V,function(ao){var an=ao.keyCode;if(D&&ah.escKey&&an===27){ao.preventDefault();O.close()}if(D&&ah.arrowKey&&c[1]&&!ao.altKey){if(an===37){ao.preventDefault();U.click()}else{if(an===39){ao.preventDefault();t.click()}}}});if(M.isFunction(M.fn.on)){M(l).on("click."+V,"."+r,am)}else{M("."+r).live("click."+V,am)}}return true}return false}if(M.colorbox){return}M(q);O=M.fn[x]=M[x]=function(am,ao){var an=this;am=am||{};q();if(j()){if(M.isFunction(an)){an=M("<a/>");am.open=true}else{if(!an[0]){return an}}if(ao){am.onComplete=ao}an.each(function(){M.data(this,x,M.extend({},M.data(this,x)||N,am))}).addClass(r);if((M.isFunction(am.open)&&am.open.call(an))||am.open){f(an[0])}}return an};O.position=function(ao,aq){var at,av=0,an=0,ar=aj.offset(),am,ap;ac.unbind("resize."+V);aj.css({top:-90000,left:-90000});am=ac.scrollTop();ap=ac.scrollLeft();if(ah.fixed){ar.top-=am;ar.left-=ap;aj.css({position:"fixed"})}else{av=am;an=ap;aj.css({position:"absolute"})}if(ah.right!==false){an+=Math.max(ac.width()-ah.w-a-m-R(ah.right,"x"),0)}else{if(ah.left!==false){an+=R(ah.left,"x")}else{an+=Math.round(Math.max(ac.width()-ah.w-a-m,0)/2)}}if(ah.bottom!==false){av+=Math.max(s()-ah.h-g-al-R(ah.bottom,"y"),0)}else{if(ah.top!==false){av+=R(ah.top,"y")}else{av+=Math.round(Math.max(s()-ah.h-g-al,0)/2)}}aj.css({top:ar.top,left:ar.left,visibility:"visible"});ao=(aj.width()===ah.w+a&&aj.height()===ah.h+g)?0:ao||0;ak[0].style.width=ak[0].style.height="9999px";function au(aw){K[0].style.width=S[0].style.width=d[0].style.width=(parseInt(aw.style.width,10)-m)+"px";d[0].style.height=p[0].style.height=b[0].style.height=(parseInt(aw.style.height,10)-al)+"px"}at={width:ah.w+a+m,height:ah.h+g+al,top:av,left:an};if(ao===0){aj.css(at)}aj.dequeue().animate(at,{duration:ao,complete:function(){au(this);ab=false;ak[0].style.width=(ah.w+a+m)+"px";ak[0].style.height=(ah.h+g+al)+"px";if(ah.reposition){setTimeout(function(){ac.bind("resize."+V,O.position)},1)}if(aq){aq()}},step:function(){au(this)}})};O.resize=function(am){if(D){am=am||{};if(am.width){ah.w=R(am.width,"x")-a-m}if(am.innerWidth){ah.w=R(am.innerWidth,"x")}Q.css({width:ah.w});if(am.height){ah.h=R(am.height,"y")-g-al}if(am.innerHeight){ah.h=R(am.innerHeight,"y")}if(!am.innerHeight&&!am.height){Q.css({height:"auto"});ah.h=Q.height()}Q.css({height:ah.h});O.position(ah.transition==="none"?0:ah.speed)}};O.prep=function(an){if(!D){return}var aq,ao=ah.transition==="none"?0:ah.speed;Q.empty().remove();Q=J(ag,"LoadedContent").append(an);function am(){ah.w=ah.w||Q.width();ah.w=ah.mw&&ah.mw<ah.w?ah.mw:ah.w;return ah.w}function ap(){ah.h=ah.h||Q.height();ah.h=ah.mh&&ah.mh<ah.h?ah.mh:ah.h;return ah.h}Q.hide().appendTo(k.show()).css({width:am(),overflow:ah.scrolling?"auto":"hidden"}).css({height:ap()}).prependTo(d);k.hide();M(n).css({"float":"none"});aq=function(){var aw=c.length,au,av="frameBorder",ar="allowTransparency",at;if(!D){return}function ax(){if(M.support.opacity===false){aj[0].style.removeAttribute("filter")}}at=function(){clearTimeout(A);h.hide();H(X,ah.onComplete)};o.html(ah.title).add(Q).show();if(aw>1){if(typeof ah.current==="string"){u.html(ah.current.replace("{current}",L+1).replace("{total}",aw)).show()}t[(ah.loop||L<aw-1)?"show":"hide"]().html(ah.next);U[(ah.loop||L)?"show":"hide"]().html(ah.previous);if(ah.slideshow){aa.show()}if(ah.preloading){M.each([F(-1),F(1)],function(){var aB,ay,az=c[this],aA=M.data(az,x);if(aA&&aA.href){aB=aA.href;if(M.isFunction(aB)){aB=aB.call(az)}}else{aB=M(az).attr("href")}if(aB&&C(aA,aB)){aB=E(aA,aB);ay=new Image();ay.src=aB}})}}else{B.hide()}if(ah.iframe){au=J("iframe")[0];if(av in au){au[av]=0}if(ar in au){au[ar]="true"}if(!ah.scrolling){au.scrolling="no"}M(au).attr({src:ah.href,name:(new Date()).getTime(),"class":V+"Iframe",allowFullScreen:true,webkitAllowFullScreen:true,mozallowfullscreen:true}).one("load",at).appendTo(Q);I.one(i,function(){au.src="//about:blank"});if(ah.fastIframe){M(au).trigger("load")}}else{at()}if(ah.transition==="fade"){aj.fadeTo(ao,1,ax)}else{ax()}};if(ah.transition==="fade"){aj.fadeTo(ao,0,function(){O.position(0,aq)})}else{O.position(ao,aq)}};O.load=function(){var ao,ap,an=O.prep,am,aq=++G;ab=true;n=false;w=c[L];W();H(i);H(e,ah.onLoad);ah.h=ah.height?R(ah.height,"y")-g-al:ah.innerHeight&&R(ah.innerHeight,"y");ah.w=ah.width?R(ah.width,"x")-a-m:ah.innerWidth&&R(ah.innerWidth,"x");ah.mw=ah.w;ah.mh=ah.h;if(ah.maxWidth){ah.mw=R(ah.maxWidth,"x")-a-m;ah.mw=ah.w&&ah.w<ah.mw?ah.w:ah.mw}if(ah.maxHeight){ah.mh=R(ah.maxHeight,"y")-g-al;ah.mh=ah.h&&ah.h<ah.mh?ah.h:ah.mh}ao=ah.href;A=setTimeout(function(){h.show()},100);if(ah.inline){am=J(ag).hide().insertBefore(M(ao)[0]);I.one(i,function(){am.replaceWith(Q.children())});an(M(ao))}else{if(ah.iframe){an(" ")}else{if(ah.html){an(ah.html)}else{if(C(ah,ao)){ao=E(ah,ao);M(n=new Image()).addClass(V+"Photo").bind("error",function(){ah.title=false;an(J(ag,"Error").html(ah.imgError))}).one("load",function(){var ar;if(aq!==G){return}n.alt=M(w).attr("alt")||M(w).attr("data-alt")||"";if(ah.retinaImage&&Z.devicePixelRatio>1){n.height=n.height/Z.devicePixelRatio;n.width=n.width/Z.devicePixelRatio}if(ah.scalePhotos){ap=function(){n.height-=n.height*ar;n.width-=n.width*ar};if(ah.mw&&n.width>ah.mw){ar=(n.width-ah.mw)/n.width;ap()}if(ah.mh&&n.height>ah.mh){ar=(n.height-ah.mh)/n.height;ap()}}if(ah.h){n.style.marginTop=Math.max(ah.mh-n.height,0)/2+"px"}if(c[1]&&(ah.loop||c[L+1])){n.style.cursor="pointer";n.onclick=function(){O.next()}}n.style.width=n.width+"px";n.style.height=n.height+"px";setTimeout(function(){an(n)},1)});setTimeout(function(){n.src=ao},1)}else{if(ao){k.load(ao,ah.data,function(at,ar){if(aq===G){an(ar==="error"?J(ag,"Error").html(ah.xhrError):M(this).contents())}})}}}}}};O.next=function(){if(!ab&&c[1]&&(ah.loop||c[L+1])){L=F(1);f(c[L])}};O.prev=function(){if(!ab&&c[1]&&(ah.loop||L)){L=F(-1);f(c[L])}};O.close=function(){if(D&&!P){P=true;D=false;H(v,ah.onCleanup);ac.unbind("."+V);T.fadeTo(ah.fadeOut||0,0);aj.stop().fadeTo(ah.fadeOut||0,0,function(){aj.add(T).css({opacity:1,cursor:"auto"}).hide();H(i);Q.empty().remove();setTimeout(function(){P=false;H(ae,ah.onClosed)},1)})}};O.remove=function(){if(!aj){return}aj.stop();M.colorbox.close();aj.stop().remove();T.remove();P=false;aj=null;M("."+r).removeData(x).removeClass(r);M(l).unbind("click."+V)};O.element=function(){return M(w)};O.settings=N}(jQuery,document,window));