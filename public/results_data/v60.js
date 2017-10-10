function NolTracker(b,a){this.pvar=b;this.mergeFeatures(a)}function nol_t(b,a){return new NolTracker(b,a)}NolTracker.prototype.version="6.0.25";NolTracker.prototype.scriptName=(function(){try{var b=document.getElementsByTagName("script");var c=b[b.length-1].getAttribute("src").match(/[^\/]*$/)}catch(a){}return c||"v60.js"})();NolTracker.prototype.pmap=[["action","at",0],["campaign","ca",1],["col_depth","cd",0],["conn_type","ct",0],["cookies_enabled","ck",0],["creative","cr",1],["execution","ce",1],["flash","fl",0],["ip_address","ip",0],["is_hp","hp",0],["java_enabled","je",0],["language","lg",0],["ownership","ou",1],["page_url","si",1],["placement","pc",1],["primary_group","pg",1],["referrer","rp",1],["resource","rt",0],["result","rn",1],["result_flag","rf",0],["revenue","rv",0],["sample_size","ss",0],["screen_res","sr",0],["stream_dur","sd",0],["sub_resource","st",0],["survey","sv",1],["tag_source","ts",1],["cookie_overwrite","id",0],["timezone","tz",0]];NolTracker.prototype.feat={check_cookie:1,detect_flash:0,detect_technical:1,document_title:0,check_fraud:0,filters:undefined,session_cookie:0,landing_page:1,link_overlay:0,pause_time:500,auto_post:1,sample_rate:1,useLocalStorage:1,surveys_enabled:0};NolTracker.prototype.CONST={max_tags:20};NolTracker.prototype.record=function(){this.postChk=false;this.page_url=""+window.location;this.referrer=""+document.referrer;try{if(this.feat.check_fraud&&(top.location.href.indexOf(document.domain)===-1)){this.detected_fraud=true;return this}this.detected_fraud=false}catch(h){this.detected_fraud=true;return this}if(this.feat.detect_technical){this.java_enabled=(navigator.javaEnabled()===true)?"y":"n";if(document.body.addBehavior){document.body.addBehavior("#default#clientCaps");document.body.addBehavior("#default#homePage");this.conn_type=document.body.connectionType;this.is_hp=document.body.isHomePage(location.href)?"y":"n"}if(window.screen){this.screen_res=window.screen.width+"x"+window.screen.height;this.col_depth=window.screen.colorDepth}if(navigator.userLanguage){this.language=navigator.userLanguage}else{if(navigator.language){this.language=navigator.language}}if(navigator.cookieEnabled){this.pvar.cookies_enabled=(navigator.cookieEnabled===true)?"y":"n"}this.timezone=(new Date()).getTimezoneOffset()/-60}if(this.feat.detect_flash){if(navigator.mimeTypes&&navigator.mimeTypes.length>0){var d="application/x-shockwave-flash";if(navigator.mimeTypes[d]&&navigator.mimeTypes[d].enabledPlugin){var b=this.getVersion(navigator.mimeTypes[d].enabledPlugin.description,1);if(b){this.flash=b}}}else{if(window.ActiveXObject){for(var c=15;c>0;c--){try{if(new ActiveXObject("ShockwaveFlash.ShockwaveFlash."+c)){this.flash=c;break}}catch(g){}}}}}if(this.feat.link_overlay){this.regLinkOverlay()}try{if(typeof window.localStorage==="undefined"){this.feat.useLocalStorage=0}}catch(a){this.feat.useLocalStorage=0}if(this.feat.useLocalStorage){localstorageframe=[this.getSchemeHost(),"storageframe.html"].join("");this.iframe(localstorageframe,"LOCSTORAGE")}return this};NolTracker.prototype.regListen=function(){var a=this;return function(b){if(b.origin.indexOf("imrworldwide.com")!==-1){a.cookie_overwrite=b.data}if(a.postChk){a.post()}}};NolTracker.prototype.iframe=function(b,c){try{var a=window.document.createElement("iframe");a.style.width="1px";a.style.height="1px";a.style.position="absolute";a.style.top="-7px";a.style.left="-7px";a.style.border="0";a.src=b;a.setAttribute("id",c);a.setAttribute("scrolling","no");window.document.body.insertBefore(a,window.document.body.firstChild);if(window.addEventListener){addEventListener("message",this.regListen(),false)}else{attachEvent("onmessage",this.regListen())}}catch(d){d.code=d.code?d.code:d.code=1;throw (d)}};NolTracker.prototype.prefix=function(){var b=(arguments[0]&&arguments[0].api)?arguments[0].api:"m";var a=[this.getSchemeHost(),"cgi-bin/",b,"?","rnd=",(new Date()).getTime(),"&ci=",this.pvar.cid,"&js=1"];if(b==="m"){a.push("&cg=",escape((arguments[0]&&arguments[0].content)?arguments[0].content:(this.pvar.content||"0")))}if(this.scriptName){a.push("&ts=",this.scriptName)}if(this.version){a.push("&vn=",this.version)}return a.join("")};NolTracker.prototype.filter=function(b){if(this.feat.filters){for(var a in this.feat.filters){if(this.feat.filters.hasOwnProperty(a)){b=this.feat.filters[a](b)}}}return b};NolTracker.prototype.post=function(){if(this.feat.useLocalStorage&&typeof this.cookie_overwrite==="undefined"){this.postChk=true;return this}this.postChk=false;var b=[this.prefix()];b.push("&cc=",((this.feat.check_cookie)?"1":"0"));if(this.feat.document_title){var q=escape(document.title);if(q){b.push("&tl=",q)}}if(this.feat.landing_page&&this.referrer&&(document.location.search.search(/[&?]nol\./)!==-1)){var c=[];var n=document.location.search.substring(document.location.search.lastIndexOf("?")+1).split("&");for(var g in n){if(n.hasOwnProperty(g)&&(n[g].search(/^nol\./)!==-1)){if(n[g].search(/^nol\.redirect/)!==-1){var m=n[g].split("=",2)[1]}else{c.push("&",n[g])}}}if(c.length>0){b.push("&lp=1");b=b.concat(c)}this.page_url=this.page_url.replace(/[&?]nol\..*?=[^&]*/g,"").replace(/&&/g,"&").replace(/\?&/,"?").replace(/[&\?]$/,"");if(this.referrer.search(/[&?]nol\./)){this.referrer=this.referrer.replace(/[&?]nol\..*?=[^&]*/g,"").replace(/&&/g,"&").replace(/\?&/,"?").replace(/[&\?]$/,"")}}for(var k=0,h=this.pmap.length;k<h;k++){var a=this.pmap[k][0];var p=this.pmap[k][1];var f=this.pmap[k][2];var e=null;if(this.pvar[a]){e=this.pvar[a]}else{if(this[a]){e=this[a]}}if(e){b.push("&",p,"=",((f)?escape(e):e))}}if(this.pvar.custom){var o=0;for(var d in this.pvar.custom){if(this.pvar.custom.hasOwnProperty(d)){if(o>=this.CONST.max_tags){break}var l=this.pvar.custom[d];b.push("&c",o,"=",escape(d),",",escape(l));o++}}}this.postData(b.join(""));if(m){setTimeout(function(){window.location=m},this.feat.pause_time)}return this};NolTracker.prototype.postEvent=function(){var a=[this.prefix({content:arguments[0].content})];var b=arguments[0].page_url||this.pvar.page_url||this.page_url;if(arguments[0].event_type){var c=[arguments[0].event_type,escape(b),escape(this.pvar.page_url||this.page_url)].join("_");a.push("&cc=1","&si=",c,"&rp=",(this.previousEventPage||escape(window.location)));if(this.cookie_overwrite){a.push("&id=",this.cookie_overwrite)}this.previousEventPage=c}else{a.push("&cc=0","&si=",this.pvar.cid,"-ctgw-",escape(b),"&rp=",escape(window.location))}this.postData(a.join(""));return this};NolTracker.prototype.postLinkTrack=function(){this.postEvent(arguments[0]);this.pause(this.feat.pause_time);return this};NolTracker.prototype.postEventTrack=function(){this.postEvent(arguments[0]);return this};NolTracker.prototype.postClickTrack=function(){this.postEvent(arguments[0]);if(arguments[0].page_url){var a=arguments[0].page_url;setTimeout(function(){window.location=a},this.feat.pause_time)}return this};NolTracker.prototype.linkTrack=function(){this.postLinkTrack({page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.eventTrack=function(){this.postEventTrack({page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.clickTrack=function(){this.postClickTrack({page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.pageEvent=function(){this.postEventTrack({event_type:"page",page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.slideEvent=function(){this.postEventTrack({event_type:"slide",page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.sectionEvent=function(){this.postEventTrack({event_type:"section",page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.downloadEvent=function(){this.postLinkTrack({event_type:"download",page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.clickEvent=function(){this.postClickTrack({event_type:"click_link",page_url:arguments[0],content:arguments[1]})};NolTracker.prototype.regLinkOverlay=function(){if(!document.getElementById){return}var b=this;var a=document.body.onclick;document.body.onclick=function(c){b.catchLinkOverlay(c);if(a){a(c)}}};NolTracker.prototype.sendIt=function(c,d,e,a){var b=[this.prefix(),"&cc=0","&si=",this.pvar.cid,"-ctpo-",escape(unescape(c).replace(/^\s+|\s+$/g,"").replace(/\s+/g," ")),"&rp=",escape(this.pvar.link_url||window.location),"&tt=",escape(d.toLowerCase()),"&cn=",escape(e.toLowerCase()),"&cv=",escape(unescape(a).replace(/^\s+|\s+$/g,"").replace(/\s+/g," "))];this.postData(b.join(""));this.pause(this.feat.pause_time)};NolTracker.prototype.sendALink=function(b){var a=b.innerHTML.toLowerCase().indexOf("img")>-1?"image":"text";this.sendIt(b.href,b.tagName,a,b.innerHTML)};NolTracker.prototype.sendForm=function(a){if(a.form===null||a.form.action===null){return}var b="";if(a.type==="image"){b=a.src}else{if(a.tagName==="BUTTON"){b=a.innerHTML;if(b===""){b=a.value}}else{b=a.value}}this.sendIt(a.form.action,a.form.tagName,a.type,b)};NolTracker.prototype.catchLinkOverlay=function(b){var a=b?b.target:window.event.srcElement;if((a.tagName==="INPUT"||a.tagName==="BUTTON")&&(a.type==="image"||a.type==="submit"||a.type==="button")){this.sendForm(a)}else{for(;a!==null&&a.tagName!=="BODY";a=a.parentNode){if((a.tagName==="A")&&(a.href.length>0)){this.sendALink(a);break}}}};NolTracker.prototype.invite=function(){if(this.detected_fraud||(this.feat.surveys_enabled!==1)){return this}var f=[this.prefix({api:"j"}),"&cc=0","&se=",((this.feat.surveys_enabled)?"1":"0"),"&te=0"];for(var g=0,e=this.pmap.length;g<e;g++){var d=this.pmap[g][0];var a=this.pmap[g][1];var c=this.pmap[g][2];var h=null;if(this.pvar[d]){h=this.pvar[d]}else{if(this[d]){h=this[d]}}if(h){f.push("&",a,"=",((c)?escape(h):h))}}var b=["<scr",'ipt type="text/javascript" src="',f.join(""),'"></scr',"ipt>"].join("");document.write(b);return this};NolTracker.prototype.in_sample=function(){return(this.random()<=this.feat.sample_rate)};NolTracker.prototype.do_sample=function(){if(this.in_sample()===true){this.invite()}return this};NolTracker.prototype.postData=function(a){try{if(this.detected_fraud){return}if(this.feat.filters){a=this.filter(a)}var c=new Image(1,1);c.onerror=c.onload=function(){c.onerror=c.onload=null};c.src=a}catch(b){}};NolTracker.prototype.getVersion=function(e,b){var d=0;var c=0;for(var a=0;a<b&&d>=0;a++){if(d>0){c=d+1}d=e.indexOf(".",c)}return(d>0)?e.substring(c,d).match(/\d+$/):null};NolTracker.prototype.mergeFeatures=function(b){if(typeof b==="undefined"){return}var a={};for(var c in this.feat){if(typeof b[c]==="undefined"){a[c]=this.feat[c]}else{a[c]=b[c]}}this.feat=a};NolTracker.prototype.getSchemeHost=function(){var a=[location.protocol.indexOf("https")!==-1?"https://":"http://",this.pvar.server,(this.pvar.server.indexOf("imrworldwide.com")===-1)?".imrworldwide.com":"","/"];return a.join("")};NolTracker.prototype.pause=function(a){if(!window.ActiveXObject){if((navigator.userAgent.indexOf("Safari")!==-1)&&(navigator.userAgent.indexOf("Chrome")===-1)){return}var b=(new Date()).getTime()+a;while((new Date())<b){}}};NolTracker.prototype.random=function(){var b=714025;var c=4096;var a=150889;if(typeof this.random_seed==="undefined"){this.random_seed=(new Date()).getTime()%b}this.random_seed=(this.random_seed*c+a)%b;return this.random_seed/b};if(!Array.prototype.push){Array.prototype.push=function(){for(var a=0;a<arguments.length;a++){this[this.length]=arguments[a]}}};