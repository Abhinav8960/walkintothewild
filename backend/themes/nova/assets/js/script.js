document.addEventListener('DOMContentLoaded', function () {

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


});