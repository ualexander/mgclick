'use strict';

window.printCalcLibrary = (function () {

  return {

    helpIcon: function (param) {
      /*
        param {
          title: string
          url: string / false
          insertIn: jQuery Obj / false
        }

        @return - jQuery Obj
      */
      var icon = $('<a>', {
        'class': 'material-icons material-icons_touchable align-top ml-1 text-secondary',
        'target': '_blank',
        'tabindex': '-1',
        'data-toggle': 'tooltip',
        'data-placement': 'top',
        'title': param.title,
      }).tooltip().html('&#xE8FD;');

      if (param.url) {
        icon.attr('href', param.url);
      }

      if (param.insertIn) {
        icon.appendTo(param.insertIn);
      }

      return icon;
    },


    badge: function (param) {
      /*
        param {
          badgeTitle: string
          toolTipTitle: string / false
          insertIn: jQuery Obj / false
        }

        @return - jQuery Obj
      */
      var icon = $('<span>', {
        'class': 'badge badge-pill badge-success ml-2'
      }).text(param.badgeTitle);

      if (param.toolTipTitle) {
        icon.attr({
          'data-toggle': 'tooltip',
          'data-placement': 'top',
          'title': param.toolTipTitle
        }).tooltip();
      }

      if (param.insertIn) {
        icon.appendTo(param.insertIn);
      }

      return icon;
    },


    sizeBlok: function (param) {
      /*
        param {
          inputName: string
          isertBefore: jQuery Obj / false
        }

        @return {
          blok: jQuery Obj
          width: jQuery Obj input
          height: jQuery Obj input
          quantityWrapper: jQuery Obj
          quantity: jQuery Obj
          fileNameWrapper: jQuery Obj
          fileName: fileName
          swap: jQuery Obj
          close: jQuery Obj
        }
      */

      var blok = $('<div>', {'class': 'form-row'});

      var widthWrapper = $('<div>', {'class': 'form-group col'}).appendTo(blok);
      var width = $('<input>', {
        'type': 'number',
        'class': 'form-control form-control-sm',
        'id': param.inputName + '-width',
        'name': param.inputName + '-width',
        'placeholder': 'ширина метров'
      }).appendTo(widthWrapper);
      if (param.isPrintSize) {
        $('<div>', {'class': 'invalid-feedback'}).text('от 0.1 до 500').appendTo(widthWrapper);
      }

      var swap = $('<i>', {
        'class': 'material-icons material-icons_touchable mt-1 text-secondary'
      })
        .html('&#xE8D4;').appendTo(blok);

      var heighthWrapper = $('<div>', {'class': 'form-group col'}).appendTo(blok);
      var height = $('<input>', {
        'type': 'number',
        'class': 'form-control form-control-sm',
        'id': param.inputName + '-height',
        'name': param.inputName + '-height',
        'placeholder': 'высота метров'
      }).appendTo(heighthWrapper);
      if (param.isPrintSize) {
        $('<div>', {'class': 'invalid-feedback'}).text('от 0.1 до 500').appendTo(heighthWrapper);
      }

      var quantityWrapper = $('<div>', {'class': 'form-group col'}).appendTo(blok);
      var quantity = $('<input>', {
        'type': 'number',
        'class': 'form-control form-control-sm',
        'id': param.inputName + '-quantity',
        'name': param.inputName + '-quantity',
        'placeholder': 'кол-во штук'
      }).appendTo(quantityWrapper);
      if (param.isPrintSize) {
        $('<div>', {'class': 'invalid-feedback'}).text('от 1 до 5000').appendTo(quantityWrapper);
      }

      var fileNameWrapper = $('<div>', {'class': 'form-group col'}).appendTo(blok);
      var fileName = $('<input>', {
        'type': 'text',
        'class': 'form-control form-control-sm',
        'id': param.inputName + '-filename',
        'name': param.inputName + '-filename',
        'placeholder': 'имя файла'
      }).appendTo(fileNameWrapper);

      var close = $('<i>', {
        'class': 'material-icons material-icons_touchable mt-1 text-secondary'
      }).html('&#xE14C;').appendTo(blok);

      if (param.isertBefore) {
        param.isertBefore.before(blok);
      }

      return {
        blok: blok,
        width: width,
        height: height,
        quantityWrapper: quantityWrapper,
        quantity: quantity,
        fileNameWrapper: fileNameWrapper,
        fileName: fileName,
        swap: swap,
        close: close
      };
    },


    typeBlok: function (param) {
      /*
        param {
          title: string
          helpIconTitle: string / false
          selectName: string
          insertIn: jQuery Obj / false
        }

        @return {
          blok: jQuery Obj
          select: jQuery Obj select
          helpIcon: jQuery Obj
        }
      */

      var helpIcon = false;

      var blok = $('<div>', {'class': 'form-group col-sm-4'});

      $('<label>', {'for': param.selectName}).text(param.title).appendTo(blok);

      if (param.helpIconTitle) {
        helpIcon = this.helpIcon({title: param.helpIconTitle, insertIn: blok});
      }

      var select = $('<select>', {
        'class': 'custom-select custom-select-sm',
        'id': param.selectName,
        'name': param.selectName
      }).appendTo(blok);

      if (param.insertIn) {
        blok.appendTo(param.insertIn);
      }

      return {
        blok: blok,
        select: select,
        helpIcon: helpIcon
      };
    },


    chekboxBlok: function (param) {
      /*
        param {
          title: string
          helpIconTitle: string / false
          helpIconUrl: string / false
          checkboxName: string
          insertIn: jQuery Obj / false
        }

        @return {
          blok: jQuery Obj
          checkbox: jQuery Obj input-checkbox
          helpIcon: jQuery Obj
        }
      */

      var helpIcon = false;

      var blok = $('<div>', {'class': 'custom-control custom-checkbox mb-3'});

      var checkbox = $('<input>', {
        'type': 'checkbox',
        'class': 'custom-control-input',
        'id': param.checkboxName,
        'name': param.checkboxName
      }).appendTo(blok);

      var label = $('<label>', {
        'class': 'custom-control-label',
        'for': param.checkboxName
      }).text(param.title).appendTo(blok);

      if (param.helpIconTitle) {
        helpIcon = this.helpIcon({title: param.helpIconTitle, insertIn: blok});
      }

      if (param.helpIconTitle && param.helpIconUrl) {
        helpIcon.attr('href', param.helpIconUrl);
      }

      if (param.insertIn) {
        blok.appendTo(param.insertIn);
      }

      return {
        blok: blok,
        checkbox: checkbox,
        helpIcon: helpIcon
      };
    },


    selectInputBlok: function (param) {
      /*
        param {
          title: string / false
          helpIconTitle: string / false
          selectName: string / false
          inputName: string / false
          inputTitle: string / false
          insertIn: jQuery Obj
        }

        @return {
          blok: jQuery Obj
          select: jQuery Obj select
          input: jQuery Obj input
          inputWrapper: jQuery Obj
          helpIcon: jQuery Obj
        }
      */

      var helpIcon = false;
      var select = false;
      var input = false;
      var inputWrapper = false;
      var inputTitle = '';

      if (param.inputTitle) {
        inputTitle = param.inputTitle;
      }

      var blok = $('<div>', {'class': 'form-row'});

      if (!param.inputType) {
        param.inputType = 'number';
      }

      if (param.selectName) {
        var selectWrapper = $('<div>', {'class': 'form-group col-3 col-md-4'}).appendTo(blok);
        select = $('<select>', {
          'class': 'custom-select custom-select-sm',
          'id': param.selectName,
          'name': param.selectName
        }).appendTo(selectWrapper);
      }

      if (param.inputName) {
        var inputWrapper = $('<div>', {'class': 'form-group col-3 col-md-4'}).appendTo(blok);
        input = $('<input>', {
          'type': param.inputType,
          'class': 'form-control form-control-sm',
          'id': param.inputName,
          'name': param.inputName,
          'placeholder': inputTitle
        }).appendTo(inputWrapper);
      }

      if (param.title || param.helpIconTitle) {
        var titleWrapper = $('<div>', {'class': 'col-6 col-md-4 align-bottom mt-1'}).appendTo(blok);
      }

      if (param.title) {
        var title = $('<label>', {'for': param.selectName}).text(param.title).appendTo(titleWrapper);
      }

      if (param.helpIconTitle) {
        helpIcon = this.helpIcon({title: param.helpIconTitle, insertIn: titleWrapper});
      }

      if (param.helpIconTitle && param.helpIconUrl) {
        helpIcon.attr('href', param.helpIconUrl);
      }

      if (param.insertIn) {
        blok.appendTo(param.insertIn);
      }

      return {
        blok: blok,
        select: select,
        input: input,
        inputWrapper: inputWrapper,
        helpIcon: helpIcon
      };
    },


    tabs: function (param) {
      /*
        param {
          blokName: string,
          insertIn: jQuery Obj / false
          tabs: [
            {
              isActive: bool,
              tabTitle: string,
              tabContent: jQuery Obj DIV
            }
          ]
        }

        @return - jQuery Obj, fragment - (tabsBlok, contentBlok)
      */

      var fragment = $(document.createDocumentFragment());

      var tabsBlok = $('<ul>', {
        'class': 'nav nav-tabs mb-3',
        'id': param.blokName + '-tabs',
        'role': 'tablist'
      }).appendTo(fragment);

      var contentBlok = $('<div>', {
        'class': 'tab-content',
        'id': param.blokName + '-content'
      }).appendTo(fragment);

      for (var i = 0; i < param.tabs.length; i++) {
        var tabItemWrapper = $('<li>', {'class': 'nav-item'});

        var tabItem = $('<a>', {
          'class': 'nav-link',
          'data-toggle': 'tab',
          'id': param.blokName + '-tab-' + i,
          'href': '#' + param.blokName + '-content-' + i,
          'role': 'tab',
          'aria-controls': param.blokName + '-content-' + i,
          'aria-selected': 'false'
        }).text(param.tabs[i].tabTitle).appendTo(tabItemWrapper);

        var contentItem = param.tabs[i].tabContent.attr({
          'class': 'tab-pane fade',
          'id': param.blokName + '-content-' + i,
          'role': 'tabpanel',
          'aria-labelledby': param.blokName + '-tab-' + i
        });

        if (param.tabs[i].isActive) {
          tabItem.attr('aria-selected', 'true');
          tabItem.addClass('active');
          contentItem.addClass('show active');
        }

        tabItemWrapper.appendTo(tabsBlok);
        contentItem.appendTo(contentBlok);
      }

      if (param.insertIn) {
        fragment.appendTo(param.insertIn);
      }

      return fragment;
    },


    getFullArrItemsNumber: function (arr) {
      var itemsNumber = 0;

      for (var i = 0; i < arr.length; i++) {
        if (arr[i]) {
          itemsNumber++;
        }
      }

      return itemsNumber;
    },


    getMaxValue: function (arr, notMore) {
      var maxValue = 0;

      for (var i = 0; i < arr.length; i++) {
        if (arr[i] > maxValue && arr[i] <= notMore) {
          maxValue = arr[i];
        }
      }

      return maxValue;
    },


    getFirstLastFillArrIndex: function (index, arr) {
      var fillArrIndex = false;

      for (var i = index; i >= 0; i--) {
        if (arr[i - 1]) {
          fillArrIndex = i - 1;
          break;
        }
      }

      return fillArrIndex;
    },


    getObjItemValue: function (data) {
      var result = {};

      for (var key in data) {
        if (data[key] === false) {
          result[key] = false;
        } else if (typeof (data[key]) === 'number') {
          result[key] = data[key];
        } else if (data[key].jquery && data[key].prop('nodeName') === 'INPUT' && data[key].prop('type') === 'checkbox') {
          result[key] = data[key].prop('checked');
        } else if (data[key].jquery && data[key].prop('nodeName') === 'INPUT') {
          if (data[key].prop('type') === 'text' || data[key].prop('type') === 'number') {
            result[key] = data[key].val();
          }
        } else if (data[key].jquery && data[key].prop('nodeName') === 'SELECT') {
          result[key] = data[key].val();
        } else {
          result[key] = 'some data';
        }
      }

      return result;
    },


    getPrintCalcFormValue: function (printCalcForm) {
      var result = {
        orderItems: [],
        orderControl: {}
      };

      if (printCalcForm.orderItems) {
        var orderItemsResultIndex = 0;

        for (var i = 0; printCalcForm.orderItems.length > i; i++) {
          if (printCalcForm.orderItems[i] !== false) {
            result.orderItems[orderItemsResultIndex] = this.getObjItemValue(printCalcForm.orderItems[i]);

            result.orderItems[orderItemsResultIndex].printSize = [];

            var printSizeResultIndex = 0;

            for (var j = 0; printCalcForm.orderItems[i].printSize.length > j; j++) {
              if (printCalcForm.orderItems[i].printSize[j] !== false) {
                result.orderItems[orderItemsResultIndex].printSize[printSizeResultIndex] = this.getObjItemValue(printCalcForm.orderItems[i].printSize[j]);
                printSizeResultIndex++;
              }
            }

            result.orderItems[orderItemsResultIndex].canvasSize = [];

            var canvasSizeResultIndex = 0;

            for (var k = 0; printCalcForm.orderItems[i].canvasSize.length > k; k++) {
              if (printCalcForm.orderItems[i].canvasSize[k] !== false) {
                result.orderItems[orderItemsResultIndex].canvasSize[canvasSizeResultIndex] = this.getObjItemValue(printCalcForm.orderItems[i].canvasSize[k]);
                canvasSizeResultIndex++;
              }
            }

            if (printCalcForm.orderItems[i].simpleOptionalWork) {
              result.orderItems[orderItemsResultIndex].simpleOptionalWork = this.getObjItemValue(printCalcForm.orderItems[i].simpleOptionalWork);
            }

            if (printCalcForm.orderItems[i].customOptionalWork) {
              result.orderItems[orderItemsResultIndex].customOptionalWork = {};

              if (printCalcForm.orderItems[i].customOptionalWork.top) {
                result.orderItems[orderItemsResultIndex].customOptionalWork.top = this.getObjItemValue(printCalcForm.orderItems[i].customOptionalWork.top);
              }
              if (printCalcForm.orderItems[i].customOptionalWork.bottom) {
                result.orderItems[orderItemsResultIndex].customOptionalWork.bottom = this.getObjItemValue(printCalcForm.orderItems[i].customOptionalWork.bottom);
              }
              if (printCalcForm.orderItems[i].customOptionalWork.right) {
                result.orderItems[orderItemsResultIndex].customOptionalWork.right = this.getObjItemValue(printCalcForm.orderItems[i].customOptionalWork.right);
              }
              if (printCalcForm.orderItems[i].customOptionalWork.left) {
                result.orderItems[orderItemsResultIndex].customOptionalWork.left = this.getObjItemValue(printCalcForm.orderItems[i].customOptionalWork.left);
              }
            }
            orderItemsResultIndex++;
          }
        }
      }

      if (printCalcForm.orderControl) {
        result.orderControl = this.getObjItemValue(printCalcForm.orderControl);
      }

      return result;
    },


    checkRequiredFieldsNotEmpty: function (form) {
      var formCheckResult = true;

      function checkSize(sizeArr) {
        for (var i = 0; sizeArr.length > i; i++) {
          if (sizeArr[i].width && +sizeArr[i].width.val() < 0.01 || sizeArr[i].width && +sizeArr[i].width.val() > 500) {
            sizeArr[i].width.addClass('is-invalid');
            formCheckResult = false;
          } else if (sizeArr[i].width) {
            sizeArr[i].width.removeClass('is-invalid');
          }
          if (sizeArr[i].height && +sizeArr[i].height.val() < 0.01 || sizeArr[i].height && +sizeArr[i].height.val() > 500) {
            sizeArr[i].height.addClass('is-invalid');
            formCheckResult = false;
          } else if (sizeArr[i].height) {
            sizeArr[i].height.removeClass('is-invalid');
          }
          if (sizeArr[i].quantity && +sizeArr[i].quantity.val() < 1 || sizeArr[i].quantity && +sizeArr[i].quantity.val() > 5000) {
            sizeArr[i].quantity.addClass('is-invalid');
            formCheckResult = false;
          } else if (sizeArr[i].quantity) {
            sizeArr[i].quantity.removeClass('is-invalid');
          }
        }
      }

      function checkType(type) {
        if (type.val() == null || type.val() === 'none') {
          type.addClass('is-invalid');
          formCheckResult = false;
        } else {
          type.removeClass('is-invalid');
        }
      }

      for (var i = 0; form.orderItems.length > i; i++) {
        if (!form.orderItems[i].printType) {
          continue;
        }
        form.orderItems[i].alertsWrapper.fadeOut(100);
        checkSize(form.orderItems[i].printSize);
        checkSize(form.orderItems[i].canvasSize);
        checkType(form.orderItems[i].printType);
        checkType(form.orderItems[i].materialGroup);
        checkType(form.orderItems[i].materialType);
      }

      return formCheckResult;
    },


    checkAvalaibleCanvasWidth: function (form) {
      var formCheckResult = true;

      for (var i = 0; form.orderItems.length > i; i++) {
        if (form.orderItems[i].canvasWidthError) {
          form.orderItems[i].canvasWidthError.remove();
          delete form.orderItems[i].canvasWidthError;
        }
        if (!form.orderItems[i].canvasSize) {
          continue;
        }

        var orderCheckResult = true;

        for (var j = 0; form.orderItems[i].canvasSize.length > j; j++) {
          if (form.orderItems[i].canvasSize[j].width && +form.orderItems[i].canvasSize[j].width.val() > form.orderItems[i].maxPrintWidth) {
            orderCheckResult = false;
            formCheckResult = false;
            form.orderItems[i].canvasSize[j].width.addClass('is-invalid');
          } else if (form.orderItems[i].canvasSize[j].width) {
            form.orderItems[i].canvasSize[j].width.removeClass('is-invalid');
          }
        }

        if (!form.orderItems[i].canvasWidthError && orderCheckResult === false) {
          form.orderItems[i].canvasWidthError = $('<div>', {'class': 'alert alert-danger', 'role': 'alert'})
            .html('При компановке ширина холста не может быть больше чем, максимальная ширина печатного поля.'
              + '<br>- максимальная ширина холста '
              + form.orderItems[i].maxPrintWidth + ' м');
          form.orderItems[i].canvasWidthError.appendTo(form.orderItems[i].alertsWrapper);
          form.orderItems[i].alertsWrapper.fadeIn(100);
        }
      }

      return formCheckResult;
    },


    checkPrintSquareNotOverflow: function (form) {
      var formCheckResult = true;

      function getSquareAndQuantity(size) {
        var square = 0;
        var quantity = 0;

        for (var i = 0; size.length > i; i++) {
          if (size[i].width && +size[i].width.val() > 0 &&
            size[i].height && +size[i].height.val() > 0 &&
            size[i].quantity && +size[i].quantity.val() > 0) {

            square = square + (+size[i].width.val() * +size[i].height.val() * +size[i].quantity.val());
            quantity++;
          }
        }

        return {
          square: square,
          quantity: quantity
        };
      }

      for (var i = 0; form.orderItems.length > i; i++) {
        if (form.orderItems[i].squareOverflowError) {
          form.orderItems[i].squareOverflowError.remove();
          delete form.orderItems[i].squareOverflowError;
        }
        if (!form.orderItems[i].canvasSize) {
          continue;
        }

        var canvas = getSquareAndQuantity(form.orderItems[i].canvasSize);

        if (canvas.quantity === 0) {
          continue;
        }

        var print = getSquareAndQuantity(form.orderItems[i].printSize);

        if (print.square > canvas.square) {
          formCheckResult = false;
          form.orderItems[i].squareOverflowError = $('<div>', {'class': 'alert alert-danger', 'role': 'alert'})
            .html('При компановке площадь отпечатка не может быть больше площади холста.' +
              '<br>' + '- площадь отпечатка ' + (Math.ceil(print.square * 100) / 100) + ' м<sup>2</sup>' +
              '<br>' + '- площадь холста ' + (Math.ceil(canvas.square * 100) / 100) + ' м<sup>2</sup>');
          form.orderItems[i].squareOverflowError.appendTo(form.orderItems[i].alertsWrapper);
          form.orderItems[i].alertsWrapper.fadeIn(100);
        }
      }

      return formCheckResult;
    },


    checkForm: function (form) {

      if (form.orderControl.checkFormError) {
        form.orderControl.checkFormError.fadeOut(100).remove();
        delete form.orderControl.checkFormError;
      }

      var checkForm = false;
      var requiredFieldsNotEmpty = this.checkRequiredFieldsNotEmpty(form);
      var avalaibCanvasWidth = false;
      var printSquareNotOverflow = false;

      if (requiredFieldsNotEmpty) {
        avalaibCanvasWidth = this.checkAvalaibleCanvasWidth(form);
      }

      if (avalaibCanvasWidth) {
        printSquareNotOverflow = this.checkPrintSquareNotOverflow(form);
      }

      if (printSquareNotOverflow) {
        checkForm = true;
      }

      if (checkForm === false) {
        this.shsowOrderControlErrorMassage(form, 'При заполнении допущены ошибки');
      }

      return checkForm;
    },


    checkCorrectCustomer: function (form, availableCustemerData) {
      form.orderControl.customer.removeClass('is-invalid');

      if (form.orderControl.checkFormError) {
        form.orderControl.checkFormError.fadeOut(100).remove();
        delete form.orderControl.checkFormError;
      }

      var customer = form.orderControl.customer.val();
      var result = false;

      for (var i = 0; i < availableCustemerData.length; i++) {
        if (availableCustemerData[i].name && availableCustemerData[i].name === customer) {
          var result = true;
          break;
        }
      }

      if (!result) {
        form.orderControl.customer.addClass('is-invalid');
        this.shsowOrderControlErrorMassage(form, 'Несохраненный клиент');
      }

      return result;
    },


    shsowOrderControlErrorMassage: function (form, massage) {
      if (form.orderControl.checkFormError) {
        form.orderControl.checkFormError.fadeOut(100).remove();
        delete form.orderControl.checkFormError;
      }
      form.orderControl.checkFormError = $('<div>', {'class': 'alert alert-danger', 'role': 'alert'}).fadeOut(0)
        .html(massage);
      form.orderControl.checkFormError.appendTo(form.orderControl.alertsWrapper);
      form.orderControl.checkFormError.fadeIn(100);
    },


    createPriceDescriptionBlok: function (calcResultData, printCalcForm, CONFIG, detail) {
      if (printCalcForm.orderControl.priceDescription) {
        printCalcForm.orderControl.priceDescription.fadeOut(100).remove();
        delete printCalcForm.orderControl.priceDescription;
      }


      if (!calcResultData.commonData) {
        return false;
      }
      if (!calcResultData.commonData.calculations) {
        return false;
      }
      if (!calcResultData.commonData.calculations.total) {
        return false;
      }

      function createItemBlok(calcResultDataItem, insertIn) {

        if (!calcResultDataItem.productParam) {
          return false;
        }
        if (!calcResultDataItem.calculations) {
          return false;
        }
        if (!calcResultDataItem.productParam.materialTypeRu) {
          return false;
        }
        if (!calcResultDataItem.productParam.simpleOptionalWork) {
          return false;
        }

        var calculationsKeys = {
          cringle: true,
          gain: true,
          cut: true,
          cord: true,
          pocket: true,
          coupling: true,
          lamination: true,
          stickToPlastic: true,
          designPrice: true,
          total: true
        };

        var laminationName = '';
        var stickToPlasticName = '';

        if (calcResultDataItem.productParam.simpleOptionalWork.lamination &&
          calcResultDataItem.productParam.simpleOptionalWork.lamination.length > 1) {

          laminationName = ', ' + calcResultDataItem.productParam.simpleOptionalWork.lamination;
        }
        if (calcResultDataItem.productParam.simpleOptionalWork.stickToPlastic &&
          calcResultDataItem.productParam.simpleOptionalWork.stickToPlastic.length > 1) {

          stickToPlasticName = ', ' + calcResultDataItem.productParam.simpleOptionalWork.stickToPlastic;
        }

        var blok = $('<div>');

        $('<span>').text((+calcResultDataItem.productParam.index + 1) + '. ' + calcResultDataItem.productParam.materialTypeRu + ', ' +
          calcResultDataItem.productParam.printTypeRu +
          laminationName +
          stickToPlasticName).appendTo(blok);

        for (var i = 0; calcResultDataItem.curentSizeParam.printSize.length > i; i++) {
          if (!calcResultDataItem.curentSizeParam.printSize[i].price) {
            continue;
          }

          $('<br>').appendTo(blok);
          $('<span>').text('- размер: ' +
            calcResultDataItem.curentSizeParam.printSize[i].width / CONFIG.CONVERT_MM_TO_SIZE_UNIT + ' * ' +
            calcResultDataItem.curentSizeParam.printSize[i].height / CONFIG.CONVERT_MM_TO_SIZE_UNIT + ', ' +
            calcResultDataItem.curentSizeParam.printSize[i].quantity + ' шт, ' +
            calcResultDataItem.curentSizeParam.printSize[i].price + ' ' + CONFIG.CURRENCY_ABR).appendTo(blok);
        }

        var priceBlok = $('<ul>', {'class': 'mb-3 mt-2'}).appendTo(blok);

        $('<li>').html('печать: ' + (calcResultDataItem.calculations.print.totalPrice + calcResultDataItem.calculations.overspending.totalPrice) + ' ' + CONFIG.CURRENCY_ABR).appendTo(priceBlok);

        for (var key in calcResultDataItem.calculations) {
          if (calculationsKeys[key] && calcResultDataItem.calculations[key].totalPrice && calcResultDataItem.calculations[key].totalPrice > 0) {
            if (key === 'designPrice' || key === 'total') {
              $('<li>').html(calcResultDataItem.calculations[key].name + ': ' +
                calcResultDataItem.calculations[key].totalPrice + ' ' + CONFIG.CURRENCY_ABR).appendTo(priceBlok);
            } else {
              $('<li>').html(calcResultDataItem.calculations[key].name + ': ' +
                calcResultDataItem.calculations[key].quantity + ' ' +
                calcResultDataItem.calculations[key].unit + ' * ' +
                calcResultDataItem.calculations[key].price + ' ' + CONFIG.CURRENCY_ABR + ' = ' +
                calcResultDataItem.calculations[key].totalPrice + ' ' + CONFIG.CURRENCY_ABR).appendTo(priceBlok);
            }
          }
        }

        blok.appendTo(insertIn);
      }

      printCalcForm.orderControl.priceDescription = $('<div>', {'id': 'ordercontrol-description'}).fadeOut(0);

      var header = $('<div>', {
        'id': 'ordercontrol-description-head',
        'class': 'd-flex justify-content-between align-items-end p-3 bg-light rounded'
      });

      var body = $('<div>', {
        'id': 'ordercontrol-description-body',
        'class': 'collapse',
        'aria-labelledby': 'ordercontrol-description-head',
        'data-parent': '#ordercontrol-description'
      });

      var headerContentPrice = $('<div>', {'class': 'h5 text-primary m-0'})
        .text('Стоимость: ' + calcResultData.commonData.calculations.total.totalPrice + ' ' + CONFIG.CURRENCY_ABR)
        .appendTo(header);

      var headerContentToggle = $('<div>', {
        'class': 'btn btn-link btn-sm ml-3',
        'role': 'button',
        'data-toggle': 'collapse',
        'data-target': '#ordercontrol-description-body',
        'aria-expanded': 'true',
        'aria-controls': 'ordercontrol-description-body'
      })
        .text('подробнее')
        .appendTo(header);

      var bodyContent = $('<div>', {'class': 'p-3'}).appendTo(body);

      $(body).on('show.bs.collapse', function () {
        headerContentPrice.fadeTo(100, 0.1);
        headerContentToggle.text('скрыть подробности');
      });

      $(body).on('hide.bs.collapse', function () {
        headerContentPrice.fadeTo(100, 1);
        headerContentToggle.text('подробнее');
      });

      $('<h5>').html('Стоимость: ' + calcResultData.commonData.calculations.total.totalPrice + ' ' + CONFIG.CURRENCY_ABR)
        .appendTo(bodyContent);

      $('<hr>').appendTo(bodyContent);

      for (var i = 0; calcResultData.items.length > i; i++) {
        createItemBlok(calcResultData.items[i], bodyContent);
      }

      $('<hr>').appendTo(bodyContent);
      $('<span>', {'class': 'text-info h6'}).html('вес ≈ ' + calcResultData.commonData.calculations.total.kg + ' кг.').appendTo(bodyContent);

      if (detail && detail === 'full') {
        $('<span>', {'class': 'text-info h6'}).html('<br>время изготовления ≈ ' + calcResultData.commonData.calculations.total.hours + ' ч.').appendTo(bodyContent);

        $('<span>', {'class': 'text-info h6'}).html('<br>' + Math.ceil(calcResultData.commonData.calculations.total.materialCost) + ' / ' + Math.ceil((calcResultData.commonData.calculations.total.materialCost * 100 / calcResultData.commonData.calculations.total.totalPrice))).appendTo(bodyContent);
      }

      header.appendTo(printCalcForm.orderControl.priceDescription);
      body.appendTo(printCalcForm.orderControl.priceDescription);

      if (printCalcForm.orderControl.descriptionBlok) {
        printCalcForm.orderControl.priceDescription.appendTo(printCalcForm.orderControl.descriptionBlok).fadeIn(100);
      } else {
        return false;
      }
    }

  };
})();
