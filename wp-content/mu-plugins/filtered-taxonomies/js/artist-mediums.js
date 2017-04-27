/**
 *
 * @param result
 * @param medium_input
 * @param terms_all
 */
function update_taxonomy_mediums(result, medium_input, terms_all) {

  var terms_to_enable = JSON.parse(result),
    terms_to_disable;

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

      // and always revert to select none when changed

      term.parent().addClass('term-enabled'); // Add style to this enabled term
    }
  });
}

/**
 *
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
        action: 'change_artist',
        artist_id: this.value,
      },
      dataType: 'html',
      success: function (result) {
        update_taxonomy_mediums(result, medium_input, terms_all); // Disables terms not associated with this artist
      },
      error: function (errorThrown) {
        console.log(errorThrown);
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
