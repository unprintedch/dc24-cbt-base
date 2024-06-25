
jQuery(document).ready(function($) {
    console.log('DC24 Frontend JS loaded');
    function updateSearchIcon() {
        console.log('facetwp-facet-search found!');
        $('.facetwp-facet-search ').find("i").removeClass('facetwp-icon').addClass('fas fa-search test');
    }

    // Initial update when document is ready
    updateSearchIcon();

    // Update after FacetWP is fully loaded
    $(document).on('facetwp-loaded', function() {
        updateSearchIcon();
    });

});

jQuery(document).ready(function($) {
    // Show all items initially
    $('.course-item').show();

    // Filter items on button click
    $('.filter-buttons button').on('click', function() {
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