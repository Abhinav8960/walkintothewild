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
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.form');
    const dots = document.querySelectorAll('.dot');
    const nextButton = document.querySelector('.next-btn');
    const termCondition = document.querySelector('.term-condition');

    let currentFormIndex = 0;

    nextButton.addEventListener('click', function(event) {
      event.preventDefault();
      forms[currentFormIndex].classList.remove('active');
      dots[currentFormIndex].classList.remove('active');
      currentFormIndex++;
      if (currentFormIndex < forms.length) {
        forms[currentFormIndex].classList.add('active');
        dots[currentFormIndex].classList.add('active');
        if (currentFormIndex === forms.length - 1) {
          nextButton.textContent = 'Submit';
          nextButton.classList.add('submit-button');
          termCondition.classList.add('active');
        }
      } else {
        // Handle form submission here
        alert('Form submitted successfully!');
        // You can also submit the form to a server using AJAX or similar
      }
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
  
  


