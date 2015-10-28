(function($){
    // **********************************
    // ***** Start: Private Members *****
    var pluginName = 'encslider';
    
    var doPreloadImg = function(data){

    	var that = this;
    	var imagesDir        = data.settings.imagesDir;
    	var numberOfSlides   = data.settings.numberOfSlides;
    	var defaultExtension = data.settings.defaultExtension;
    	var plImgArray       = data.settings.plImgArray;
    	var imgPath          = '';
    	
    	for (i = 1; i <= numberOfSlides; i++) {
    		imgPath = imagesDir+i+'.'+defaultExtension;
    		plImgArray[i] = new Image();
    		plImgArray[i].src = imgPath;
		}

	};
    
    var	checkAutoSlide = function(data){
    	var that = this;

		if (data.settings.autoSlide && data.settings.enabled){
			if (data.slideTimer==undefined){
				data.slideTimer = window.setInterval(function(){doSlide.call(that, 'n', data)}, data.settings.slideInterval);
			}
		}else{
			if (data.slideTimer!=undefined){
				window.clearInterval(data.slideTimer);
				data.slideTimer = undefined;
			}
		}
	};
    
	var setEnabled = function(enabled, data){
    	var that = this;
    	
		data.settings.enabled = enabled;
		checkAutoSlide.call(that, data);
	};		
	
    var doSlide = function(action, data){

    	var that = this;
        
		if (action == 'n'){
			data.actualSlide++;	
		}else{
			data.actualSlide--;	
		}

		if (data.actualSlide < 1)
			data.actualSlide = data.settings.numberOfSlides;
			
		if (data.actualSlide > data.settings.numberOfSlides)
			data.actualSlide = 1;

		if ($.browser.msie){		
			browserVersion = parseInt($.browser.version.substr(0, 1)); 

			if (browserVersion < 8){
				$(that).css('background-image', 'url('+data.settings.imagesDir+data.actualSlide+'.'+data.settings.defaultExtension+')');
				$(that).hide();
				$(that).show();
			}else{
				$(that).css('background-image', 'url('+data.settings.imagesDir+data.actualSlide+'.'+data.settings.defaultExtension+')');
				$(that).fadeIn();
			}
		}else{
			$(that).css('background-image', 'url('+data.settings.imagesDir+data.actualSlide+'.'+data.settings.defaultExtension+')');
			$(that).fadeIn();
		}

		var loadAjaxContent   = data.settings.loadAjaxContent; 
		var loadAjaxFrom      = data.settings.loadAjaxFrom; 
		var ajaxContentTarget = data.settings.ajaxContentTarget;
		var ajaxDataName      = data.settings.ajaxDataName;
		
		if (
			loadAjaxContent &&
			loadAjaxFrom != '' &&
			ajaxContentTarget != undefined &&
			ajaxDataName != ''
			){
			
			var actualContent = $(ajaxContentTarget).html();

			$.ajax( {
				type :"POST",
				async:false,
				url :loadAjaxFrom,
				data:ajaxDataName+"="+data.actualSlide,
				beforeSend : function() {
				},
				success : function(txt) {

					if (txt==""){
						$(ajaxContentTarget).html(actualContent);
						$(ajaxContentTarget).show();
					}else{
						$(ajaxContentTarget).html(txt);
						$(ajaxContentTarget).show();
					}
				},
				error : function(txt) {
					$(ajaxContentTarget).html(actualContent);
					$(ajaxContentTarget).show();
				}
			});		
			
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
                			autoSlide         : true,
                			enabled           : true,
                			slideInterval     : 5000,
                			stopOnMouseOver   : true,
                			initialSlide      : 1,
                			numberOfSlides    : 0,
                			defaultExtension  : 'jpg',
                			imagesDir         : 'none',
                			loadAjaxContent   : false,
                			loadAjaxFrom      : '',
                			ajaxContentTarget : undefined,
                			ajaxDataName      : 'idx',
                			nextObject        : undefined,
                			priorObject       : undefined,
                			plImgArray        : new Array()
                    };
                    
                    if(options) { $.extend(true, settings, options); }

                    $this.data(pluginName, {
                        target : $this,
                        settings: settings,
                        actualSlide: settings.initialSlide-1,
                        slideTimer: null
                    });
                    
            		if (settings.nextObject!=undefined){
            			settings.nextObject.click(function(e){
            				doSlide.call($this, 'n', $this.data(pluginName));
            			})
            		}
            		
            		if (settings.priorObject!=undefined){
            			settings.priorObject.click(function(e){
            				doSlide.call($this, 'p', $this.data(pluginName));
            			})
            		}
            		
            		$($this).mouseenter(function() {
            			if (settings.stopOnMouseOver)
            				setEnabled.call($this, false, $this.data(pluginName));
            		});

            		$($this).mouseleave(function() {
        				setEnabled.call($this, true, $this.data(pluginName));
            		});				
            		
            		doPreloadImg.call($this, $this.data(pluginName));
                    doSlide.call($this, 'n', $this.data(pluginName));
                    checkAutoSlide.call($this, $this.data(pluginName));
                }
            });
        },
        play: function(){
            return this.each(function(index){
                var $this = $(this);
                var data = $this.data(pluginName);
				setEnabled.call($this, true, data);
            });
        },
        pause: function(){
            return this.each(function(index){
                var $this = $(this);
                var data = $this.data(pluginName);
				setEnabled.call($this, false, data);
            });
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