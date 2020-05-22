function scrollToElement(element_class) {
	const el = document.getElementsByClassName(element_class)[0];
	const head = document.getElementsByClassName('head')[0];

	const ITEM_OPEN = 'nav--toggle--open';
	const nav = document.getElementsByClassName('head--nav--wrapper')[0];

	if (nav.classList.contains(ITEM_OPEN)) {
		navToggle('nav--toggle');
	}

	window.scroll({top: el.offsetTop - head.offsetHeight, behavior: 'smooth'});
}