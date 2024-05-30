document.addEventListener("DOMContentLoaded", function() {
	const textarea = document.getElementById('safaritourregistrationform-about_business');
	const wordCount = document.getElementById('wordCount');
	const maxLength = 500; // Maximum allowed words

	function updateWordCount() {
		const wordsArray = textarea.value.trim().split(/\s+/);
		const wordsLength = wordsArray.filter(word => word).length; // Filter out any empty strings

		if (wordsLength > maxLength) {
			wordCount.textContent = `${maxLength}/${maxLength}`;
			wordCount.style.color = 'red'; // Set color to red if words exceed the limit
		} else {
			wordCount.textContent = `${wordsLength}/${maxLength}`;
			wordCount.style.color = ''; // Reset color if words are within the limit
		}
	}

	textarea.addEventListener('input', function(event) {
		updateWordCount();
	});

	updateWordCount(); // Call the function initially to ensure the count is displayed correctly

	// Display initial count
	wordCount.textContent = `0/${maxLength}`;
});

document.addEventListener("DOMContentLoaded", function() {
	const textarea = document.getElementById('birdingtourregistrationform-about_business');
	const wordCount = document.getElementById('wordCount');
	const maxLength = 500; // Maximum allowed words

	function updateWordCount() {
		const wordsArray = textarea.value.trim().split(/\s+/);
		const wordsLength = wordsArray.filter(word => word).length; // Filter out any empty strings

		if (wordsLength > maxLength) {
			wordCount.textContent = `${maxLength}/${maxLength}`;
			wordCount.style.color = 'red'; // Set color to red if words exceed the limit
		} else {
			wordCount.textContent = `${wordsLength}/${maxLength}`;
			wordCount.style.color = ''; // Reset color if words are within the limit
		}
	}

	textarea.addEventListener('input', function(event) {
		updateWordCount();
	});

	updateWordCount(); // Call the function initially to ensure the count is displayed correctly

	// Display initial count
	wordCount.textContent = `0/${maxLength}`;
});

document.addEventListener('DOMContentLoaded', function () {
	const forms = document.querySelectorAll('.form');
	const dots = document.querySelectorAll('.dot');
	const nextButton = document.querySelector('.next-btn');
	const submitButton = document.querySelector('.submit-btn');
	const termCondition = document.querySelector('.term-condition');

	let currentFormIndex = 0;

	function updateButtonVisibility() {
		if (currentFormIndex === forms.length - 1) {
			nextButton.style.display = 'none';
			submitButton.style.display = 'block';
			termCondition.classList.add('active');
		} else {
			nextButton.style.display = 'block';
			submitButton.style.display = 'none';
			termCondition.classList.remove('active');
		}
	}

	function validateForm1() {
		const form1 = forms[0];
		const requiredDivs = form1.querySelectorAll('.required');
		let isValid = true;

		requiredDivs.forEach(div => {
			const inputs = div.querySelectorAll('input, textarea, select');
			let divValid = false;

			inputs.forEach(input => {
				const feedback = input.nextElementSibling;

				if (input.classList.contains('is-valid')) {
					divValid = true;
					if (feedback && feedback.classList.contains('invalid-feedback')) {
						feedback.style.display = 'none';
					}
				} else {
					input.classList.add('is-invalid');
					input.setAttribute('aria-required', 'true');
					input.setAttribute('aria-invalid', 'true');
					if (feedback && feedback.classList.contains('invalid-feedback')) {
						const label = input.getAttribute('data-label'); // Get attribute label from data-label attribute
						feedback.textContent = `${label} cannot be blank`; // Update error message with label
						feedback.style.display = 'block';
					}
				}
			});

			if (!divValid) {
				isValid = false;
			}
		});

		return isValid;
	}

	nextButton.addEventListener('click', function (event) {
		event.preventDefault();
		// Validate form1
		if (currentFormIndex === 0 && validateForm1()) {
			// If form1 is valid, proceed to the next form
			if (currentFormIndex < forms.length - 1) {
				forms[currentFormIndex].classList.remove('active');
				dots[currentFormIndex].classList.remove('active');
				currentFormIndex++;
				forms[currentFormIndex].classList.add('active');
				dots[currentFormIndex].classList.add('active');
				updateButtonVisibility();
			}
		}
	});

	dots.forEach(dot => {
		dot.addEventListener('click', function () {
			const index = parseInt(this.getAttribute('data-index'));
			if (index <= currentFormIndex) {
				if (index === 0 || validateForm1()) {
					forms[currentFormIndex].classList.remove('active');
					dots[currentFormIndex].classList.remove('active');
					currentFormIndex = index;
					forms[currentFormIndex].classList.add('active');
					dots[currentFormIndex].classList.add('active');
					updateButtonVisibility();
				}
			}
		});
	});

	// Prevent form submission on Enter key press
	document.addEventListener('keydown', function (event) {
		if (event.key === 'Enter' && currentFormIndex < forms.length - 1) {
			event.preventDefault();
		}
	});

	// Validate form1 when any input changes
	forms[0].addEventListener('input', function () {
		validateForm1();
	});
});