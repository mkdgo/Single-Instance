

;(function($) {

	// Default settings for the plugin
	var defaults = {

		// Data
		data: [],

		// Hotspot Tag
		tag: 'img',

		// Mode of the plugin
		// Options: admin, display
		mode: 'display',

		// HTML5 LocalStorage variable
		LS_Variable: '__HotspotPlugin_LocalStorage',

		// Hidden class for hiding the data
		hiddenClass: 'hidden',

		// Event on which the data will show up
		// Options: click, hover, none
		interactivity: 'click',

		// Buttons' id (Used only in Admin mode)
		done_btnId: 'HotspotPlugin_Done',
		remove_btnId: 'HotspotPlugin_Remove',
		sync_btnId: 'HotspotPlugin_Server',

		// Buttons class
		done_btnClass: 'btn btn-success HotspotPlugin_Done',
		remove_btnClass: 'btn btn-danger HotspotPlugin_Remove',
		sync_btnClass: 'red_btn HotspotPlugin_Server',

		// Classes for Hotspots
		hotspotClass: 'HotspotPlugin_Hotspot',
		hotspotAuxClass: 'HotspotPlugin_inc',

		// Overlay
		hotspotOverlayClass: 'HotspotPlugin_Overlay',

		// Enable ajax
		ajax: false,

		ajaxOptions: {
			url: ''
		},

		// No. of variables included in the spots
		dataStuff: [
			{
				'property': 'Title',
				'default': 'jQuery Hotspot'
			},
			{
				'property': 'Message',
				'default': 'This jQuery Plugin lets you create hotspot to any HTML element. '
			}
		]
	};

	//Constructor
	function Hotspot(element, options) {

		// Overwriting defaults with options
		this.config = $.extend(true, {}, defaults, options);

		this.element = element;
		this.imageEl = element.find(this.config.tag);
		this.imageParent = this.imageEl.parent();

		this.cont = this.imageEl.parents('html');




		this.broadcast = '';

		var widget = this;

		// Event API for users
		$.each(this.config, function(index, val) {
			if (typeof val === 'function') {
				widget.element.on(index + '.hotspot', function() {
					val(widget.broadcast);
				});
			};
		});

		this.init();
	}

	Hotspot.prototype.init = function() {

		this.getData();

		if (this.config.mode != 'admin') {
			return;
		};

		var height = this.imageEl[0].height;
		var width = this.imageEl[0].width;

		// Masking the image
		$('<span/>', {
			html: '<p>This is Admin-mode. Click this Pane to Store Messages</p>'
		}).css({
			'height': height + 'px',
			'width': width + 'px'
		}).addClass(this.config.hotspotOverlayClass).appendTo(this.imageParent);

		var widget = this;
		var data = [];

		// Adding controls
		//$('<button/>', {
		//	text: "Save Data"
		//}).prop('id', this.config.done_btnId).addClass(this.config.done_btnClass).appendTo(this.imageParent);

		//$('<button/>', {
		//	text: "Remove All"
		//}).prop('id', this.config.remove_btnId).addClass(this.config.remove_btnClass).appendTo(this.imageParent);

		$(this.imageParent).delegate('button#' + this.config.done_btnId, 'click', function(event) {
			event.preventDefault();
			widget.storeData(data);
			data = [];
		});

		$(this.imageParent).delegate('button#' + this.config.remove_btnId, 'click', function(event) {
			event.preventDefault();
			widget.removeData();
		});


		if (this.config.ajax) {

		var btn =	$(this.cont).find('.container #app_here')

			$('<a/>', {
				text: "Save"
			}).prop('id', this.config.sync_btnId).addClass(this.config.sync_btnClass).attr('href','javascript:;').appendTo(btn);

			$(btn).delegate('a#' + this.config.sync_btnId, 'click', function(event) {

				event.preventDefault();
				widget.syncToServer();
			});
		};

		// Start storing
		this.element.delegate('span', 'click', function(event) {

			event.preventDefault();

			var offset = $(this).offset();
			var relativeX = (event.pageX - offset.left);
			var relativeY = (event.pageY - offset.top);

			var dataStuff = widget.config.dataStuff;

			var dataBuild = {x: relativeX, y: relativeY};

			for (var i = 0; i < dataStuff.length; i++) {
				var val = dataStuff[i];
				//var fill = prompt('Please enter ' + val.property, val.default);
				var fill = val.property;
				if (fill === null) {
					return;
				};


 			dataBuild[val.property] = fill;


			};

			$('#popupPublAdd .hotspot_title_add').val('');
			$('#popupPublAdd .hotspot_message_add').val('');

 $('#popupPublAdd').modal('show');




			data.push(dataBuild);

			if (widget.config.interactivity === 'none') {
				var htmlBuilt = $('<div/>');
			} else {
				var htmlBuilt = $('<div/>').addClass(widget.config.hiddenClass);
			}

//console.log(htmlBuilt)
			$.each(dataBuild, function(index, val) {
				if (typeof val === "string") {
					$('<div/>', {
						html: val
					}).addClass('Hotspot_' + index).appendTo(htmlBuilt);
				};
			});

			var div = $('<div/>', {
				html: htmlBuilt
			}).css({
				'top': relativeY + 'px',
				'left': relativeX + 'px'
			}).addClass(widget.config.hotspotClass + ' ' + widget.config.hotspotAuxClass).insertAfter('.bg_img');



			if (widget.config.interactivity == 'click') {

				div.on(widget.config.interactivity, function(event) {
					$(this).children('div').toggleClass(widget.config.hiddenClass);

				});
				htmlBuilt.css('display', 'block');
			} else {
				htmlBuilt.removeClass(widget.config.hiddenClass);


			}
			if(widget.config.mode=="admin") {

				$(htmlBuilt).append('<div class="remove_hotspot"></div>');
				$(htmlBuilt).append('<div class="edit_hotspot"></div>');
			}


			$('#popupPublAddBTN').click(function(){



				var first =$('#theElement-a .HotspotPlugin_Hotspot').length;
				//var next_id = parseInt($(first).attr('rel'))+1;

				var next_id = parseInt(first)-1;
				//var current_id = parseInt($(first).attr('rel'));
				//console.log($(htmlBuilt).eq(0));

				//$(htmlBuilt).parent().removeClass('elem_id_'+current_id).addClass('elem_id_'+next_id).attr('rel',next_id)
				$('.HotspotPlugin_Hotspot:first').addClass('elem_id_'+next_id).attr('rel',next_id)
				//console.log($(first));

				var title = $('#popupPublAdd .hotspot_title_add').val();
				var message = $('#popupPublAdd .hotspot_message_add').val();




				$('.elem_id_'+next_id).find('.Hotspot_Title').text(title);
				$('.elem_id_'+next_id).find('.Hotspot_Message').text(message);




				$('#popupPublAdd').modal('hide');

				//$(htmlBuilt).html('');
			});


			$('.remove_hotspot').on('click',function(){
				$(this).parent().parent().remove()
			})
			$('.edit_hotspot').on('click',function(){


				var title = $(this).parent().find('.Hotspot_Title').text();
				var message = $(this).parent().find('.Hotspot_Message').text();
				var elem_id = $(this).parent().parent().attr('rel');
				console.log(title)
				$('#popupPubl .hotspot_title').val(title);
				$('#popupPubl .hotspot_message').val(message);
				$('#popupPubl .elem_id').val(elem_id);

				$('#popupPubl').attr('rel',elem_id).attr('typeof','update');

				$('#popupPubl').modal('show');
			})


			if (widget.config.interactivity === 'none') {

				htmlBuilt.css('display', 'block');
			};


		});





		// TODO - Update and Delete individual nodes
	}

	Hotspot.prototype.getData = function() {

		var widget = this;

		if (localStorage.getItem(this.config.LS_Variable) === null && this.config.data.length == 0) {

			if (this.config.ajax) {
				// Making AJAX call to fetch Data
				var dataObject = {
					data: {
						HotspotPlugin_mode: "Retrieve"
					}
				};
				var ajaxSettings = $.extend({}, this.config.ajaxOptions, dataObject);
				$.ajax(ajaxSettings)
					.done(function(data) {

						localStorage.setItem(widget.config.LS_Variable, data);
						var obj = JSON.parse(data);
						widget.beautifyData();
					})
					.fail(function() {
						return;
					});
			} else {
				return;
			}

		}

		//if (this.config.mode == 'admin' && localStorage.getItem(this.config.LS_Variable) === null) {
		//	return;
		//}

		this.beautifyData();
	}

	Hotspot.prototype.beautifyData = function() {
		var widget = this;
var tt
		if (this.config.mode == 'admin' || this.config.mode == 'display') {
			var self = this;
			var oobj='';
			var ajaxSettings = $.extend({}, this.config.ajaxOptionsGet,self,oobj);

			 $.ajax(ajaxSettings)
				.done(function(data) {
					 oobj = data;
				return oobj;
				}).fail(function() {
					return false;
				});
		}


			//var raw = localStorage.getItem(this.config.LS_Variable);


			//console.log(this.config.ajaxOptionsGet);



				//console.log(oobj);
				//var obj = data;


				//var dd =[{ "x":288, "y":190, "Title":"Title 1","Message":"Image annotation 1" }]

			var obj = JSON.parse(oobj);

			for (var i = obj.length - 1; i >= 0; i--) {
				var el = obj[i];

				if (this.config.interactivity === 'none') {
					var htmlBuilt = $('<div/>');
				} else {
					//var htmlBuilt = $('<span>delete</span>');
					var  htmlBuilt = $('<div/>').addClass(this.config.hiddenClass);


				}

				$.each(el, function(index, val) {
					if (typeof val === "string") {

						$('<div/>', {
							html: val
						}).addClass('Hotspot_' + index).appendTo(htmlBuilt);
					};
				});

				var div = $('<div/>', {
					html: htmlBuilt
				}).css({
					'top': el.y + 'px',
					'left': el.x + 'px'
				}).addClass(this.config.hotspotClass).appendTo(this.element).addClass('elem_id_'+i).attr('rel',i);
				if(this.config.mode=="admin") {
					$(htmlBuilt).append('<div class="remove_hotspot"></div>');
					$(htmlBuilt).append('<div class="edit_hotspot"></div>');
				}
				if (widget.config.interactivity === 'click') {
					div.on(widget.config.interactivity, function(event) {
						$(this).children('div').toggleClass(widget.config.hiddenClass);


					});
					htmlBuilt.css('display', 'block');
				} else {
					htmlBuilt.removeClass(this.config.hiddenClass);
				}

				if (this.config.interactivity === 'none') {
					htmlBuilt.css('display', 'block');
				}


				$('.remove_hotspot').on('click',function(){
					$(this).parent().parent().remove()
				})
				$('.edit_hotspot').on('click',function(){


					var title = $(this).parent().find('.Hotspot_Title').text();
					var message = $(this).parent().find('.Hotspot_Message').text();
					var elem_id = $(this).parent().parent().attr('rel');
					console.log(title)
					$('#popupPubl .hotspot_title').val(title);
					$('#popupPubl .hotspot_message').val(message);
					$('#popupPubl .elem_id').val(elem_id);

					$('#popupPubl').attr('rel',elem_id).attr('typeof','update');

					$('#popupPubl').modal('show');
				})


			};






		//var obj =[{ "x":288, "y":190, "Title":"Title 1","Message":"Image annotation 1" }]
		//console.log($obj.status);
		//var obj = JSON.parse(datae);

	};






	Hotspot.prototype.removeData = function() {
		if (localStorage.getItem(this.config.LS_Variable) === null) {
			return;
		};
		if (!confirm("Are you sure you wanna do everything?")) {
			return;
		};
		localStorage.removeItem(this.config.LS_Variable);
		this.broadcast = 'Removed successfully';
		this.element.trigger('afterRemove.hotspot');
	};

	Hotspot.prototype.syncToServer = function() {
		if (localStorage.getItem(this.config.LS_Variable) === null) {
			return;
		};





		if (this.config.ajax) {
			// AJAX call to sync to server
			var widget = this;
			//var dataObject = {
			//	data: {
			//		HotspotPlugin_data: localStorage.getItem(this.config.LS_Variable),
			//		HotspotPlugin_mode: "Store"
			//	}
			//};

			var oo ="";
			var ee = $('#theElement-a').find('.HotspotPlugin_Hotspot');
		var $dataObject=	$.each(ee, function(key,index) {




			var arr="";

				var parent = ($(index).attr('class'));

				var divv = ($(index).children([key]).children([key]));
				var Title = ($(divv[0]).text());
				var Message = ($(divv[1]).text());
				//console.log($('.'+parent).children().children('.Hotspot_Title').text())

				var top = (index.style.top)
				var left= (index.style.left);


				var x= Math.floor(left.slice(0, - 2));
				var y= Math.floor(top.slice(0, - 2));

				arr = JSON.stringify({x: x,y: y,Title:Title,Message:Message});

			oo += arr+",";








			});


			var result = oo.slice(0, - 1);



			//var conf = this.config.ajaxOptionsSave.data;
			//var end = $(conf).push(result)
			this.config.ajaxOptionsSave.data.result=result;
			this.config.ajaxOptionsSave.data.title= $('#content_title').val();
			this.config.ajaxOptionsSave.data.text= $('#content_text').val();
			this.config.ajaxOptionsSave.data.bg_img= $('.back_pic').val();


			//console.log(this.config.ajaxOptionsSave)
			var self = this;
			var ajaxSettings = $.extend({}, this.config.ajaxOptionsSave,self);

			$.ajax(ajaxSettings)
				.done(function() {

					//console.log(self.config.data);
					widget.broadcast = 'Sync was successful';
					widget.element.trigger('afterSyncToServer.hotspot');
				})
				.fail(function() {
					widget.broadcast = 'Error';
					widget.element.trigger('afterSyncToServer.hotspot');
				});
		} else {
			return;
		}
	};

	$.fn.hotspot = function (options) {
		new Hotspot(this, options);
		return this;
	}

}(jQuery));



$(document).ready(function() {

	$('#popupPublBTN').click(function () {
		var type_event = ($(this).attr('typeof'));
		if(type_event == 'update')
		{



			var title =	$('#popupPubl .hotspot_title').val();
			var message = $('#popupPubl .hotspot_message').val();
			var elem_id =$('#popupPubl .elem_id').attr('value');

		    $('.elem_id_'+elem_id).children().find('.Hotspot_Title').text(title);
			$('.elem_id_'+elem_id).children().find('.Hotspot_Message').text(message);
			//console.log(dd.html())


		}
		$('#popupPubl').modal('hide');
	})
})

