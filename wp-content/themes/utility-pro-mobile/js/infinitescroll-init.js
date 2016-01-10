jQuery(function($){
    var $container = $('.content');

    $container.infinitescroll({
        navSelector  : '.archive-pagination',    // selector for the paged navigation
        nextSelector : '.archive-pagination .pagination-next a',  // selector for the NEXT link (to page 2)
        itemSelector : '.content .entry',     // selector for all items you'll retrieve
        loading: {
            finishedMsg: "<em>No more posts to load.</em>",
            img: 'http://websitesetuppro.com/demos/genesis-masonry/wp-content/themes/genesis-sample/js/images/loader.gif',
            msgText: "<em>Loading the next set of posts...</em>",
            speed: 'fast'
        },
    },

        // trigger Masonry as a callback
        function( newElements ) {
            // hide new items while they are loading
            var $newElems = $( newElements ).css({ opacity: 0 });
            // ensure that images load before adding to masonry layout
            $newElems.imagesLoaded(function(){
                // show elems now they're ready
                $newElems.animate({ opacity: 1 });
                $container.masonry( 'appended', $newElems, true );
            });
        }
    );
});