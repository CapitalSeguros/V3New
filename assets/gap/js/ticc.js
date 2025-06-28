/*.....::::: DOCUMENTO Js :::::.....*/
var mainAltura = $('.main-page').height();
$('.menu-sidebar').css('minHeight', mainAltura);
var menuSidebar = $('.menu-sidebar');
$('#submenu-secciones').on('click', function (e) {
	e.preventDefault();
	e.stopPropagation();
	$(this).toggleClass('flipped');
	$('.main-page').toggleClass('main-page-close main-page-open');
	menuSidebar.toggleClass('menu-sidebar-close menu-sidebar-open');;
})
