/**
 * @param result
 * @param medium_input
 * @param terms_all
 *
 * On admin product create/edit pages, update taxonomy 'mediums' terms to display
 * the terms that are not associated with that artist as disabled.
 *
 * TODO The entire terms' input section should be in the AJAX response.
 */
function update_taxonomy_mediums(terms_to_enable, medium_input, terms_all) {
  var terms_to_disable;

  // Only include terms that do not exist in terms_to_enable
  terms_to_disable = terms_all.filter(function (term_id) {

    // Do NOT include (return false) the value if it's NOT in the terms_to_enable
    return (terms_to_enable.indexOf(parseInt(term_id)) !== -1 || term_id === '') ? false : true;
  });

  medium_input.each(function () {
    let term = jQuery(this);

    if (terms_to_disable.indexOf(term.prop('value')) !== -1) {
      term.prop('disabled', true); // Disable this term
    } else {

      // TODO Select "none" on every change. This requires a better AJAX response.

      term.parent().addClass('term-enabled'); // Add style to this enabled term
    }
  });
}

/**
 * Initialize the listener to trigger a change event when the product's artist
 * is updated. The event sends an AJAX request with the action and the newly
 * selected artist ID.
 */
function init_taxonomy_mediums() {
  var medium_input = jQuery('#acf-medium ul li input'),
    terms_all = [];

  jQuery('#acf-field-single_artist').change(function(){

    medium_input.each(function () {
      let term = jQuery(this);

      terms_all.push(term.prop('value')); // Add it to the list of all terms
      term.prop('disabled', false); // Disable all to reset each time
      term.parent().removeClass('term-enabled'); // Remove class to reset each time
    });

    jQuery.ajax({
      url: "/wp-admin/admin-ajax.php",
      type: 'POST',
      data: {
        action: 'change_artist', // TODO Action needs to be exact string as backend.
        artist_id: this.value,
      },
      dataType: 'html',
      success: function (result) {
        let terms_to_enable = JSON.parse(result);

        if (Array.isArray(terms_to_enable)) {
          update_taxonomy_mediums(terms_to_enable, medium_input, terms_all); // Disables terms not associated with this artist
        } else {
          window.console.log('action: change_artist: No terms returned')
        }
      },
      error: function (errorThrown) {
        window.console.log("action: change_artist: Error");
        window.console.log(errorThrown);
      }
    });
  }).trigger('change');
}

jQuery(document).ready(function($) {
  jQuery( document.body ).on( 'post-load', function () {
    // New content has been added to the page.
    init_taxonomy_mediums();
  } );

  jQuery( document.body ).trigger( 'post-load' );
});
