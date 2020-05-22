let slideIndex = 0;

function slider2(element_class){
	let slides = document.querySelectorAll('.custome--comments--item');

	slides[slideIndex].style.zIndex = 10;

	for (let i = 0; i < slides.length; i++) {
		slides[i].style.zIndex = 10;
	}

	for (let i = 0; i < slides.length; i++) {
		slides[i].classList.remove('active');
	}

	slides[slideIndex].classList.add('animated');

	if (element_class == 'arrow--right') {
		if (slideIndex == 2) {
			slideIndex = -1
		}
		slideIndex +=1;
	} else {
		if (slideIndex == 0) {
			slideIndex = 3
		}
		slideIndex -=1;
	}

	
	slides[slideIndex].classList.add('active');

	function clear() {
		for (let i = 0; i < slides.length; i++) {
			slides[i].classList.remove('animated');
		}
	}

	setTimeout(clear,1000);
}