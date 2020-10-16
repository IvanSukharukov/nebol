/* ===Поиск=== */
$(function(){
	$('#autocomplete_header').autocomplete({//чтобы поиск был в двух местах, то нужна форма с другим id и в этой строчке д.б. такой же id
		source: path + 'search/',
		minLength: 2, // с какого символа начинать поиск
		select: function (event, ui) {
			window.location = path + 'search/?search=' + encodeURIComponent(ui.item.value);
		}
	});

	$('#autocomplete_catalog').autocomplete({//чтобы поиск был в двух местах, то нужна форма с другим id и в этой строчке д.б. такой же id
		source: path + 'search/',
		minLength: 2, // с какого символа начинать поиск
		select: function (event, ui) {
			window.location = path + 'search/?search=' + encodeURIComponent(ui.item.value);
		}
	});
});

/* ===Клавиша ENTER при пересчете=== */
$(".kolvo").keypress(function (e) {
	if (e.which == 13) {
		return false;
	}
});

/* ===Пересчет товаров в корзине=== */
$(".kolvo").each(function () {
	var qty_start = $(this).val(); // кол-во до изменения

	$(this).change(function () {
		var qty = $(this).val(); // кол-во перед пересчетом
		var res = confirm("Пересчитать корзину?");
		if (res) {
			var id = $(this).attr("id");
			id = id.substr(2);
			if (!parseInt(qty)) {
				qty = qty_start;
			}
			// передаем параметры
			window.location = "cart/?qty=" + qty + "&id=" + id;
		} else {
			// если отменен пересчет корзины
			$(this).val(qty_start);
		}
	});
});


/* ===увеличение/уменьшение товаров при добавлении в корзину/корзине=== */
$(document).ready(function () {
	$('.minus').click(function () {
		var $input = $(this).parent().find('input');
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		return false;
	});
	$('.plus').click(function () {
		var $input = $(this).parent().find('input');
		$input.val(parseInt($input.val()) + 1);
		$input.change();
		return false;
	});
});

/* ===маска для ввода номера телефона=== */
var inputsTel = document.querySelectorAll('input[type="tel"]');
Inputmask({
	"mask": "+7(999)  999-99-99",
	showMaskOnHover: false,
}).mask(inputsTel);


/* ===слайдер=== */
$(document).ready(function () {
	$('.slider').slick({
		autoplay: true,
		autoplaySpeed: 1700,
		speed: 1100,
		dots: true,
		// cssEase: 'linear',
		// cssEase: 'ease',
		useTransform: true,
		fade: true//затухание

	});
});

/* ===бургер-меню=== */
const menuToggle = document.querySelector('#menu-togle');
const mobileNavContainer = document.querySelector('#mobile-nav');

menuToggle.onclick = function () {
	menuToggle.classList.toggle('menu-icon-active');
	mobileNavContainer.classList.toggle('mobile-nav--active');
}


/* ===запретить отправку при заказе формы нажитием Enter=== */
$(document).ready(function () {
	$("#no-enter, #order_phone").keydown(function (event) {
		if (event.keyCode == 13) {
			event.preventDefault();
			return false;
		}
	});
});

/* ===выбор аптеки=== */
$(document).ready(function () {
	$("#branch").change(function () {
		var branch = this.value;
		$.cookie('branch', branch, { expires: 7, path: '/' });
		window.location = location.href;
	});
});