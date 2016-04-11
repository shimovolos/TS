var $j = jQuery.noConflict();

function resendFormChangeTelephone(radioSelector, telephoneSelector, telephoneDiv) {
    console.log($j('#' + radioSelector));
    $j('input[type=radio][name=' + radioSelector + ']').on('change', function() {
      if(this.value == 1) {
          telephoneDiv.show();
          telephoneSelector.prop('disabled', false);
      } else {
          telephoneDiv.hide();
          telephoneSelector.prop('disabled', true);
      }
  });
}
