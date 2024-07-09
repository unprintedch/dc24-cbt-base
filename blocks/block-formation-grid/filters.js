jQuery(document).ready(function($) {
    // Show all items initially
    $('.course-item').show();

    // Filter items on button click
    $('.filter-buttons button').on('click', function() {
        var filter = $(this).data('filter');

        if (filter === 'all') {
            $('.course-item').show();
        } else {
            $('.course-item').hide();
            $('.' + filter).show();
        }
    });
});