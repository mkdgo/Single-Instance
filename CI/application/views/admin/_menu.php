<script>
<!--
$(function(){
	var menu_selected = '{_menu_selected}';
	var link_el = $('a[href="'+menu_selected+'"]');
	//jquery UI accordion
	$('div.menu-nav').accordion({
		heightStyle: "content",
		active: link_el.parent().parent().parent().index('div.acc_content')
	});	
});
//->
</script>


<div class="menu-nav">
    <h3 class="nav-header">System menu</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="/admin"><i class="icon-home"></i>Home</a></li>
			<li><a target="_blank" href="/"><i class="icon-play-circle"></i>Frontend</a></li>
			<li><a href="/admin/login/logout"><i class="icon-off"></i>Exit</a></li>
		</ul>
	</div>


	<!-- Users menu -->
	<h3 class="nav-header">Users</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="/admin/users/"><i class="icon-chevron-right"></i>User profiles</a>
				<ul class="sub-menu">
					<li><a href="/admin/user_types_permissions/"><i class="icon-minus"></i>User types permissions</a></li>
				</ul>
			</li>
			<li><a href="#"><i class="icon-chevron-right"></i>User photos settings</a></li>
			<li><a href="/admin/friend_profilies_photos"><i class="icon-chevron-right"></i>Friend profiles photos</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Hot profile photos</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Friend photo albums</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Hot photo albums</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Movie settings</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Last subscribers</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Banca CXC</a></li>
		</ul>
	</div>


	<!-- Rooms menu -->
	<h3 class="nav-header">Rooms</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="/admin/chat_groups/"><i class="icon-chevron-right"></i>Chat groups</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Stanze meeting</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Room games e tema</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Stanze multi-meeting</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Stanze private</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Poker-Lumanche</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Palco</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Moulin rouge-liveshow</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Stanze multichat</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Torneo billiardo</a></li>
		</ul>
	</div>


	<!-- Security menu -->
	<h3 class="nav-header">Security</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="#"><i class="icon-chevron-right"></i>Moderatori CXC</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Blocco utenti su NICK</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Blocco utenti su IP</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Testo coda email</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Filtro messaggi</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Grab Address</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Livello verifica email</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Blocco mittenti SMS</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione MMS</a></li>
		</ul>
	</div>


	<!-- Communication menu -->
	<h3 class="nav-header">Communication</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="#"><i class="icon-chevron-right"></i>Comunicazioni staff</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione richieste</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Forums cancellati</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione proclami</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione sondaggi</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione locali</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione video Youtube</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Livello di soddisfazione</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Newsletter</a></li>
		</ul>
	</div>


	<!-- Services menu -->
	<h3 class="nav-header">Services</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="#"><i class="icon-chevron-right"></i>Segnalazioni premium</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Stanze private omaggio</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Premium in scadenza</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Inoltro messaggi</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Messaggi divertenti</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione SMS</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Corregi thumb</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Crop thumb foto 1</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Camcxcard</a></li>
		</ul>
	</div>


	<!-- Misc menu -->
	<h3 class="nav-header">Misc</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="#"><i class="icon-chevron-right"></i>Affilati CXC</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Affilati meeting</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Baner auguri</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Pokerine</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Promoter</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Entrate/Uscite crediti</a></li>
			<li><a href="#"><i class="icon-chevron-right"></i>Gestione Annunci</a></li>
		</ul>
	</div>
	<!-- Nomencaltures menu -->
	<h3 class="nav-header">Nomenclatures</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="/admin/nomenclatures/nomenclature_list/user_types/"><i class="icon-chevron-right"></i>User types</a></li>
			<li><a href="/admin/nomenclatures/nomenclature_list/profile_types/"><i class="icon-chevron-right"></i>Profile types</a></li>
			<li><a href="/admin/nomenclatures/nomenclature_list/sex/"><i class="icon-chevron-right"></i>Sex</a></li>
			<li><a href="/admin/nomenclatures/nomenclature_list/cities/"><i class="icon-chevron-right"></i>Cities</a></li>
			<li><a href="/admin/nomenclatures/nomenclature_list/regions/"><i class="icon-chevron-right"></i>Regions</a></li>
			<li><a href="/admin/nomenclatures/nomenclature_list/states/"><i class="icon-chevron-right"></i>States</a></li>
			<li><a href="/admin/nomenclatures/nomenclature_list/zodiacal_sign/"><i class="icon-chevron-right"></i>Zodiacal sign</a></li>
			<li><a href="/admin/nomenclatures/nomenclature_list/permissions/"><i class="icon-chevron-right"></i>User permission</a></li>
		</ul>
	</div>
        <!-- Users menu -->
	<h3 class="nav-header">Static Pages</h3>
	<div class="acc_content">
		<ul class="nav nav-list">
			<li><a href="/admin/pages/"><i class="icon-chevron-right"></i>Pages</a></li>


		</ul>
	</div>
<!--
	<h3 class="nav-header">Nomenclatures</h3><div><ul class="nav nav-list">
			<li>
				<a href="/admin/page_categories">
					<i class="icon-chevron-right"></i>
					Page categories
				</a>
				</h3>
				<div>
		</ul> -->


</div>