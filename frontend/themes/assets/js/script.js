// gallery-carousel
if ($('.safari-carousel').length) {
    $('.safari-carousel').owlCarousel({
        loop:true,
        margin:0,
        nav:false,
        smartSpeed: 500,
        autoplay: 300,
        navText: [ '<span class="fal fa-angle-left"></span>', '<span class="fal fa-angle-right"></span>' ],
        responsive:{
            0:{
                items:1
            },
            480:{
                items:2
            },
            600:{
                items:2
            },
            800:{
                items:3
            },			
            1200:{
                items:4
            },
            1400:{
                items:5
            }

        }
    });    		
}
$('.opratios-slider ').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
    dots:false,
    autoplay:true,
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
           
        },
        600:{
            items:3,
          
        },
        1000:{
            items:6,

        }
    }
})
$('.slider_safariimg  ').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    dots:true,
    autoplay:true,
    responsiveClass:true,
    smartSpeed :900,
     navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
    responsive:{
        0:{
            items:1,
           
        },
        600:{
            items:1,
          
        },
        900:{
            items:1,

        },
        1024:{
            items:1,

        }
    }
})
$('.slider_resorts ').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    dots:true,
    autoplay:false,
    responsiveClass:true,
    smartSpeed :900,
     navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
    responsive:{
        0:{
            items:1,
           
        },
        600:{
            items:1,
          
        },
        900:{
            items:2,

        },
        1024:{
            items:1,

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
        const words = textarea.value.trim().split(/\s+/).length;
        wordCount.textContent = `${words}/${maxLength}`;

        if (words > maxLength) {
            wordCount.style.color = 'red'; // Set color to red if words exceed the limit
            // Trim the textarea value to the maximum length
            textarea.value = trimTextToWordCount(textarea.value, maxLength);
        } else {
            wordCount.style.color = ''; // Reset color if words are within the limit
        }
    }

    function trimTextToWordCount(text, maxWords) {
        const wordsArray = text.trim().split(/\s+/);
        // Join only the first 'maxWords' words
        return wordsArray.slice(0, maxWords).join(' ');
    }

    textarea.addEventListener('input', function(event) {
        const words = event.target.value.trim().split(/\s+/).length;
        if (words > maxLength) {
            // Prevent further input if word count exceeds the limit
            event.preventDefault();
        } else {
            updateWordCount();
        }
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

document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-items');
    const contents = document.querySelectorAll('.tab-content_tour');

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


let navbar = document.querySelector('.header_wrapper');

window.addEventListener('scroll', function(e){
    let postition = window.scrollY;
 if(postition > 80){

    navbar.classList.add('fixed_top')
 }else{

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


  document.addEventListener('DOMContentLoaded', function() {
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

    function validateForm(index) {
        const form = forms[index];
        const requiredDivs = form.querySelectorAll('.required');
        let isValid = true;

        requiredDivs.forEach(div => {
            const inputs = div.querySelectorAll('input, select, textarea');
            let isFieldValid = false;

            inputs.forEach(input => {
                if (input.classList.contains('is-invalid')) {
                    isValid = false;
                } else if (input.classList.contains('is-valid')) {
                    isFieldValid = true;
                }
            });

            if (!isFieldValid) {
                isValid = false;
            }
        });

        return isValid;
    }

    nextButton.addEventListener('click', function(event) {
        event.preventDefault();
        // Validate the current form
        if (validateForm(currentFormIndex)) {
            // If the current form is valid, proceed to the next form
            if (currentFormIndex < forms.length - 1) {
                forms[currentFormIndex].classList.remove('active');
                dots[currentFormIndex].classList.remove('active');
                currentFormIndex++;
                forms[currentFormIndex].classList.add('active');
                dots[currentFormIndex].classList.add('active');
                updateButtonVisibility();
            }
        } else {
            // alert("Please fill in all required fields correctly.");
        }
    });

    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            if (index !== currentFormIndex) {
                if (index < currentFormIndex || validateForm(currentFormIndex)) {
                    forms[currentFormIndex].classList.remove('active');
                    dots[currentFormIndex].classList.remove('active');
                    currentFormIndex = index;
                    forms[currentFormIndex].classList.add('active');
                    dots[currentFormIndex].classList.add('active');
                    updateButtonVisibility();
                } else {
                    // alert("Please fill in all required fields correctly.");
                }
            }
        });
    });

    // Prevent form submission on Enter key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter' && currentFormIndex < forms.length - 1) {
            event.preventDefault();
        }
    });

    // Validate form on input change
    forms.forEach(form => {
        form.addEventListener('input', function() {
            validateForm(currentFormIndex);
        });
    });
});








  const fileUpload = document.getElementById('fileupload');
  const uploadText = document.getElementById('uploadText');
  const browslogow3 = document.getElementById('browslogow3');
  
  fileUpload.addEventListener('change', function() {
    if (fileUpload.files.length > 0) {
      const file = fileUpload.files[0];
      
      const img = document.createElement('img');
      img.style.maxWidth = '100%';
      img.style.maxHeight = '100%';
      
      const reader = new FileReader();
      reader.onload = function(e) {
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


  

