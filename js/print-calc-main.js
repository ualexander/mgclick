'use strict';

window.printCalcMain = (function () {

  var CONFIG = {
    conteinerName: 'print-calc-container',
    CURRENCY_ABR: 'р.',
    CONVERT_MM_TO_SIZE_UNIT: 1000
  };

  var printCalcForm = false;
  var calcResultData = false;
  var descriptionBlok = false;
  var descriptionBlokDetails = false;
  var availableCustemerData = [];

  var isNotDubleCalcButtonClick = true;
  var isNotDubleBlankButtonClick = true;

  var printCalcFormConteiner = $('.' + CONFIG.conteinerName);
  var printCalcUrl = printCalcFormConteiner.attr('data-url');

  if (printCalcUrl) {
    $.ajax({
      url: printCalcUrl,
      type: 'GET',
      dataType: 'json',
      data: {
        'action': 'get-print-data'
      },
      success: function (inputPrintData) {

        printDataLoadHandler(inputPrintData);

      }
    });
  }

  function printCalcFormChangeHandler() {
    isNotDubleCalcButtonClick = true;
    isNotDubleBlankButtonClick = true;
    printCalcForm.orderControl.calcButton.removeAttr('disabled');

    if (printCalcForm.orderControl.blankButton) {
      printCalcForm.orderControl.blankButton.removeAttr('disabled', '');
    }

    descriptionBlok.fadeOut(100);
  }


  function inputCalcFormChangeHandler() {
    isNotDubleCalcButtonClick = true;
    isNotDubleBlankButtonClick = true;

    printCalcForm.orderControl.calcButton.removeAttr('disabled');

    if (printCalcForm.orderControl.blankButton) {
      printCalcForm.orderControl.blankButton.removeAttr('disabled', '');
    }

    descriptionBlok.fadeOut(100);
  }



  function printDataLoadHandler(inputPrintData) {

    printCalcForm = window.printCalcForm.newForm(inputPrintData, printCalcFormConteiner);

    printCalcForm.orderControl.calcButton.on('click', calcButtonClickHandler);

    if (printCalcForm.orderControl.customer) {
      printCalcForm.orderControl.customer.on('input', customerInputHandler);
    }
    if (printCalcForm.orderControl.blankButton) {
      printCalcForm.orderControl.blankButton.on('click', blankButtonClickHandler);
    }
    if (printCalcForm.orderControl.toSaveButton) {
      printCalcForm.orderControl.toSaveButton.on('click', saveButtonClickHandler);
    }

    printCalcForm.orderControl.resetButton.on('click', resetButtonClickHandler);
    printCalcFormConteiner.on('change', printCalcFormChangeHandler);
    printCalcFormConteiner.on('input', inputCalcFormChangeHandler);
    descriptionBlok = printCalcForm.orderControl.descriptionBlok;
    descriptionBlokDetails = inputPrintData.userConfig.includeBloks.descriptionBlokDetails;
  }


  function calcButtonClickHandler() {
    if (printCalcLibrary.checkForm(printCalcForm) && isNotDubleCalcButtonClick) {
      $.ajax({
        url: printCalcUrl,
        type: 'POST',
        dataType: 'json',
        data: {
          'action': 'get-calc-result-data',
          'print-calc-form-value': JSON.stringify(printCalcLibrary.getPrintCalcFormValue(printCalcForm))
        },
        success: function (calcResultData) {
          calcResultDataLoadHandler(calcResultData);
        }
      });
    }
  }


  function calcResultDataLoadHandler(data) {
    calcResultData = data;
    printCalcLibrary.createPriceDescriptionBlok(calcResultData, printCalcForm, CONFIG, descriptionBlokDetails);
    isNotDubleCalcButtonClick = false;
    printCalcForm.orderControl.calcButton.attr('disabled', '');
    descriptionBlok.fadeIn(100);
  }


  function saveButtonClickHandler() {
    if (printCalcLibrary.checkForm(printCalcForm) && printCalcLibrary.checkCorrectCustomer(printCalcForm, availableCustemerData)) {
      $.ajax({
        url: printCalcUrl,
        type: 'POST',
        dataType: 'json',
        data: {
          'action': 'save-print-order',
          'print-calc-form-value': JSON.stringify(printCalcLibrary.getPrintCalcFormValue(printCalcForm))
        },
        success: function (response) {
          if (response['operation-status'] && response['operation-status'] === 'true') {
            window.open(response['url']);
            location.reload();
          } else if (response['error-massage']) {
            printCalcLibrary.shsowOrderControlErrorMassage(printCalcForm, response['error-massage']);
          } else {
            printCalcLibrary.shsowOrderControlErrorMassage(printCalcForm, 'неизвестная ошибка');
          }
        }
      });
    }
  }


  function blankButtonClickHandler() {
    if (printCalcLibrary.checkForm(printCalcForm) === true && isNotDubleBlankButtonClick) {
      $.ajax({
        url: printCalcUrl,
        type: 'POST',
        dataType: 'json',
        data: {
          'action': 'save-tmp-calc-result-data',
          'print-calc-form-value': JSON.stringify(printCalcLibrary.getPrintCalcFormValue(printCalcForm))
        },
        success: function (response) {
          if (response['operation-status'] && response['operation-status'] === 'true') {
            isNotDubleBlankButtonClick = false;
            printCalcForm.orderControl.blankButton.attr('disabled', '');
            window.open(response['url']);
          } else if (response['error-massage']) {
            printCalcLibrary.shsowOrderControlErrorMassage(printCalcForm, response['error-massage']);
          } else {
            printCalcLibrary.shsowOrderControlErrorMassage(printCalcForm, 'неизвестная ошибка');
          }
        }
      });
    }
  }


  function fillCustomerList() {
    if (printCalcForm.orderControl.customer && printCalcForm.orderControl.customer.val().length >= 3) {
      $.ajax({
        url: printCalcUrl,
        type: 'GET',
        dataType: 'json',
        data: {
          'action': 'get-client-names',
          'short-info': printCalcForm.orderControl.customer.val()
        },
        success: function (customerData) {
          if (customerData.length !== printCalcForm.orderControl.customerList.data('lastCustomerDataLength')) {

            availableCustemerData = customerData;
            printCalcForm.orderControl.customerList.fadeTo(100, 0);
            printCalcForm.orderControl.customerList.empty();
            for (var i = 0; i < customerData.length; i++) {
              $('<span>', {
                'class': 'btn btn-sm btn-link',
                'role': 'button'
              }).text(customerData[i]['name'].toLowerCase()).appendTo(printCalcForm.orderControl.customerList).data({
                'action': 'inputCustomer',
                'name': customerData[i]['name'],
                'id': customerData[i]['id'],
                'orderControl': printCalcForm.orderControl
              });
            }
            printCalcForm.orderControl.customerList.fadeTo(100, 1);
            printCalcForm.orderControl.customerList.data({'lastCustomerDataLength': customerData.length});
          }
        }
      });
    } else if (printCalcForm.orderControl.customer.val().length < 3) {
      printCalcForm.orderControl.customerList.fadeTo(100, 0);
      printCalcForm.orderControl.customerList.empty();
      printCalcForm.orderControl.customerList.data({'lastCustomerDataLength': 0});
    }
  }


  function customerInputHandler() {
    fillCustomerList();
  }


  function resetButtonClickHandler() {
    location.reload();
  }

  return false;

})();
