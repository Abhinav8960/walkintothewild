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
if ($('.topSlider_tour').length) {
    $('.topSlider_tour').owlCarousel({
        loop: true,
        margin: 0,
        dots: true,
        nav: false,
        smartSpeed: 500,
        autoplay: 300,
        // navText: ['<span class="fal fa-angle-left"></span>', '<span class="fal fa-angle-right"></span>'],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            600: {
                items: 1
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
    nav: false,
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

$(document).ready(function () {
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

// let flashMessageTimeout;
// window.addEventListener('scroll', function () {
//     const flashMessage = document.getElementById('flashMessage');
//     flashMessage.style.display = 'block';

//     if (flashMessageTimeout) {
//         clearTimeout(flashMessageTimeout);
//     }
//     flashMessageTimeout = setTimeout(function () {
//         flashMessage.style.display = 'none';
//     }, 2000);
// });
document.addEventListener('DOMContentLoaded', function () {
    let profile = document.querySelector('.profile');
    let menu = document.querySelector('.menuprofile');

    if (profile && menu) {
        profile.onclick = function (event) {
            menu.classList.toggle('active');
            event.stopPropagation();
        }

        document.addEventListener('click', function (event) {
            if (!profile.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.remove('active');
            }
        });
    }

    const toggleButton = document.getElementById('toggleButton');
    const toggleButtonMobile = document.getElementById('toggleButtonMobile');
    const advanceSearchBox = document.getElementById('advanceSearchBox');

    if (toggleButton && advanceSearchBox) {
        toggleButton.addEventListener('click', function () {
            advanceSearchBox.style.display = (advanceSearchBox.style.display === 'none' || advanceSearchBox.style.display === '') ? 'block' : 'none';
        });
    }

    if (toggleButtonMobile && advanceSearchBox) {
        toggleButtonMobile.addEventListener('click', function () {
            advanceSearchBox.style.display = (advanceSearchBox.style.display === 'none' || advanceSearchBox.style.display === '') ? 'block' : 'none';
        });
    }



    const tabs = document.querySelectorAll('.tab-items');
    const contents = document.querySelectorAll('.tab-content_tour');

    if (tabs && contents) {
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
    }

    const mobileSearchDiv = document.getElementById('mobileSearchDiv');
    const targetDiv = document.getElementById('targetDiv');
    const formSelect = document.querySelector('.form-select');

    if (mobileSearchDiv && targetDiv) {
        mobileSearchDiv.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent the default behavior
            targetDiv.style.display = targetDiv.style.display === 'none' ? 'block' : 'block';
        });

        if (formSelect) {
            formSelect.addEventListener('click', function (event) {
                event.stopPropagation();
            });
        }
    }



    let navbar = document.querySelector('.header_wrapper');

    if (navbar) {
        window.addEventListener('scroll', function () {
            let position = window.scrollY;
            if (position > 80) {
                navbar.classList.add('fixed_top');
            } else {
                navbar.classList.remove('fixed_top');
            }
        });
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


function editor(editor_id) {
    CKEDITOR.ClassicEditor.create(document.getElementById(editor_id), {
        // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
        toolbar: {
            items: [
                'findAndReplace', '|',
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'undo', 'redo', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'specialCharacters', 'horizontalLine', '|',
                // 'textPartLanguage', '|',
                // 'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        // Changing the language of the interface requires loading the language file using the <script> tag.
        // language: 'es',
        list: {
            properties: {
                styles: true,
                startIndex: true,
                reversed: true
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
        heading: {
            options: [{
                model: 'paragraph',
                title: 'Paragraph',
                class: 'ck-heading_paragraph'
            },
            {
                model: 'heading1',
                view: 'h1',
                title: 'Heading 1',
                class: 'ck-heading_heading1'
            },
            {
                model: 'heading2',
                view: 'h2',
                title: 'Heading 2',
                class: 'ck-heading_heading2'
            },
            {
                model: 'heading3',
                view: 'h3',
                title: 'Heading 3',
                class: 'ck-heading_heading3'
            },
            {
                model: 'heading4',
                view: 'h4',
                title: 'Heading 4',
                class: 'ck-heading_heading4'
            },
            {
                model: 'heading5',
                view: 'h5',
                title: 'Heading 5',
                class: 'ck-heading_heading5'
            },
            {
                model: 'heading6',
                view: 'h6',
                title: 'Heading 6',
                class: 'ck-heading_heading6'
            }
            ]
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
        placeholder: 'Enter Page Detail!',
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true
        },
        // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
        // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
        htmlSupport: {
            allow: [{
                name: /.*/,
                attributes: true,
                classes: true,
                styles: true
            }]
        },
        // Be careful with enabling previews
        // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
        htmlEmbed: {
            showPreviews: true
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                }
            }
        },
        // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
        mention: {
            feeds: [{
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes', '@chocolate', '@cookie', '@cotton', '@cream',
                    '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice', '@jelly-o',
                    '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding', '@sesame', '@snaps', '@soufflé',
                    '@sugar', '@sweet', '@topping', '@wafer'
                ],
                minimumCharacters: 1
            }]
        },
        // The "super-build" contains more premium features that require additional configuration, disable them below.
        // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
        removePlugins: [
            // These two are commercial, but you can try them out without registering to a trial.
            // 'ExportPdf',
            // 'ExportWord',
            'CKBox',
            'CKFinder',
            'EasyImage',
            // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
            // Storing images as Base64 is usually a very bad idea.
            // Replace it on production website with other solutions:
            // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
            // 'Base64UploadAdapter',
            'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges',
            'RealTimeCollaborativeRevisionHistory',
            'PresenceList',
            'Comments',
            'TrackChanges',
            'TrackChangesData',
            'RevisionHistory',
            'Pagination',
            'WProofreader',
            // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
            // from a local file system (file://) - load this site via HTTP server if you enable MathType
            'MathType'
        ]
    });
}

function bulleteditor(editor_id) {
    CKEDITOR.ClassicEditor.create(document.getElementById(editor_id), {
        toolbar: {
            items: ['numberedList'] // Include only 'numberedList' in the toolbar items
        },
        heading: false, // Disable heading options
        placeholder: 'Enter Page Detail!',
        fontFamily: {
            options: [
                'default', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif'
            ],
            supportAllValues: true
        },
        fontSize: {
            options: [10, 12, 14, 'default', 18, 20, 22],
            supportAllValues: true
        },
        htmlSupport: {
            allow: [{ name: /.*/, attributes: true, classes: true, styles: true }]
        },
        htmlEmbed: { showPreviews: true },
        link: {
            decorators: {
                addTargetToExternalLinks: true,
                defaultProtocol: 'https://',
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: { download: 'file' }
                }
            }
        },
        mention: {
            feeds: [{
                marker: '@',
                feed: [
                    '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                    '@chocolate', '@cookie', '@cotton', '@cream', '@cupcake', '@danish',
                    '@donut', '@dragée', '@fruitcake', '@gingerbread', '@gummi', '@ice',
                    '@jelly-o', '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie',
                    '@plum', '@pudding', '@sesame', '@snaps', '@soufflé', '@sugar',
                    '@sweet', '@topping', '@wafer'
                ],
                minimumCharacters: 1
            }]
        },
        removePlugins: [
            'CKBox', 'CKFinder', 'EasyImage', 'RealTimeCollaborativeComments',
            'RealTimeCollaborativeTrackChanges', 'RealTimeCollaborativeRevisionHistory',
            'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory',
            'Pagination', 'WProofreader', 'MathType'
        ],
        on: {
            pluginsLoaded: function () {
                // Set numbered list active by default
                this.execute('numberedList');
            }
        }
    })
        .catch(error => {
            console.error(error);
        });
}


