// gallery-carousel
if ($('.safari-carousel').length) {
    $('.safari-carousel').owlCarousel({
        loop: true,
        margin: 0,
        nav: false,
        smartSpeed: 500,
        autoplay: 300,
        navText: ['<span class="fal fa-angle-left"></span>', '<span class="fal fa-angle-right"></span>'],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            600: {
                items: 2
            },
            800: {
                items: 3
            },
            1200: {
                items: 4
            },
            1400: {
                items: 5
            }
        }
    });
}

// if ($('.opratios-slider').length) {
//     $('.opratios-slider').owlCarousel({
//         loop: true,
//         margin: 10,
//         nav: false,
//         dots: false,
//         autoplay: true,
//         responsiveClass: true,
//         responsive: {
//             0: {
//                 items: 2
//             },
//             600: {
//                 items: 3
//             },
//             1000: {
//                 items: 6
//             }
//         }
//     });
// }

var owl = $(".opratios-slider");
var itemCount = owl.children().length;
owl.owlCarousel({
    items: itemCount >= 6 ? 6 : itemCount,
    loop: false,
    margin: 10,
    dots: false,
    smartSpeed: 900,
    autoplay: true,
    nav:false,
    responsive: {
        0: {
            items: itemCount >= 2 ? 2 : itemCount
        },
        1000: {
            items: itemCount >= 3 ? 3 : itemCount
        },
        1400: {
            items: itemCount >= 6 ? 6 : itemCount
        }
    }
});

$(document).ready(function() {
    var $slider = $('.slider_safariimg');
    var itemCount = $slider.children().length;

    if (itemCount > 1) {
        $slider.owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: true,
            autoplay: true,
            responsiveClass: true,
            smartSpeed: 900,
            navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                900: {
                    items: 1
                },
                1024: {
                    items: 1
                }
            }
        });
    } else {
        $slider.addClass('single-image');
    }
});

if ($('.slider_resorts').length) {
    $('.slider_resorts').owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        dots: true,
        autoplay: false,
        responsiveClass: true,
        smartSpeed: 900,
        navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            900: {
                items: 2
            },
            1024: {
                items: 1
            }
        }
    });
}
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

let flashMessageTimeout;
window.addEventListener('scroll', function() {
    const flashMessage = document.getElementById('flashMessage');
    flashMessage.style.display = 'block';
    
    if (flashMessageTimeout) {
        clearTimeout(flashMessageTimeout);
    }
    flashMessageTimeout = setTimeout(function() {
        flashMessage.style.display = 'none';
    }, 2000);
});
document.addEventListener('DOMContentLoaded', function() {
    let profile = document.querySelector('.profile');
    let menu = document.querySelector('.menuprofile');

    if (profile && menu) {
        profile.onclick = function(event) {
            menu.classList.toggle('active');
            event.stopPropagation();
        }

        document.addEventListener('click', function(event) {
            if (!profile.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    }

    const toggleButton = document.getElementById('toggleButton');
    const toggleButtonMobile = document.getElementById('toggleButtonMobile');
    const advanceSearchBox = document.getElementById('advanceSearchBox');

    if (toggleButton && advanceSearchBox) {
        toggleButton.addEventListener('click', function() {
            advanceSearchBox.style.display = (advanceSearchBox.style.display === 'none' || advanceSearchBox.style.display === '') ? 'block' : 'none';
        });
    }

    if (toggleButtonMobile && advanceSearchBox) {
        toggleButtonMobile.addEventListener('click', function() {
            advanceSearchBox.style.display = (advanceSearchBox.style.display === 'none' || advanceSearchBox.style.display === '') ? 'block' : 'none';
        });
    }

    

    const tabs = document.querySelectorAll('.tab-items');
    const contents = document.querySelectorAll('.tab-content_tour');

    if (tabs && contents) {
        tabs.forEach(tab => {
            tab.addEventListener('click', function(event) {
                event.preventDefault();

                // Remove active class from all tabs and contents
                tabs.forEach(item => item.classList.remove('active_safri'));
                contents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab and corresponding content
                tab.classList.add('active_safri');
                document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
            });
        });
    }

    const mobileSearchDiv = document.getElementById('mobileSearchDiv');
    const targetDiv = document.getElementById('targetDiv');
    const formSelect = document.querySelector('.form-select');

    if (mobileSearchDiv && targetDiv) {
        mobileSearchDiv.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the default behavior
            targetDiv.style.display = targetDiv.style.display === 'none' ? 'block' : 'block';
        });

        if (formSelect) {
            formSelect.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }
    }

    

    let navbar = document.querySelector('.header_wrapper');

    if (navbar) {
        window.addEventListener('scroll', function() {
            let position = window.scrollY;
            if (position > 80) {
                navbar.classList.add('fixed_top');
            } else {
                navbar.classList.remove('fixed_top');
            }
        });
    }

    const textarea = document.getElementById('about_business');

  
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


const fileUpload = document.getElementById('fileupload');
const uploadText = document.getElementById('uploadText');
const browslogow3 = document.getElementById('browslogow3');

fileUpload.addEventListener('change', function () {
    if (fileUpload.files.length > 0) {
        const file = fileUpload.files[0];

        const img = document.createElement('img');
        img.style.maxWidth = '100%';
        img.style.maxHeight = '100%';

        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);

        // Clear any existing images before appending the new one
        const existingImg = browslogow3.querySelector('img');
        if (existingImg) {
            browslogow3.removeChild(existingImg);
        }

        browslogow3.appendChild(img);
        // Hide the uploadText when an image is uploaded
        uploadText.style.display = 'none';
    }
});


document.addEventListener("DOMContentLoaded", function() {
    const textarea = document.getElementById('safaritourregistrationform-about_business');
    const wordCount = document.getElementById('wordCount');
    const maxLength = 120; // Maximum allowed words

    function updateWordCount() {
        // Regular expression to match alphanumeric sequences and common symbols in words
        const wordsArray = textarea.value.match(/[\w'-]+/g) || []; 

        const wordsLength = wordsArray.length;
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
    const maxLength = 120; // Maximum allowed words

    function updateWordCount() {
        // Regular expression to match alphanumeric sequences and common symbols in words
        const wordsArray = textarea.value.match(/[\w'-]+/g) || []; 

        const wordsLength = wordsArray.length;
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



function increment(id) {
    let input = document.getElementById(id);
    input.value = parseInt(input.value) + 1;
}

function decrement(id) {
    let input = document.getElementById(id);
    if (parseInt(input.value) > 0) {
        input.value = parseInt(input.value) - 1;
    }
}
// (function($){
//     $('document').ready(function() {
//       $('.sidebar,.main').stick_in_parent();
//     });
//   })(jQuery);
// window.onscroll = function (e) {  

//     var constantY = 100;
//       var scrollTop = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop;
//     var sidebars = document.getElementsByClassName("sidebar");
//     if (scrollTop > constantY) {
//     sidebars[0].classList.add("sticky-panel");
    
//     }
//     else {
//     sidebars[0].classList.remove("sticky-panel");
//     }
    
//       //console.log(window.pageYOffset || (document.documentElement || document.body.parentNode ||document.body).scrollTop);
//     }
