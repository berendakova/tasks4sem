let slideIndex = 0;
let slides = document.querySelectorAll('.custome--comments--item');

function slider(element_class){
	let animation;
	let startIndex = slideIndex;
	let parent = document.querySelectorAll('.custome--comments')[0];

	if (element_class == 'arrow--right') {
		animation = 'animated--to--right';

		for (let i = 0; i < slides.length; i++) {
			if (i != checkPos(startIndex - 1)) {
				slides[i].classList.remove('animated--to--left');
			}
		}

		slides[slideIndex].style.zIndex = 11;
		slides[slideIndex].classList.add(animation);
		slides[slideIndex].classList.remove('active');

		slideIndex = checkPos(slideIndex + 1);

		slides[slideIndex].style.zIndex = 10;
		slides[slideIndex].classList.add('active');
		slides[checkPos(slideIndex + 1)].style.zIndex = 9;

		setTimeout(animationDurationRight,700);
		setTimeout(animationRemover,2000);

		slideIndex = checkPos(slideIndex);
	} else {
		animation = 'animated--to--left';

		for (let i = 0; i < slides.length; i++) {
			if (i != checkPos(startIndex - 1)) {
				slides[i].classList.remove('animated--to--right');
			}
		}

		slides[slideIndex].style.zIndex = 10;
		slides[slideIndex].classList.remove('active');
		slideIndex = checkPos(slideIndex - 1);

		function test() {
			slides[slideIndex].style.zIndex = 11;
		}

		setTimeout(test,1300);

		slides[slideIndex].classList.add('active');
		slides[slideIndex].classList.add(animation);

		for (let i = 0; i < slides.length; i++) {
			if (i != checkPos(startIndex - 1)) {
				slides[i].classList.remove(animation);
				slides[i].classList.remove('active');
			}
		}

		setTimeout(animationDurationLeft,2000);
		setTimeout(animationRemover,2000);
	}

	function checkPos(index) {
		if (index >= 3) {
			index = 0;
		}

		if (index <= -1) {
			index = 2;
		}

		return index;
	}

	function animationDurationRight() {
		slides[checkPos(startIndex)].style.zIndex = 8;
	}

	function animationDurationLeft(index) {
		for (let i = 0; i < slides.length; i++) {
			if (true) {
				slides[checkPos(startIndex)].style.zIndex = 2;
			}
		}
	}

	function animationRemover(){
		for (let i = 0; i < slides.length; i++) {
			slides[i].classList.remove(animation);
		}
	}
}

 window.onload = function() {
 	let element = document.querySelectorAll('.custome--comments--item')[0];
 	let illusion1 = document.querySelectorAll('.background--illusion1')[0];
 	let illusion2 = document.querySelectorAll('.background--illusion2')[0];

 	console.log(element);

 	illusion1.style.top = (element.offsetHeight - illusion1.offsetHeight)/2 + 'px';
 	illusion2.style.top = (element.offsetHeight - illusion2.offsetHeight)/2 + 'px';

 	illusion1.style.width = element.offsetWidth + 30 + 'px';
 	illusion2.style.width = element.offsetWidth + 60 + 'px';
 }