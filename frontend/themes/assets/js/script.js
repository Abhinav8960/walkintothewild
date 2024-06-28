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
        1000: {
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

    const textarea1 = document.getElementById('safaritourregistrationform-about_business');
    const wordCount1 = document.getElementById('wordCount');
    const maxLength = 500; // Maximum allowed words

    function updateWordCount(textarea, wordCount) {
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

    if (textarea1 && wordCount1) {
        textarea1.addEventListener('input', function() {
            updateWordCount(textarea1, wordCount1);
        });

        updateWordCount(textarea1, wordCount1); // Call the function initially to ensure the count is displayed correctly
        wordCount1.textContent = `0/${maxLength}`;
    }

    const textarea2 = document.getElementById('birdingtourregistrationform-about_business');
    const wordCount2 = document.getElementById('wordCount');

    if (textarea2 && wordCount2) {
        textarea2.addEventListener('input', function() {
            updateWordCount(textarea2, wordCount2);
        });

        updateWordCount(textarea2, wordCount2); // Call the function initially to ensure the count is displayed correctly
        wordCount2.textContent = `0/${maxLength}`;
    }

    function increment(id) {
        let input = document.getElementById(id);
        if (input) {
            input.value = parseInt(input.value) + 1;
        }
    }

    function decrement(id) {
        let input = document.getElementById(id);
        if (input && parseInt(input.value) > 0) {
            input.value = parseInt(input.value) - 1;
        }
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

    const $arrow = $("#arrow");
    const $section02 = $("#section02");
    const $section01 = $("#section01");

    if ($arrow && $section02 && $section01) {
        $arrow.click(function() {
            $("html, body").animate({ scrollTop: $section02.offset().top }, "smooth");
        });

        $(window).scroll(function() {
            const section02Top = $section02.offset().top - $(window).scrollTop();
            const windowHeight = $(window).height();
            const section01Bottom = $section01.offset().top + $section01.outerHeight() - $(window).scrollTop();

            if (section02Top <= windowHeight / 2) {
                $arrow.addClass("hidden");
            } else if (section01Bottom > windowHeight / 2) {
                $arrow.removeClass("hidden");
            }
        });
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

    if (forms.length && dots.length && nextButton && submitButton && termCondition) {
        let currentStep = 0;

        function showStep(step) {
            forms.forEach((form, index) => {
                form.classList.toggle('active', index === step);
            });

            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === step);
            });

            nextButton.style.display = step === forms.length - 1 ? 'none' : 'block';
            submitButton.style.display = step === forms.length - 1 ? 'block' : 'none';
            termCondition.style.display = step === forms.length - 1 ? 'block' : 'none';
        }

        nextButton.addEventListener('click', function() {
            if (currentStep < forms.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        submitButton.addEventListener('click', function(event) {
            event.preventDefault();
            if (validateForm()) {
                document.querySelector('.multistep-form').submit();
            }
        });

        function validateForm() {
            let isValid = true;
            const inputs = forms[currentStep].querySelectorAll('input[required], textarea[required]');
            inputs.forEach(input => {
                if (!input.checkValidity()) {
                    isValid = false;
                }
            });
            return isValid;
        }

        showStep(currentStep);
    }
});
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
