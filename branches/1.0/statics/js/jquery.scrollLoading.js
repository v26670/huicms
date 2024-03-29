/*
 * jquery.scrollLoading.js
 * by zhangxinxu  http://www.zhangxinxu.com
 * 2010-11-19 v1.0
*/
(function($) {
	$.fn.scrollLoading = function(options) {
		var defaults = {
			attr: "data-url"	
		};
		var params = $.extend({}, defaults, options || {});
		params.cache = [];
		$(this).each(function() {
			var node = this.nodeName.toLowerCase(), url = $(this).attr(params["attr"]);
			if (!url) { return; }
			//重组
			var data = {
				obj: $(this),
				tag: node,
				url: url
			};
			params.cache.push(data);
		});
		
		//动态显示数据
		var loading = function() {
			var st = $(window).scrollTop(), sth = st + $(window).height();
			$.each(params.cache, function(i, data) {
				var o = data.obj, tag = data.tag, url = data.url;
				if (o) {
					post = o.position().top; posb = post + o.height();
					if ((post > st && post < sth) || (posb > st && posb < sth)) {
						//在浏览器窗口内
						if (tag === "img") {
							//图片，改变src
							o.attr("src", url);	
						} else {
							o.load(url);
						}	
						data.obj = null;		
					}
				}
			});		
			return false;	
		};
		
		//事件触发
		//加载完毕即执行
		loading();
		//滚动执行
		$(window).bind("scroll", loading);
	};
})(jQuery);