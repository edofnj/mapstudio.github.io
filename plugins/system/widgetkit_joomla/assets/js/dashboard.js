/* Copyright (C) YOOtheme GmbH, YOOtheme Proprietary Use License (http://www.yootheme.com/license) */

(function($){var Plugin=function(){};$.extend(Plugin.prototype,{name:"JoomlaDashboard",options:{edit_ids:[]},initialize:function(element,options){this.options=$.extend({},this.options,options);var $this=this;element.find(".actions a.action.edit").each(function(){if($.inArray($(this).siblings("a.action.delete").attr("data-id").toString(),$this.options.edit_ids)>-1){$(this).closest("tr").find("a").each(function(){$(this).attr("href",$(this).attr("href").replace(/task=edit_([\w\d]*)/i,"task=edit_$1_joomla"))})}});element.find("a.button-secondary:first").each(function(){var add=$(this).clone();$(this).after(add.text("Use Joomla").addClass("joomla").attr("href",add.attr("href")+"_joomla"))})}});$.fn[Plugin.prototype.name]=function(){var args=arguments;var method=args[0]?args[0]:null;return this.each(function(){var element=$(this);if(Plugin.prototype[method]&&element.data(Plugin.prototype.name)&&method!="initialize"){element.data(Plugin.prototype.name)[method].apply(element.data(Plugin.prototype.name),Array.prototype.slice.call(args,1))}else if(!method||$.isPlainObject(method)){var plugin=new Plugin;if(Plugin.prototype["initialize"]){plugin.initialize.apply(plugin,$.merge([element],args))}element.data(Plugin.prototype.name,plugin)}else{$.error("Method "+method+" does not exist on jQuery."+Plugin.name)}})}})(jQuery);