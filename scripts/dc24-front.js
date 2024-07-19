
jQuery(document).ready(function ($) {
    console.log('DC24 Frontend JS loaded');
    function updateSearchIcon() {
        console.log('facetwp-facet-search found!');
        $('.facetwp-facet-search ').find("i").removeClass('facetwp-icon').addClass('fas fa-search test');
    }

    // Initial update when document is ready
    updateSearchIcon();

    // Update after FacetWP is fully loaded
    $(document).on('facetwp-loaded', function () {
        updateSearchIcon();
    });

});

jQuery(document).ready(function ($) {
    // Show all items initially
    $('.course-item').show();

    // Filter items on button click
    $('.filter-buttons button').on('click', function () {
        var filter = $(this).data('filter');
        // remove the class from all buttons
        $('.filter-buttons button').removeClass('text-primary');
        $(this).addClass('text-primary');

        if (filter === 'all') {
            $('.course-item').show();
        } else {
            $('.course-item').hide();
            $('.' + filter).show();
        }
    });
});

jQuery(document).ready(function ($) {
    // show only .1602 first
    $('.formation-item').hide();
    $('.formation-item.1602').show();
    $('.formation-item.2410').show();
    $('.formation-item.2411').show();
    $('.formation-item.2418').show();
    // Filter items on button click
    $('#filter-buttons-formation button').on('click', function () {
        var filter = $(this).data('filter');
        console.log('Filtering by ' + filter);
        // remove the class from all buttons
        $('#filter-buttons-formation button').removeClass('text-primary');
        $(this).addClass('text-primary');

        if (filter === 'all') {
            $('.formation-item').show();
        } else {
            $('.formation-item').hide();
            $('.' + filter).removeClass("hidden");
            $('.' + filter).show();

        }
    });
});




jQuery(document).ready(function ($) {
    $('.generate-ics').on('click', function (e) {
        e.preventDefault();

        var $this = $(this);
        console.log('Generating ICS file for course ' + $this.data('course-id') + ' session ' + $this.data('session-id'));

        $.ajax({
            url: ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'generate_ics',
                course_id: $this.data('course-id'),
                session_id: $this.data('session-id'),
            },
            success: function (response) {
                if (response.success) {
                    var link = document.createElement('a');
                    link.href = 'data:text/calendar;charset=utf-8,' + encodeURIComponent(response.data);
                    link.download = 'course.ics';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    alert('Failed to generate ICS file: ' + response.data);
                }
            }
        });
    });
});

jQuery(document).ready(function ($) {
    $('.wpml-ls').hover(
        function () {
            console.log("coucou");
            $(this).addClass('wpml-open');
        },
        function () {
            console.log("bye bye");
            $(this).removeClass('wpml-open');
        }
    );
});