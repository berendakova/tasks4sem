function navToggle(element_class)  {
	const ITEM_OPEN = 'nav--toggle--open';
	const nav = document.getElementsByClassName('head--nav--wrapper')[0];
	const button = document.getElementsByClassName(element_class)[0];
	const line = document.getElementsByClassName('head--line')[0];

	if (button.classList.contains(ITEM_OPEN)) {
		button.classList.remove(ITEM_OPEN);
		nav.classList.remove(ITEM_OPEN);
		line.classList.remove(ITEM_OPEN);
	} else {
		button.classList.add(ITEM_OPEN);
		nav.classList.add(ITEM_OPEN);
		line.classList.add(ITEM_OPEN);
	}
}