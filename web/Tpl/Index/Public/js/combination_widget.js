

function dsqComboTab(tab) {
	document.getElementById('dsq-combo-people').style.display = "none";
	document.getElementById('dsq-combo-popular').style.display = "none";
	document.getElementById('dsq-combo-recent').style.display = "none";
	document.getElementById('dsq-combo-tab-people').className = "dsq-combo-tab";
	document.getElementById('dsq-combo-tab-popular').className = "dsq-combo-tab";
	document.getElementById('dsq-combo-tab-recent').className = "dsq-combo-tab";

	document.getElementById('dsq-combo-' + tab).style.display = "block";
	document.getElementById('dsq-combo-tab-' + tab).className = "dsq-combo-tab dsq-active";
}

document.write(' \
<style type="text/css" media="screen">\
	 #dsq-combo-widget ul,\
	 #dsq-combo-widget li,\
	 #dsq-combo-widget ol,\
	 #dsq-combo-widget div,\
	 #dsq-combo-widget p,\
	 #dsq-combo-widget a,\
	 #dsq-combo-widget cite,\
	 #dsq-combo-widget img {\
	 border: 0;\
	 padding: 0;\
	 margin: 0;\
	 float: none;\
	 text-indent: 0;\
	 background: none;\
	 }\
	 #dsq-combo-widget ul,\
	 #dsq-combo-widget li,\
	 #dsq-combo-widget ol {\
	 list-style-type: none;\
	 list-style-image: none;\
	 background: none;\
	 display: block;\
	 }\
	 #dsq-combo-widget #dsq-combo-content ul,\
	 #dsq-combo-widget #dsq-combo-content li,\
	 #dsq-combo-widget #dsq-combo-content ol,\
	 #dsq-combo-widget #dsq-combo-content div,\
	 #dsq-combo-widget #dsq-combo-content p,\
	 #dsq-combo-widget #dsq-combo-content a,\
	 #dsq-combo-widget #dsq-combo-content cite,\
	 #dsq-combo-widget #dsq-combo-content img {\
	 border: 0;\
	 padding: 0;\
	 margin: 0;\
	 float: none;\
	 text-indent: 0;\
	 background: none;\
	 }\
	 #dsq-combo-widget #dsq-combo-content ul,\
	 #dsq-combo-widget #dsq-combo-content li,\
	 #dsq-combo-widget #dsq-combo-content ol {\
	 list-style-type: none;\
	 list-style-image: none;\
	 background: none;\
	 display: block;\
	 }\
	 .dsq-clearfix:after {\
	 content:".";\
	 display: block;\
	 height: 0;\
	 clear: both;\
	 visibility: hidden;\
	 }\
	 /* end reset */\
	 #dsq-combo-widget { ;\
	 text-align: left;\
	 }\
	 #dsq-combo-widget #dsq-combo-tabs {\
	 float: left;\
	 }\
	 #dsq-combo-widget #dsq-combo-content {\
	 position: static;\
	 }\
	 #dsq-combo-widget #dsq-combo-content h3 {\
	 float: none;\
	 text-indent: 0;\
	 background: none;\
	 padding: 0;\
	 border: 0;\
	 margin: 0 0 10px 0;\
	 font-size: 16px;\
	 }\
	 #dsq-combo-widget #dsq-combo-tabs li {\
	 display: inline;\
	 float: left;\
	 margin-right: 2px;\
	 padding: 0px 5px;\
	 text-transform: uppercase;\
	 }\
	 #dsq-combo-widget #dsq-combo-tabs li a {\
	 text-decoration: none;\
	 font-weight: bold;\
	 font-size: 10px;\
	 }\
	 #dsq-combo-widget #dsq-combo-content .dsq-combo-box {\
	 margin: 0 0 20px;\
	 padding: 12px;\
	 clear: both;\
	 }\
	 #dsq-combo-widget #dsq-combo-content .dsq-combo-box li {\
	 padding-bottom: 10px;\
	 margin-bottom: 10px;\
	 overflow: hidden;\
	 word-wrap: break-word;\
	 }\
	 #dsq-combo-widget #dsq-combo-content .dsq-combo-avatar {\
	 float: left;\
	 height: 48px;\
	 width: 48px;\
	 margin-right: 15px;\
	 }\
	 #dsq-combo-widget #dsq-combo-content .dsq-combo-box cite {\
	 font-weight: bold;\
	 font-size: 14px;\
	 }\
	 span.dsq-widget-clout {\
	 background-color:#FF7300;\
	 color:#FFFFFF;\
	 padding:0pt 2px;\
	 }\
	 #dsq-combo-logo { text-align: right; }\
	 /* Blue */\
	 #dsq-combo-widget.blue #dsq-combo-tabs li.dsq-active { background: #E1F3FC; }\
	 #dsq-combo-widget.blue #dsq-combo-content .dsq-combo-box { background: #E1F3FC; }\
	 #dsq-combo-widget.blue #dsq-combo-tabs li { background: #B5E2FD; }\
	 #dsq-combo-widget.blue #dsq-combo-content .dsq-combo-box li { border-bottom: 1px dotted #B5E2FD; }\
	 /* Grey */\
	 #dsq-combo-widget.grey #dsq-combo-tabs li.dsq-active { background: #f0f0f0; }\
	 #dsq-combo-widget.grey #dsq-combo-content .dsq-combo-box { background: #f0f0f0; }\
	 #dsq-combo-widget.grey #dsq-combo-tabs li { background: #ccc; }\
	 #dsq-combo-widget.grey #dsq-combo-content .dsq-combo-box li { border-bottom: 1px dotted #ccc; }\
	 /* Green */\
	 #dsq-combo-widget.green #dsq-combo-tabs li.dsq-active { background: #f4ffea; }\
	 #dsq-combo-widget.green #dsq-combo-content .dsq-combo-box { background: #f4ffea; }\
	 #dsq-combo-widget.green #dsq-combo-tabs li { background: #d7edce; }\
	 #dsq-combo-widget.green #dsq-combo-content .dsq-combo-box li { border-bottom: 1px dotted #d7edce; }\
	 /* Red */\
	 #dsq-combo-widget.red #dsq-combo-tabs li.dsq-active { background: #fad8d8; }\
	 #dsq-combo-widget.red #dsq-combo-content .dsq-combo-box { background: #fad8d8; }\
	 #dsq-combo-widget.red #dsq-combo-tabs li { background: #fdb5b5; }\
	 #dsq-combo-widget.red #dsq-combo-content .dsq-combo-box li { border-bottom: 1px dotted #fdb5b5; }\
	 /* Orange */\
	 #dsq-combo-widget.orange #dsq-combo-tabs li.dsq-active { background: #fae6d8; }\
	 #dsq-combo-widget.orange #dsq-combo-content .dsq-combo-box { background: #fae6d8; }\
	 #dsq-combo-widget.orange #dsq-combo-tabs li { background: #fddfb5; }\
	 #dsq-combo-widget.orange #dsq-combo-content .dsq-combo-box li { border-bottom: 1px dotted #fddfb5; }\
	 </style>\
	 <div id="dsq-combo-widget" class="grey">\
	 <ul id="dsq-combo-tabs">\
	 <li id="dsq-combo-tab-people" ><a href="#" onclick="dsqComboTab(\'people\'); return false">People</a></li>\
	 <li id="dsq-combo-tab-recent" class="dsq-active"><a href="#" onclick="dsqComboTab(\'recent\'); return false">Recent</a></li>\
	 <li id="dsq-combo-tab-popular" ><a href="#" onclick="dsqComboTab(\'popular\'); return false">Popular</a></li>\
	 </ul>\
	 <div id="dsq-combo-content">\
	 <div id="dsq-combo-people" class="dsq-combo-box" style="display:none">\
	 <h3>Top Commenters</h3>\
	 <ul>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/cknox/">\
	 <img class="dsq-combo-avatar" src="//a.disquscdn.com/uploads/users/720/2931/avatar92.jpg?1297363706">\
	 </a>\
	 <cite><a href="https://disqus.com/by/cknox/">Craig Knox</a></cite>\
	 <div><span class="dsq-widget-clout" title="Clout: Reputation on Disqus"></span>&nbsp;&middot;&nbsp;50 posts</div>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/maciejew/">\
	 <img class="dsq-combo-avatar" src="//a.disquscdn.com/uploads/users/4252/6353/avatar92.jpg?1400722985">\
	 </a>\
	 <cite><a href="https://disqus.com/by/maciejew/">Adam Maciejewski</a></cite>\
	 <div><span class="dsq-widget-clout" title="Clout: Reputation on Disqus"></span>&nbsp;&middot;&nbsp;29 posts</div>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/vmlaw/">\
	 <img class="dsq-combo-avatar" src="//a.disquscdn.com/uploads/users/739/4022/avatar92.jpg?1299217579">\
	 </a>\
	 <cite><a href="https://disqus.com/by/vmlaw/">Vivian Law</a></cite>\
	 <div><span class="dsq-widget-clout" title="Clout: Reputation on Disqus"></span>&nbsp;&middot;&nbsp;25 posts</div>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/pbliu/">\
	 <img class="dsq-combo-avatar" src="//a.disquscdn.com/1436308898/images/noavatar92.png">\
	 </a>\
	 <cite><a href="https://disqus.com/by/pbliu/">pbliu</a></cite>\
	 <div><span class="dsq-widget-clout" title="Clout: Reputation on Disqus"></span>&nbsp;&middot;&nbsp;13 posts</div>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/tjewison/">\
	 <img class="dsq-combo-avatar" src="//a.disquscdn.com/1436308898/images/noavatar92.png">\
	 </a>\
	 <cite><a href="https://disqus.com/by/tjewison/">Timothy Jewison</a></cite>\
	 <div><span class="dsq-widget-clout" title="Clout: Reputation on Disqus"></span>&nbsp;&middot;&nbsp;7 posts</div>\
	 </li>\
	 </ul>\
	 <div id="dsq-combo-logo"><a href="http://disqus.com"><img src="//a.disquscdn.com/1436308898/images/embed/widget-logo.png"></a></div>\
	 </div>\
	 <div id="dsq-combo-recent" class="dsq-combo-box" >\
	 <h3>Recent Comments</h3>\
	 <ul>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/kkwj/"><img class="dsq-combo-avatar" src="//a.disquscdn.com/uploads/users/16456/8717/avatar92.jpg?1436300314"></a>\
	 <a class="dsq-widget-user" href="https://disqus.com/by/kkwj/">kkwj</a>\
	 <span class="dsq-widget-comment"><p>Why do this drug\'s targets not show up in the CSV drug_target_uniprot_links that you can download from drugbank?</p></span>\
	 <p class="dsq-widget-meta"><a href="http://www.drugbank.ca/drugs/DB04743">DrugBank: Nimesulide (DB04743)</a>&nbsp;&middot;&nbsp;<a href="http://www.drugbank.ca/drugs/DB04743#comment-2122114409">1 day ago</a></p>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/chemlynx/"><img class="dsq-combo-avatar" src="//a.disquscdn.com/uploads/users/16452/7856/avatar92.jpg?1436280840"></a>\
	 <a class="dsq-widget-user" href="https://disqus.com/by/chemlynx/">David Sharpe</a>\
	 <span class="dsq-widget-comment"><p>The structure as depicted is in error due to missing stereochemical information the isopropyl substituent should have stereochemistry to define either a cis or trans relationship between it and the...</p></span>\
	 <p class="dsq-widget-meta"><a href="http://www.drugbank.ca/drugs/DB00731">DrugBank: Nateglinide (DB00731)</a>&nbsp;&middot;&nbsp;<a href="http://www.drugbank.ca/drugs/DB00731#comment-2121509536">1 day ago</a></p>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/disqus_eOjxUXE0Sk/"><img class="dsq-combo-avatar" src="//a.disquscdn.com/uploads/users/8442/9201/avatar92.jpg?1436176674"></a>\
	 <a class="dsq-widget-user" href="https://disqus.com/by/disqus_eOjxUXE0Sk/">JT</a>\
	 <span class="dsq-widget-comment"><p>Radium is not a lanthanide - it\'s in Group 2 and is an alkaline earth</p></span>\
	 <p class="dsq-widget-meta"><a href="http://www.drugbank.ca/drugs/DB08913">DrugBank: Radium Ra 223 Dichloride (DB08913)</a>&nbsp;&middot;&nbsp;<a href="http://www.drugbank.ca/drugs/DB08913#comment-2119158811">2 days ago</a></p>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/pradnyaghoderao/"><img class="dsq-combo-avatar" src="//a.disquscdn.com/1436308898/images/noavatar92.png"></a>\
	 <a class="dsq-widget-user" href="https://disqus.com/by/pradnyaghoderao/">pradnya ghoderao</a>\
	 <span class="dsq-widget-comment"><p>Can anyone tell me how to create .pdb file of HPC?</p></span>\
	 <p class="dsq-widget-meta"><a href="http://www.drugbank.ca/drugs/DB00840">DrugBank: Hydroxypropyl cellulose (DB00840)</a>&nbsp;&middot;&nbsp;<a href="http://www.drugbank.ca/drugs/DB00840#comment-2075098342">3 weeks ago</a></p>\
	 </li>\
	 <li class="dsq-clearfix">\
	 <a href="https://disqus.com/by/maciejew/"><img class="dsq-combo-avatar" src="//a.disquscdn.com/uploads/users/4252/6353/avatar92.jpg?1400722985"></a>\
	 <a class="dsq-widget-user" href="https://disqus.com/by/maciejew/">Adam Maciejewski</a>\
	 <span class="dsq-widget-comment"><p>Hello,</p><p>Please see under the section "Prescription Products" for Lipitor product and manufacturer information.</p><p>Thank you,</p><p>Adam</p></span>\
	 <p class="dsq-widget-meta"><a href="http://www.drugbank.ca/drugs/DB01076">DrugBank: Atorvastatin (DB01076)</a>&nbsp;&middot;&nbsp;<a href="http://www.drugbank.ca/drugs/DB01076#comment-2074731982">3 weeks ago</a></p>\
	 </li>\
	 </ul>\
	 <div id="dsq-combo-logo"><a href="http://disqus.com"><img src="//a.disquscdn.com/1436308898/images/embed/widget-logo.png"></a></div>\
	 </div>\
	 <div id="dsq-combo-popular" class="dsq-combo-box" style="display:none">\
	 <h3>Most Discussed</h3>\
	 <ul>\
	 </ul>\
	 <div id="dsq-combo-logo"><a href="http://disqus.com"><img src="//a.disquscdn.com/1436308898/images/embed/widget-logo.png"></a></div>\
	 </div>\
	 </div>\
	 </div>\
');
