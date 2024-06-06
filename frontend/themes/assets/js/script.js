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
$('.opratios-slider ').owlCarousel({
    loop: true,
    margin: 10,
    nav: false,
    dots: false,
    autoplay: true,
    responsiveClass: true,
    responsive: {
        0: {
            items: 2,

        },
        600: {
            items: 3,

        },
        1000: {
            items: 6,

        }
    }
})
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
                    items: 1,
                },
                600: {
                    items: 1,
                },
                900: {
                    items: 1,
                },
                1024: {
                    items: 1,
                }
            }
        });
    } else {
        // Show the single image without any slider functionality
        $slider.addClass('single-image');
    }
});
$('.slider_resorts ').owlCarousel({
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
            items: 1,

        },
        600: {
            items: 1,

        },
        900: {
            items: 2,

        },
        1024: {
            items: 1,

        }
    }
})

document.addEventListener('DOMContentLoaded', function () {
    // Get the toggle button and the advanced search box
    const toggleButton = document.getElementById('toggleButton');
    const advanceSearchBox = document.getElementById('advanceSearchBox');

    // Add click event listener to the toggle button
    toggleButton.addEventListener('click', function () {
        // Toggle the visibility of the advanced search box
        if (advanceSearchBox.style.display === 'none' || advanceSearchBox.style.display === '') {
            advanceSearchBox.style.display = 'block';
        } else {
            advanceSearchBox.style.display = 'none';
        }
    });
});

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

document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-items');
    const contents = document.querySelectorAll('.tab-content_tour');

    tabs.forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();

            // Remove active class from all tabs and contents
            tabs.forEach(item => item.classList.remove('active_safri'));
            contents.forEach(content => content.classList.remove('active'));

            // Add active class to clicked tab and corresponding content
            tab.classList.add('active_safri');
            document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
        });
    });
});

// document.addEventListener("DOMContentLoaded", function() {
//     const toggleViewBtn = document.getElementById('toggleViewBtn');
//     const toggleViewIcon = document.querySelector('#toggleViewBtn i');
//     const gridView = document.querySelector('.gridview');
//     const listBox = document.querySelector('.listviewBox');
//     gridView.style.display = 'none';

//     toggleViewBtn.addEventListener('click', function(event) {
//         event.preventDefault();
//         if (toggleViewIcon.classList.contains('fa-th-large')) {
//             toggleViewIcon.classList.remove('fa-th-large');
//             toggleViewIcon.classList.add('fa-list');
//             gridView.style.display = 'none';
//             listBox.style.display = 'block';
//         } else {
//             toggleViewIcon.classList.remove('fa-list');
//             toggleViewIcon.classList.add('fa-th-large');
//             gridView.style.display = 'block';
//             listBox.style.display = 'none';
//         }
//     });
// });
const $arrow = $("#arrow");
const $section02 = $("#section02");
const $section01 = $("#section01");

$arrow.click(function () {
    $("html, body").animate({ scrollTop: $section02.offset().top }, "smooth");
});

$(window).scroll(function () {
    const section02Top = $section02.offset().top - $(window).scrollTop();
    const windowHeight = $(window).height();
    const section01Bottom = $section01.offset().top + $section01.outerHeight() - $(window).scrollTop();

    if (section02Top <= windowHeight / 2) {
        $arrow.addClass("hidden");
    } else if (section01Bottom > windowHeight / 2) {
        $arrow.removeClass("hidden");
    }
});


let navbar = document.querySelector('.header_wrapper');

window.addEventListener('scroll', function (e) {
    let postition = window.scrollY;
    if (postition > 80) {

        navbar.classList.add('fixed_top')
    } else {

        navbar.classList.remove('fixed_top')
    }

})
// $(document).ready(function(){

//     var tabWrapper = $('#tab-block'),
//         tabMnu = tabWrapper.find('.tab-mnu  li'),
//         tabContent = tabWrapper.find('.tab-cont > .tab-pane');

//     tabContent.not(':first-child').hide();

//     tabMnu.each(function(i){
//       $(this).attr('data-tab','tab'+i);
//     });
//     tabContent.each(function(i){
//       $(this).attr('data-tab','tab'+i);
//     });

//     tabMnu.click(function(){
//       var tabData = $(this).data('tab');
//       tabWrapper.find(tabContent).hide();
//       tabWrapper.find(tabContent).filter('[data-tab='+tabData+']').show(); 
//     });

//     $('.tab-mnu > li').click(function(){
//       var before = $('.tab-mnu li.active');
//       before.removeClass('active');
//       $(this).addClass('active');
//      });

//   });
// document.addEventListener('DOMContentLoaded', function() {
//     const forms = document.querySelectorAll('.form');
//     const dots = document.querySelectorAll('.dot');
//     const nextButton = document.querySelector('.next-btn');
//     const termCondition = document.querySelector('.term-condition');

//     let currentFormIndex = 0;

//     nextButton.addEventListener('click', function(event) {
//       event.preventDefault();
//       forms[currentFormIndex].classList.remove('active');
//       dots[currentFormIndex].classList.remove('active');
//       currentFormIndex++;
//       if (currentFormIndex < forms.length) {
//         forms[currentFormIndex].classList.add('active');
//         dots[currentFormIndex].classList.add('active');
//         if (currentFormIndex === forms.length - 1) {
//           nextButton.textContent = 'Submit';
//           nextButton.classList.add('submit-button');
//           termCondition.classList.add('active');
//         }
//       } else {
//         // Handle form submission here
//         alert('Form submitted successfully!');
//         // You can also submit the form to a server using AJAX or similar
//       }
//     });

//   });

// Get the textarea element
const textarea = document.getElementById('about_business');


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




