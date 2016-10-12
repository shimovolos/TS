var $j = jQuery.noConflict();

function resendFormChangeTelephone(radioSelector, telephoneSelector, telephoneDiv) {
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

function enterVerificationCode(radioSelector, codeSelector, codeDiv) {
    $j('input[type=radio][name=' + radioSelector + ']').on('change', function() {
      if(this.value == 0) {
          codeDiv.show();
          codeSelector.prop('disabled', false);
      } else {
          codeDiv.hide();
          codeSelector.prop('disabled', true);
      }
  });
}

function simpleAjaxRequest(url, data, responseSelector) {
    $j.ajax({
        url: url,
        data: data,
        type: "POST",
        success: function (response) {
            if(responseSelector) {
                responseSelector.append(response);
            } else {
                return response;
            }
        }
    });
}
