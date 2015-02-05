/* ------------------------------------------------------------ *\
|* ------------------------------------------------------------ *|
|* Some JS to help with our search
|* ------------------------------------------------------------ *|
\* ------------------------------------------------------------ */
(function(window){

	// get vars
	var searchEl = document.querySelector("#input");
	var labelEl = document.querySelector("#search-label");

	// register clicks and toggle classes
	labelEl.addEventListener("click",function(e){
		if (classie.has(searchEl,"focus")) {

			classie.remove(searchEl,"focus");
			classie.remove(labelEl,"active");
		} else {
			//$('.search').addClass('loader');
			//setTimeout(function() {
			//	$('.search').removeClass('loader');
			//}, 2000);

			classie.add(searchEl,"focus");
			classie.add(labelEl,"active");
		}

	});

	// register clicks outisde search box, and toggle correct classes
	document.addEventListener("click",function(e){
		var clickedID = e.target.id;
		if (clickedID != "search-terms" && clickedID != "search-label-target") {
			if (classie.has(searchEl,"focus")) {
				//$('.search').removeClass('loader');
				classie.remove(searchEl,"focus");
				classie.remove(labelEl,"active");
			}
		}

	});
}(window));