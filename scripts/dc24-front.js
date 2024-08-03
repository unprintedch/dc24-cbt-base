
jQuery(document).ready(function ($) {
    function updateSearchIcon() {
        $('.facetwp-facet-search ').find("i").removeClass('facetwp-icon').addClass('fas fa-search test');
    }

    // Initial update when document is ready
    updateSearchIcon();

    // Update after FacetWP is fully loaded
    $(document).on('facetwp-loaded', function () {
        updateSearchIcon();
    });

});



