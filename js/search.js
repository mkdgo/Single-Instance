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
			$('#input input').animate({ width: '0px',left: '-20px'}, function(){

			});
		} else {


			$('#input input').animate({ left: 0, width: '100%'},function(){
				classie.add(searchEl,"focus");
				classie.add(labelEl,"active");
			});



		}

	});

	// register clicks outisde search box, and toggle correct classes
	document.addEventListener("click",function(e){
		var clickedID = e.target.id;
		if (clickedID != "search-terms" && clickedID != "search-label-target") {
			if (classie.has(searchEl,"focus")) {

				classie.remove(searchEl,"focus");
				classie.remove(labelEl,"active");
				$('#input input').animate({ width: '0px',left: '-20px'}, function(){

				});



			}
		}

	});
}(window));