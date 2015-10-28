(function($){
    // **********************************
    // ***** Start: Private Members *****
    var pluginName       = 'encmenu';
    var cssMainClassName = 'encmenu-active';
    var cssMenuClassName = 'encmenu-defaults';
    var cssMenuExpanded  = 'encmenu-expanded';
    var idGenerator      = 0;
    
	var configMenu = function(data){
    	var that = this;

    	if (data.settings.menuContent==undefined) return false;
    	
    	var menu = $(data.settings.menuContent);
    	    	
    	if (!$(that).hasClass(cssMainClassName)){
    		$(that).addClass(cssMainClassName);
    	}
    	
    	if (!$(menu).hasClass(cssMenuClassName)){
    		$(menu).addClass(cssMenuClassName);
    	}
    	    	
    	data.expanded = false;
    	
    	$(menu).hide();
    	
    	var actualID = $(menu).attr("id");
    	if (actualID==""){
    		idGenerator++;
    		actualID = "encmenu-"+idGenerator;
    		$(menu).attr("id", actualID);
    	}

    	$(menu).css("borderWidth", data.settings.borderWidth);
    	$(menu).css("borderColor", data.settings.borderColor);
    	$(menu).css("borderStyle", data.settings.borderStyle);
    	
    	$(menu).css("borderTopWidth", 0);
    	
    	$(menu).css("color", data.settings.fontColor);
    	$(menu).css("backgroundColor", data.settings.bgColor);
    	
		$("#"+actualID+" > li").each(function(index) {
			
			// configura os links
			$(this).children('a').each(function(index) {
				
				$(this).css("color", data.settings.fontColor);

	    		$(this).mouseenter(function() {
	    			$(this).css("color", data.settings.font_hOverColor);
	    			$(this).css("backgroundColor", data.settings.bg_hOverColor);
	    		});

	    		$(this).mouseleave(function() {
	    			$(this).css("color", data.settings.fontColor);
	    			$(this).css("backgroundColor", "transparent");
	    		});							

	    		$(this).mousedown(function() {
	    			$(this).css("backgroundColor", data.settings.font_hOverColor);
	    			$(this).css("color", data.settings.bg_hOverColor);
	    		});							
	    		
	    		$(this).mouseup(function() {
	    			$(this).mouseenter();
	    		});
	    		
	    		$(this).click(function() {
	    			$(this).mouseleave();
	    			closeSingle.call(that, data);
	    		});
	    		
			});		
			
			// configura o li em si
	    	$(this).css("color", data.settings.fontColor);
	    	/*
    		$(this).mouseenter(function() {
    			$(this).css("backgroundColor", data.settings.bg_hOverColor);
    		});

    		$(this).mouseleave(function() {
    			$(this).css("backgroundColor", "transparent");
    		});							
			*/
		});		
    	
    	$(menu).detach();    	
	};
	
	var openSingle = function(data){
    	var that = this;    	
    	
    	if (data.settings.menuContent==undefined) return false;    	
    	var menu = $(data.settings.menuContent);
    	
    	internalCloseAll.call(that);
    	
    	if (!data.expanded){
    		$("body").append($(menu));
        	
        	var offset = $(that).offset();
        	
        	$(menu).css("top", offset.top+$(that).outerHeight());
        	
        	var leftShow = offset.left;
        	
        	if (leftShow+$(menu).outerWidth() > $("body").innerWidth()){
        		leftShow = leftShow - $(menu).outerWidth() + $(that).outerWidth(); 
        	}
        	
        	$(menu).css("left", leftShow);

			if (!$(that).hasClass(cssMenuExpanded)){
	    		$(that).addClass(cssMenuExpanded);
	    	}
        	
    		$(menu).slideDown('fast', function() {    	    	    	    	
            	data.expanded = true;
    		});
    	}
    	
	};
	
	var closeSingle = function(data){
    	var that = this;    	
    	
    	if (data.settings.menuContent==undefined) return false;    	
    	var menu = $(data.settings.menuContent);
    	
    	if (data.expanded){
    		$(menu).slideUp('fast', function() {
            	data.expanded = false;
            	
    			if ($(that).hasClass(cssMenuExpanded)){
    	    		$(that).removeClass(cssMenuExpanded);
    	    	}
    			
    			$(menu).detach();
    		});    		
        	
    	}    	
	};
		
	var internalCloseAll = function(){
    	//var that = this;    	
    	
    	//if (data.settings.menuContent==undefined) return false;    	
    	//var menu = $(data.settings.menuContent);
		
		$("."+cssMenuExpanded).each(function(index){
            var that = $(this);
            var data = that.data(pluginName);
            
            closeSingle.call(that, data);
        });		
	};
	
	var toogleMenu = function(data){
    	var that = this;    	
    	
    	if (data.settings.menuContent==undefined) return false;    	
    	var menu = $(data.settings.menuContent);
    	    	
    	if (data.expanded){
    		closeSingle.call(that, data);
    	}else{
    		openSingle.call(that, data);
    	}
	};
	
    // ***** Fin: Private Members *****
    // ********************************

    // *********************************
    // ***** Start: Public Methods *****
    var methods = {
        init : function(options) {
            //"this" is a jquery object on which this plugin has been invoked.
            return this.each(function(index){
                var $this = $(this);
                var data = $this.data(pluginName);
                // If the plugin hasn't been initialized yet
                if (!data){
                    
                	var settings = {
                			borderColor       : '#000',
                			borderWidth       : 2,
                			borderStyle       : 'solid',
                			fontColor         : '#000',
                			font_hOverColor   : '#3995eb',
                			bgColor           : '#fff',
                			bg_hOverColor     : '#e5e5e5',
                			menuContent       : undefined
                    };
                    
                    if(options) { $.extend(true, settings, options); }

                    $this.data(pluginName, {
                        target    : $this,
                        settings  : settings,
                        expanded  : false
                    });
                    
            		if (settings.menuContent!=undefined){
            			configMenu.call($this, $this.data(pluginName));            		
            		}
                    
            		$($this).click(function() {
            			toogleMenu.call($this, $this.data(pluginName));
            		});
                }
            });
        },
        closeAll: function(){
        	internalCloseAll.call($this);
            /*
        	return this.each(function(index){
                var $this = $(this);
                var data = $this.data(pluginName);
                
                internalCloseAll.call($this);
            });
            */
        }
    };
    // ***** Fin: Public Methods *****
    // *******************************

    // *****************************
    // ***** Start: Supervisor *****
    $.fn[pluginName] = function( method ) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || !method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' + method + ' does not exist in jQuery.' + pluginName );
        }
    };
    // ***** Fin: Supervisor *****
    // ***************************
})( jQuery );