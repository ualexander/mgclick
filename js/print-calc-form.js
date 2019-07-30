'use strict';

window.printCalcForm = (function() {

  function newForm(inputPrintData, insertIn) {

    insertIn.fadeOut(0);

    var form = {
      orderItems: [],
      orderControl: {
        alertsWrapper: false,
        customer: false,
        customerId: false,
        customerList: false,
        promoCodes: false,
        calcButton: false,
        resetButton: false,
        blankButton: false,
        toSaveButton: false
      }
    };


    function newOrderItemWindow(orderItemIndex, inputPrintData, isertBefore) {
      /*
        @itemIndex - int
        @isertBefore - jQuery Obj
        @inputPrintData - Obj

        @return - Obj (orderItem)
      */

      var CONVERT_MM_TO_SIZE_UNIT = 1000;

      var itemOrderWindowName = 'orderitem-' + orderItemIndex;

      var currentMaterialGroup = false;
      var currentMaterialType = false;
      var currentPrintType = false;

      var orderItem = {
        removeEvtList: false,

        blok: false,
        alertsWrapper: false,
        maxPrintWidth: false,

        index: false,

        printSize: [],

        canvasSize: [],

        materialGroup: false,
        materialType: false,
        printType: false,

        noTechFields: false,
        manualMaterialFormat: false,

        customOptionalWorkToggle: false,

        simpleOptionalWork: {
          cringle: false,
          cringleCustom: false,
          gain: false,
          cut: false,
          cord: false,
          pocket: false,
          pocketCustom: false,
          lamination: false,
          stickToPlastic: false
        },

        designPrice: false,
        notes: false,

        customOptionalWork: {
          top: {
            cringle: false,
            cringleCustom: false,
            gain: false,
            cut: false,
            cord: false,
            pocket: false,
            pocketCustom: false,
            lamination: false,
            stickToPlastic: false
          },
          bottom: {
            cringle: false,
            cringleCustom: false,
            gain: false,
            cut: false,
            cord: false,
            pocket: false,
            pocketCustom: false,
            lamination: false,
            stickToPlastic: false
          },
          left: {
            cringle: false,
            cringleCustom: false,
            gain: false,
            cut: false,
            cord: false,
            pocket: false,
            pocketCustom: false,
            lamination: false,
            stickToPlastic: false
          },
          right: {
            cringle: false,
            cringleCustom: false,
            gain: false,
            cut: false,
            cord: false,
            pocket: false,
            pocketCustom: false,
            lamination: false,
            stickToPlastic: false
          }
        },
        designPriceCustom: false
      };


      // /////////-----ORDER ITEM WINDOW------///////////-----ORDER ITEM WINDOW------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var orderItemWindow = $('<fieldset>', {'class': 'border border-secondary rounded mb-5', 'id': itemOrderWindowName}).fadeOut(0);

      orderItem.blok = orderItemWindow;

      orderItem.index = orderItemIndex;

      function orderItemWindowClickHandler(evt) {

        swapSize(evt);

        closePrintSizebButtonClickHandler(evt);

        closeCanvasSizebButtonClickHandler(evt);
      }

      function orderItemWindowChangeHandler(evt) {
        fillStickToPlasticHelpIcon(evt);
        fillLaminationHelpIcon(evt);
      }

      function closePrintSizebButtonClickHandler(evt) {
        var data = $(evt.target).data();
        if (data.action === 'closePrintSize') {

          if (printCalcLibrary.getFullArrItemsNumber(orderItem.printSize) > 1) {
            closePrintSizeItem(evt);
          }

          setDisableAttrForInaccessibleFileNameFields();
        }
      }

      function closeCanvasSizebButtonClickHandler(evt) {
        var data = $(evt.target).data();
        if (data.action && data.action === 'closeCanvasSize') {

          if (printCalcLibrary.getFullArrItemsNumber(orderItem.printSize) === 1 || printCalcLibrary.getFullArrItemsNumber(orderItem.canvasSize) > 1) {
            closeCanvasSizeItem(evt);
          }

          setDisableAttrForInaccessibleFileNameFields();
        }
      }

      function setDisableAttrForInaccessibleFileNameFields() {
        if (printCalcLibrary.getFullArrItemsNumber(orderItem.canvasSize) > 0) {
          for (var i = 0; orderItem.printSize.length > i; i++) {
            if (orderItem.printSize[i] !== false) {
              orderItem.printSize[i].fileName.attr('disabled', 'true');
            }
          }
          for (var j = 0; orderItem.canvasSize.length > j; j++) {
            if (orderItem.canvasSize[j] !== false) {
              orderItem.canvasSize[j].fileName.removeAttr('disabled');
            }
          }
        } else {
          for (var i = 0; orderItem.printSize.length > i; i++) {
            if (orderItem.printSize[i] !== false) {
              orderItem.printSize[i].fileName.removeAttr('disabled');
            }
          }
        }
      }

      function closePrintSizeItem(evt) {
        var data = $(evt.target).data();
        data.blok.trigger('change');
        data.blok.fadeOut(0).remove();
        orderItem.printSize[data.sizeItemIndex] = false;
      }

      function closeCanvasSizeItem(evt) {
        var data = $(evt.target).data();
        data.blok.trigger('change');
        data.blok.fadeOut(0).remove();
        orderItem.canvasSize[data.sizeItemIndex] = false;

      }

      function swapSize(evt) {
        var data = $(evt.target).data();

        if (data.action && data.action === 'swapSize') {
          var width = data.width.val();
          var height = data.height.val();

          data.width.val(height);
          data.height.val(width);
          data.height.trigger('change');
        }
      }


      // /////////-----ORDER ITEM HEADER BLOK------///////////-----ORDER ITEM HEADER BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var orderItemWindowHeader = $('<div>', {'class': 'bg-light rounded-top pl-3 text-primary clearfix'}).text(orderItemIndex + 1).appendTo(orderItemWindow);

      orderItem.alertsWrapper = $('<div>').appendTo(orderItemWindow);

      var closeOrderItemButton = $('<i>', {'class': 'material-icons material-icons_touchable text-secondary float-right'})
        .data({
          'action': 'closeOrderItemWindow',
          'blok': orderItemWindow,
          'orderItemIndex': orderItemIndex,
        })
        .html('&#xE14C;')
        .appendTo(orderItemWindowHeader);

      if (orderItemIndex !== 0) {
        var orderItemAutoCompleteButton = $('<i>', {'class': 'material-icons material-icons_touchable text-secondary float-right'}).html('&#xE150;');

        orderItemAutoCompleteButton.data({
          'action': 'orderItemAutoComplete',
          'orderItemIndex': orderItemIndex
        });

        orderItemAutoCompleteButton.appendTo(orderItemWindowHeader);
      }


      // /////////-----PRINT PARAM BLOK------///////////-----PRINT PARAM BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var printParamBlok = $('<div>', {'class': 'p-3'}).appendTo(orderItemWindow);

      $('<h4>', {'class': 'text-primary'}).text('Печать ').appendTo(printParamBlok);


      // /////////-----PRINT SIZE BLOK------///////////-----PRINT GROUP------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var printSizeBlok = $('<div>').appendTo(printParamBlok);

      $('<h6>').text('Отпечаток').appendTo(printSizeBlok);

      var printSizeAddButton = $('<i>', {'class': 'material-icons material-icons_touchable text-secondary'})
        .fadeOut(0)
        .html('&#xE145;')
        .appendTo(printSizeBlok);

      if (inputPrintData.userConfig.includeBloks.canvasSize && inputPrintData.userConfig.includeBloks.canvasSize === true) {
        printSizeAddButton.fadeIn(0);
      }

      function addPrintSizeItem() {
        if (printCalcLibrary.getFullArrItemsNumber(orderItem.printSize) < inputPrintData.userConfig.includeBloks.maxSizeBlok) {
          var printSizeItemIndex = orderItem.printSize.length;

          var sizeBlok = printCalcLibrary.sizeBlok({
            inputName: itemOrderWindowName + '-printsizeitem-' + printSizeItemIndex,
            isertBefore: false,
            isPrintSize: true
          });

          sizeBlok.blok.fadeOut(0);
          sizeBlok.close.fadeOut(0);
          sizeBlok.fileNameWrapper.fadeOut(0);

          if (inputPrintData.userConfig.includeBloks.canvasSize && inputPrintData.userConfig.includeBloks.canvasSize === true) {
            sizeBlok.close.fadeIn(0);
            sizeBlok.fileNameWrapper.fadeIn(0);
          } else {
            sizeBlok.quantityWrapper.removeClass('col');
            sizeBlok.quantityWrapper.addClass('col-4');
          }

          sizeBlok.blok.insertBefore(printSizeAddButton);

          sizeBlok.blok.fadeIn(100);

          orderItem.printSize[printSizeItemIndex] = {
            width: sizeBlok.width,
            height: sizeBlok.height,
            quantity: sizeBlok.quantity,
            fileName: sizeBlok.fileName
          };

          sizeBlok.close.data({
            'action': 'closePrintSize',
            'blok': sizeBlok.blok,
            'sizeItemIndex': printSizeItemIndex
          });

          sizeBlok.swap.data({
            'action': 'swapSize',
            'width': sizeBlok.width,
            'height': sizeBlok.height
          });
        }
      }

      addPrintSizeItem();

      function printSizeAddButtonClickHandler() {
        if (inputPrintData.userConfig.includeBloks.canvasSize
          && inputPrintData.userConfig.includeBloks.canvasSize === true
          && printCalcLibrary.getFullArrItemsNumber(orderItem.printSize) === 1
          && printCalcLibrary.getFullArrItemsNumber(orderItem.canvasSize) === 0) {
          addCanvasSizeItem();
        }

        addPrintSizeItem();
        setDisableAttrForInaccessibleFileNameFields();
      }


      // /////////-----CANVAS SIZE BLOK------///////////-----CANVAS SIZE BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      if (inputPrintData.userConfig.includeBloks.canvasSize && inputPrintData.userConfig.includeBloks.canvasSize === true) {
        var canvasSizeBlok = $('<div>').appendTo(printParamBlok);

        var canvasSizeCaption = $('<h6>').text('Холст').appendTo(canvasSizeBlok);

        var canvasSizeAutoCompleteButton = $('<i>', {'class': 'material-icons material-icons_touchable text-secondary ml-1'}).html('&#xE150;').appendTo(canvasSizeCaption);

        var canvasSizeAddButton = $('<i>', {'class': 'material-icons material-icons_touchable text-secondary'})
          .html('&#xE145;')
          .appendTo(canvasSizeBlok);
      }

      function addCanvasSizeItem() {
        var canvasSizeItemIndex = orderItem.canvasSize.length;

        var sizeBlok = printCalcLibrary.sizeBlok({
          inputName: itemOrderWindowName + '-canvassizeitem-' + canvasSizeItemIndex,
          isertBefore: false
        });

        sizeBlok.blok.fadeOut(0);

        sizeBlok.blok.insertBefore(canvasSizeAddButton);

        sizeBlok.blok.fadeIn(100);

        orderItem.canvasSize[canvasSizeItemIndex] = {
          width: sizeBlok.width,
          height: sizeBlok.height,
          quantity: sizeBlok.quantity,
          fileName: sizeBlok.fileName,
          blok: sizeBlok.blok
        };

        sizeBlok.close.data({
          'action': 'closeCanvasSize',
          'blok': sizeBlok.blok,
          'sizeItemIndex': canvasSizeItemIndex
        });

        sizeBlok.swap.data({
          'action': 'swapSize',
          'width': sizeBlok.width,
          'height': sizeBlok.height
        });
      }

      function canvasSizeAddButtonClickHandler() {
        if (printCalcLibrary.getFullArrItemsNumber(orderItem.canvasSize) < inputPrintData.userConfig.includeBloks.maxSizeBlok) {
          addCanvasSizeItem();
        }
        setDisableAttrForInaccessibleFileNameFields();
      }

      function autoCompleteCanvasSize() {
        var canvasSizeIndex = 0;

        for (var i = 0; orderItem.canvasSize.length > i; i++) {
          if (orderItem.canvasSize[i]) {
            orderItem.canvasSize[i].blok.remove();
          }
        }

        orderItem.canvasSize = [];

        for (var j = 0; orderItem.printSize.length > j; j++) {
          if (orderItem.printSize[j]) {
            addCanvasSizeItem();

            orderItem.canvasSize[canvasSizeIndex].width.val(orderItem.printSize[j].width.val());
            orderItem.canvasSize[canvasSizeIndex].height.val(orderItem.printSize[j].height.val());
            orderItem.canvasSize[canvasSizeIndex].quantity.val(orderItem.printSize[j].quantity.val());

            canvasSizeIndex++;
          }
        }
      }

      function canvasSizeAutoCompleteButtonClickHandler() {
        autoCompleteCanvasSize();
      }


      // /////////-----MATERIAL AND PRINT TYPE BLOK------///////////-----MATERIAL AND PRINT TYPE BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var materialAndPritTypeBlok = $('<div>', {'class': 'form-row'}).appendTo(printParamBlok);


      // /////////-----MATERIAL GROUP------///////////-----MATERIAL GROUP------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var materialGroup = printCalcLibrary.typeBlok({
        title: 'Материал',
        helpIconTitle: false,
        selectName: itemOrderWindowName + '-materialgroup',
        insertIn: materialAndPritTypeBlok
      });

      orderItem.materialGroup = materialGroup.select;

      function fillMaterialGroup() {
        $('<option>', {'value': 'none'}).prop({'disabled': true, 'selected': true}).text('выбрать').appendTo(materialGroup.select);

        for (var key in inputPrintData.materialGroups) {
          $('<option>', {'value': key})
            .text(inputPrintData.materialGroups[key].materialsGroupNameRu)
            .appendTo(materialGroup.select);
        }
      }

      fillMaterialGroup();

      function materialGroupChangeHandler() {
        if (inputPrintData.materialGroups[materialGroup.select.val()]) {
          currentMaterialGroup = inputPrintData.materialGroups[materialGroup.select.val()];

          fillMaterialType();

          printType.select.empty();

          materialType.helpIcon.fadeOut(100);

          printType.helpIcon.fadeOut(100);

          availableMaterialFormatsIconWrapper.fadeOut(100).stop(true, true);

          if (inputPrintData.userConfig.includeBloks.manualMaterialFormat && inputPrintData.userConfig.includeBloks.manualMaterialFormat === true) {
            manualMaterialFormat.select.empty();
            $('<option>', {'value': 'default'}).prop({'selected': true}).text('авто').appendTo(manualMaterialFormat.select);
          }
        } else {
          currentMaterialGroup = false;
        }
      }


      // /////////-----MATERIAL TYPE------///////////-----MATERIAL TYPE------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var materialType = printCalcLibrary.typeBlok({
        title: 'Тип',
        helpIconTitle: 'Выбрать материал',
        selectName: itemOrderWindowName + '-materialtype',
        insertIn: false
      });

      materialType.helpIcon.fadeOut(0);

      orderItem.materialType = materialType.select;

      materialType.blok.appendTo(materialAndPritTypeBlok);

      function fillMaterialType() {
        materialType.select.empty();

        $('<option>', {'value': 'none'}).prop({'disabled': true, 'selected': true}).text('выбрать').appendTo(materialType.select);

        for (var key in currentMaterialGroup.materials) {
          $('<option>', {'value': key})
            .text(currentMaterialGroup.materials[key].materialNameRu)
            .appendTo(materialType.select);
        }
      }

      function materialTypeChangeHandler() {
        if (currentMaterialGroup.materials[materialType.select.val()]) {
          currentMaterialType = currentMaterialGroup.materials[materialType.select.val()];

          fillPrintType();

          materialType.helpIcon.attr({
            'data-original-title': currentMaterialType.materialInfoTitle,
            'href': currentMaterialType.materialInfoUrl
          });

          materialType.helpIcon.fadeIn(100);

          printType.helpIcon.fadeOut(100);

          availableMaterialFormatsIconWrapper.fadeOut(100);

          if (inputPrintData.userConfig.includeBloks.noTechFields &&
            inputPrintData.userConfig.includeBloks.noTechFields === true) {

            noTechFields.checkbox.prop('checked', false);
            showHidenoTechFields();
          }
          if (inputPrintData.userConfig.includeBloks.manualMaterialFormat &&
            inputPrintData.userConfig.includeBloks.manualMaterialFormat === true) {

            manualMaterialFormat.select.empty();
            $('<option>', {'value': 'default'}).prop({'selected': true}).text('авто').appendTo(manualMaterialFormat.select);
          }
          if (inputPrintData.userConfig.includeBloks.customOptionalWork &&
            inputPrintData.userConfig.includeBloks.customOptionalWork === true) {

            customOptionalWorkToggle.checkbox.prop('checked', false);
            showHideCustomOptionalWorkToggle();
            showHideCustomOptionalWorkBlok();
            showHideCustomOptionalWorkItems();
          }

          showHideSimpleOptionalWorkBlok();
          showHideSimpleOptionalWorkItems();

          if (inputPrintData.userConfig.includeBloks.designPrice && inputPrintData.userConfig.includeBloks.designPrice === true) {
            designPrice.blok.fadeIn(100);
          }

          if (inputPrintData.userConfig.includeBloks.notes &&
            inputPrintData.userConfig.includeBloks.notes === true) {
            notesWrapper.fadeIn(100);
          }

        } else {
          currentMaterialType = false;
        }
      }


      // /////////-----PRINT TYPE------///////////-----PRINT TYPE------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var printType = printCalcLibrary.typeBlok({
        title: 'Тип печати',
        helpIconTitle: 'Выбрать тип печати',
        selectName: itemOrderWindowName + '-printtype',
        insertIn: false
      });

      printType.helpIcon.fadeOut(0);

      orderItem.printType = printType.select;

      printType.blok.appendTo(materialAndPritTypeBlok);


      function fillPrintType() {
        printType.select.empty();

        $('<option>', {'value': 'none'}).prop({'disabled': true, 'selected': true}).text('выбрать').appendTo(printType.select);

        for (var key in currentMaterialType.materialPrintTypeParametrs) {
          $('<option>', {'value': key})
            .text(currentMaterialType.materialPrintTypeParametrs[key].nameRu)
            .appendTo(printType.select);
        }
      }

      function printTypeChangeHandler() {
        if (currentMaterialType.materialPrintTypeParametrs[printType.select.val()]) {
          currentPrintType = currentMaterialType.materialPrintTypeParametrs[printType.select.val()];

          printType.helpIcon.attr({
            'data-original-title': currentPrintType.printTypeInfoTitle,
            'href': currentPrintType.printTypeInfoUrl
          });

          printType.helpIcon.fadeIn(100);

          fillAvailableMaterialFormats();

          orderItem.maxPrintWidth = getMaxAvaibleCanvasWidth();

          if (inputPrintData.userConfig.includeBloks.manualMaterialFormat && inputPrintData.userConfig.includeBloks.manualMaterialFormat === true) {
            fillManualMaterialFormat();
          }
        } else {
          currentPrintType = false;
        }
      }


      // /////////-----AVAILABLE MATERIAL FORMATS------///////////-----AVAILABLE MATERIAL FORMATS------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var availableMaterialFormatsBlok = $('<div>', {'class': 'mb-4'}).appendTo(printParamBlok);

      $('<span>').text('Доступные форматы').appendTo(availableMaterialFormatsBlok);

      var availableMaterialFormatsIconWrapper = $('<span>').appendTo(availableMaterialFormatsBlok);

      function fillAvailableMaterialFormats() {
        availableMaterialFormatsIconWrapper.empty();

        for (var i = 0; currentMaterialType.materialFormats.length > i &&
        currentMaterialType.materialFormats[i] <= currentPrintType.printerMaxWidth; i++) {

          printCalcLibrary.badge({
            badgeTitle: currentMaterialType.materialFormats[i] / CONVERT_MM_TO_SIZE_UNIT,
            toolTipTitle: 'печатное  поле ' + ((currentMaterialType.materialFormats[i] - currentMaterialType.materialMargin.x * 2) / CONVERT_MM_TO_SIZE_UNIT),
            insertIn: availableMaterialFormatsIconWrapper
          });
        }

        availableMaterialFormatsIconWrapper.fadeIn(100);
      }

      function getMaxAvaibleCanvasWidth() {
        if (currentPrintType) {
          if (orderItem.manualMaterialFormat === false ||
            orderItem.manualMaterialFormat.val() === 'default') {

            return (printCalcLibrary.getMaxValue(currentMaterialType.materialFormats, currentPrintType.printerMaxWidth) -
              currentMaterialType.materialMargin.x * 2) / CONVERT_MM_TO_SIZE_UNIT;

          } else if (manualMaterialFormat && +manualMaterialFormat.select.val() > 0) {
            return (+manualMaterialFormat.select.val() - currentMaterialType.materialMargin.x * 2) / CONVERT_MM_TO_SIZE_UNIT;
          }
        }
      }


      // /////////-----NO TECH FIELDS------///////////-----NO TECH FIELDS------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      if (inputPrintData.userConfig.includeBloks.noTechFields && inputPrintData.userConfig.includeBloks.noTechFields === true) {
        var noTechFields = printCalcLibrary.chekboxBlok({
          title: 'Печать без тех полей',
          helpIconTitle: false,
          checkboxName: itemOrderWindowName + '-notechfields',
          insertIn: false
        });

        noTechFields.blok.fadeOut(0);

        orderItem.noTechFields = noTechFields.checkbox;

        noTechFields.blok.appendTo(printParamBlok);
      }

      function showHidenoTechFields() {
        if (currentMaterialType.materialTechField > 0) {
          noTechFields.blok.fadeIn(100);
        } else {
          noTechFields.blok.fadeOut(0);
        }
      }


      // /////////-----MANUAL MATERIAL FORMAT------///////////-----MANUAL MATERIAL FORMAT------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      if (inputPrintData.userConfig.includeBloks.manualMaterialFormat &&
        inputPrintData.userConfig.includeBloks.manualMaterialFormat === true) {

        var manualMaterialFormat = printCalcLibrary.selectInputBlok({
          title: 'Формат материала',
          helpIconTitle: false,
          selectName: itemOrderWindowName + '-manualmaterialformat',
          inputName: false,
          inputTitle: '',
          insertIn: printParamBlok
        });

        orderItem.manualMaterialFormat = manualMaterialFormat.select;

        $('<option>', {'value': 'default'}).prop({'selected': true}).text('авто').appendTo(manualMaterialFormat.select);
      }

      function fillManualMaterialFormat() {
        manualMaterialFormat.select.empty();

        $('<option>', {'value': 'default'}).prop({'selected': true}).text('авто').appendTo(manualMaterialFormat.select);

        for (var i = 0; currentMaterialType.materialFormats.length > i &&
        currentMaterialType.materialFormats[i] <= currentPrintType.printerMaxWidth; i++) {

          $('<option>', {'value': currentMaterialType.materialFormats[i]})
            .text(currentMaterialType.materialFormats[i] / CONVERT_MM_TO_SIZE_UNIT)
            .appendTo(manualMaterialFormat.select);
        }
      }

      function manualMaterialFormatChangeHandler() {
        orderItem.maxPrintWidth = getMaxAvaibleCanvasWidth();
      }


      // /////////-----OPTIONAL WORK BLOK------///////////-----OPTIONAL WORK BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var optionalWorkBlok = $('<div>', {'class': 'p-3'}).appendTo(orderItemWindow);

      var optionalWorkBlokCaption = $('<h4>', {
        'class': 'text-primary py-3 mb-0 border-top border-secondary'
      }).text('Постпечатная обработка').appendTo(optionalWorkBlok);

      if (inputPrintData.userConfig.includeBloks.customOptionalWork && inputPrintData.userConfig.includeBloks.customOptionalWork === true) {
        var customOptionalWorkToggle = printCalcLibrary.chekboxBlok({
          title: 'Постпечатная обработка каждой стороны с индивидуальными параметрами',
          helpIconTitle: false,
          checkboxName: itemOrderWindowName + '-customoptionalworktoggle',
          insertIn: false
        });

        customOptionalWorkToggle.blok.fadeOut(0);

        orderItem.customOptionalWorkToggle = customOptionalWorkToggle.checkbox;

        customOptionalWorkToggle.blok.appendTo(optionalWorkBlok);

        customOptionalWorkToggle.blok.addClass('mb-5 mt-0');
      }

      function showHideCustomOptionalWorkToggle() {
        if (currentMaterialType.materialCustomOptionalWork && currentMaterialType.materialCustomOptionalWork === true) {
          customOptionalWorkToggle.blok.fadeIn(100);
        } else {
          customOptionalWorkToggle.blok.fadeOut(0);
        }
      }

      function customOptionalWorkToggleChangeHandler() {
        showHideSimpleOptionalWorkBlok();
        showHideCustomOptionalWorkBlok();
      }

      function createOptionalWorkBlok(param) {
        if (param.blokName) {
          param.blokName = '-' + param.blokName;
        }

        var blok = $('<div>');

        if (inputPrintData.optionalWorks.cringle) {
          var cringle = printCalcLibrary.selectInputBlok({
            title: 'Люверсы',
            helpIconTitle: inputPrintData.optionalWorks.cringle.optionalWorkInfoTitle,
            helpIconUrl: inputPrintData.optionalWorks.cringle.optionalWorkInfoUrl,
            selectName: itemOrderWindowName + '-cringle' + param.blokName,
            inputName: itemOrderWindowName + '-cringle' + param.blokName + '-custom',
            inputTitle: 'шаг см',
            insertIn: blok
          });

          cringle.blok.fadeOut(0);
          cringle.inputWrapper.fadeOut(0);

          for (var i = 0; i < inputPrintData.optionalWorks.cringle.defaultOptions.length; i++) {
            if (!param.blokName || inputPrintData.optionalWorks.cringle.defaultOptions[i].value !== 'corners') {
              $('<option>', {'value': inputPrintData.optionalWorks.cringle.defaultOptions[i].value})
                .text(inputPrintData.optionalWorks.cringle.defaultOptions[i].title)
                .appendTo(cringle.select);
            }
          }

          cringle.select.data({
            'action': 'showHideCustomInput',
            'blok': cringle.inputWrapper
          });
        }

        if (inputPrintData.optionalWorks.gain) {
          var gain = printCalcLibrary.chekboxBlok({
            title: 'Усиление края',
            helpIconTitle: inputPrintData.optionalWorks.gain.optionalWorkInfoTitle,
            helpIconUrl: inputPrintData.optionalWorks.gain.optionalWorkInfoUrl,
            checkboxName: itemOrderWindowName + '-gain' + param.blokName,
            insertIn: blok
          });

          gain.blok.fadeOut(0);
        }

        if (inputPrintData.optionalWorks.cut) {
          var cut = printCalcLibrary.chekboxBlok({
            title: 'Рез по контуру',
            helpIconTitle: inputPrintData.optionalWorks.cut.optionalWorkInfoTitle,
            helpIconUrl: inputPrintData.optionalWorks.cut.optionalWorkInfoUrl,
            checkboxName: itemOrderWindowName + '-cut' + param.blokName,
            insertIn: blok
          });

          cut.blok.fadeOut(0);
        }

        if (inputPrintData.optionalWorks.cord) {
          var cord = printCalcLibrary.chekboxBlok({
            title: 'Шнур',
            helpIconTitle: inputPrintData.optionalWorks.cord.optionalWorkInfoTitle,
            helpIconUrl: inputPrintData.optionalWorks.cord.optionalWorkInfoUrl,
            checkboxName: itemOrderWindowName + '-cord' + param.blokName,
            insertIn: blok
          });

          cord.blok.fadeOut(0);
        }

        if (inputPrintData.optionalWorks.pocket) {
          var pocket = printCalcLibrary.selectInputBlok({
            title: 'Карман',
            helpIconTitle: inputPrintData.optionalWorks.pocket.optionalWorkInfoTitle,
            helpIconUrl: inputPrintData.optionalWorks.pocket.optionalWorkInfoUrl,
            selectName: itemOrderWindowName + '-pocket' + param.blokName,
            inputName: itemOrderWindowName + '-pocket' + param.blokName + '-custom',
            inputTitle: 'размер см',
            insertIn: blok
          });

          pocket.blok.fadeOut(0);
          pocket.inputWrapper.fadeOut(0);

          for (var j = 0; j < inputPrintData.optionalWorks.pocket.defaultOptions.length; j++) {
            $('<option>', {'value': inputPrintData.optionalWorks.pocket.defaultOptions[j].value})
              .text(inputPrintData.optionalWorks.pocket.defaultOptions[j].title)
              .appendTo(pocket.select);
          }

          pocket.select.data({
            'action': 'showHideCustomInput',
            'blok': pocket.inputWrapper
          });
        }

        if (inputPrintData.optionalWorks.lamination) {
          var lamination = printCalcLibrary.selectInputBlok({
            title: 'Ламинация',
            helpIconTitle: 'Текст подсказки',
            selectName: itemOrderWindowName + '-lamination' + param.blokName,
            inputName: false,
            inputTitle: false,
            insertIn: blok
          });

          lamination.helpIcon.fadeOut(0);
          lamination.blok.fadeOut(0);

          $('<option>', {'value': 'none'})
            .text('нет')
            .appendTo(lamination.select);

          for (var key1 in inputPrintData.optionalWorks.lamination.materials) {
            $('<option>', {'value': key1})
              .text(inputPrintData.optionalWorks.lamination.materials[key1].nameRu)
              .appendTo(lamination.select);
          }

          lamination.select.data({
            'action': 'fillLaminationHelpIcon',
            'helpIcon': lamination.helpIcon
          });
        }

        if (inputPrintData.optionalWorks.stickToPlastic) {
          var stickToPlastic = printCalcLibrary.selectInputBlok({
            title: 'Накатка',
            helpIconTitle: 'Текст подсказки',
            selectName: itemOrderWindowName + '-sticktoplastic' + param.blokName,
            inputName: false,
            inputTitle: false,
            insertIn: blok
          });

          stickToPlastic.helpIcon.fadeOut(0);
          stickToPlastic.blok.fadeOut(0);

          $('<option>', {'value': 'none'})
            .text('нет')
            .appendTo(stickToPlastic.select);

          for (var key2 in inputPrintData.optionalWorks.stickToPlastic.materials) {
            $('<option>', {'value': key2})
              .text(inputPrintData.optionalWorks.stickToPlastic.materials[key2].nameRu)
              .appendTo(stickToPlastic.select);
          }

          stickToPlastic.select.data({
            'action': 'fillStickToPlasticHelpIcon',
            'helpIcon': stickToPlastic.helpIcon
          });
        }

        if (param.insertIn) {
          blok.appendTo(param.insertIn);
        }

        return {
          blok: blok,
          cringle: cringle,
          gain: gain,
          cut: cut,
          cord: cord,
          pocket: pocket,
          lamination: lamination,
          stickToPlastic: stickToPlastic
        };
      }

      function fillLaminationHelpIcon(evt) {
        var evtTrg = $(evt.target);

        var data = evtTrg.data();

        if (data.action && data.action === 'fillLaminationHelpIcon') {
          if (inputPrintData.optionalWorks.lamination.materials[evtTrg.val()] &&
            inputPrintData.optionalWorks.lamination.materials[evtTrg.val()].optionalWorkInfoTitle) {
            data.helpIcon.attr({
              'data-original-title': inputPrintData.optionalWorks.lamination.materials[evtTrg.val()].optionalWorkInfoTitle,
              'href': inputPrintData.optionalWorks.lamination.materials[evtTrg.val()].optionalWorkInfoUrl
            });
            data.helpIcon.fadeIn(100);
          } else {
            data.helpIcon.fadeOut(100);
          }
        }
      }

      function fillStickToPlasticHelpIcon(evt) {
        var evtTrg = $(evt.target);

        var data = evtTrg.data();

        if (data.action && data.action === 'fillStickToPlasticHelpIcon') {
          if (inputPrintData.optionalWorks.stickToPlastic.materials[evtTrg.val()] && inputPrintData.optionalWorks.stickToPlastic.materials[evtTrg.val()].optionalWorkInfoTitle) {
            data.helpIcon.attr({
              'data-original-title': inputPrintData.optionalWorks.stickToPlastic.materials[evtTrg.val()].optionalWorkInfoTitle,
              'href': inputPrintData.optionalWorks.stickToPlastic.materials[evtTrg.val()].optionalWorkInfoUrl
            });
            data.helpIcon.fadeIn(100);
          } else {
            data.helpIcon.fadeOut(100);
          }
        }
      }


      // /////////-----SIMPLE OPTIONAL WORK BLOK------///////////-----SIMPLE OPTIONAL WORK BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      var simpleOptionalWork = createOptionalWorkBlok({
        blokName: '',
        insertIn: false
      });

      simpleOptionalWork.blok.fadeOut(0).appendTo(optionalWorkBlok);

      orderItem.simpleOptionalWork.cringle = simpleOptionalWork.cringle.select;
      orderItem.simpleOptionalWork.cringleCustom = simpleOptionalWork.cringle.input;
      orderItem.simpleOptionalWork.gain = simpleOptionalWork.gain.checkbox;
      orderItem.simpleOptionalWork.cut = simpleOptionalWork.cut.checkbox;
      orderItem.simpleOptionalWork.cord = simpleOptionalWork.cord.checkbox;
      orderItem.simpleOptionalWork.pocket = simpleOptionalWork.pocket.select;
      orderItem.simpleOptionalWork.pocketCustom = simpleOptionalWork.pocket.input;
      orderItem.simpleOptionalWork.lamination = simpleOptionalWork.lamination.select;
      orderItem.simpleOptionalWork.stickToPlastic = simpleOptionalWork.stickToPlastic.select;

      function showHideSimpleOptionalWorkBlok() {
        if (inputPrintData.userConfig.includeBloks.customOptionalWork
          && inputPrintData.userConfig.includeBloks.customOptionalWork === true
          && customOptionalWorkToggle.checkbox.prop('checked')) {
          simpleOptionalWork.blok.fadeOut(0);
        } else {
          simpleOptionalWork.blok.fadeIn(100);
        }
      }

      function showHideSimpleOptionalWorkItems() {

        if (currentMaterialType.materialCringle && currentMaterialType.materialCringle === true) {
          simpleOptionalWork.cringle.blok.fadeIn(100);
        } else {
          simpleOptionalWork.cringle.blok.fadeOut(0);
        }

        if (currentMaterialType.materialGain && currentMaterialType.materialGain === true) {
          simpleOptionalWork.gain.blok.fadeIn(100);
        } else {
          simpleOptionalWork.gain.blok.fadeOut(0);
        }

        if (currentMaterialType.materialCut && currentMaterialType.materialCut === true) {
          simpleOptionalWork.cut.blok.fadeIn(100);
        } else {
          simpleOptionalWork.cut.blok.fadeOut(0);
        }

        if (currentMaterialType.materialCord && currentMaterialType.materialCord === true) {
          simpleOptionalWork.cord.blok.fadeIn(100);
        } else {
          simpleOptionalWork.cord.blok.fadeOut(0);
        }

        if (currentMaterialType.materialPocket && currentMaterialType.materialPocket === true) {
          simpleOptionalWork.pocket.blok.fadeIn(100);
        } else {
          simpleOptionalWork.pocket.blok.fadeOut(0);
        }

        if (currentMaterialType.materialLamination && currentMaterialType.materialLamination === true) {
          simpleOptionalWork.lamination.blok.fadeIn(100);
        } else {
          simpleOptionalWork.lamination.blok.fadeOut(0);
        }

        if (currentMaterialType.materialStickToPlastic && currentMaterialType.materialStickToPlastic === true) {
          {
            simpleOptionalWork.stickToPlastic.blok.fadeIn(100);
          }
        } else {
          simpleOptionalWork.stickToPlastic.blok.fadeOut(0);
        }

      }


      // /////////-----CUSTOM OPTIONAL WORK BLOK------///////////-----CUSTOM OPTIONAL WORK BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      if (inputPrintData.userConfig.includeBloks.customOptionalWork &&
        inputPrintData.userConfig.includeBloks.customOptionalWork === true) {

        var customOptionalWork = $('<div>').fadeOut(0).appendTo(optionalWorkBlok);

        var customOptionalWorkTop = createOptionalWorkBlok({
          blokName: 'top',
          insertIn: false
        });

        orderItem.customOptionalWork.top.cringle = customOptionalWorkTop.cringle.select;
        orderItem.customOptionalWork.top.cringleCustom = customOptionalWorkTop.cringle.input;
        orderItem.customOptionalWork.top.gain = customOptionalWorkTop.gain.checkbox;
        orderItem.customOptionalWork.top.cut = customOptionalWorkTop.cut.checkbox;
        orderItem.customOptionalWork.top.cord = customOptionalWorkTop.cord.checkbox;
        orderItem.customOptionalWork.top.pocket = customOptionalWorkTop.pocket.select;
        orderItem.customOptionalWork.top.pocketCustom = customOptionalWorkTop.pocket.input;
        orderItem.customOptionalWork.top.lamination = customOptionalWorkTop.lamination.select;
        orderItem.customOptionalWork.top.stickToPlastic = customOptionalWorkTop.stickToPlastic.select;

        var customOptionalWorkBottom = createOptionalWorkBlok({
          blokName: 'bottom',
          insertIn: false
        });

        orderItem.customOptionalWork.bottom.cringle = customOptionalWorkBottom.cringle.select;
        orderItem.customOptionalWork.bottom.cringleCustom = customOptionalWorkBottom.cringle.input;
        orderItem.customOptionalWork.bottom.gain = customOptionalWorkBottom.gain.checkbox;
        orderItem.customOptionalWork.bottom.cut = customOptionalWorkBottom.cut.checkbox;
        orderItem.customOptionalWork.bottom.cord = customOptionalWorkBottom.cord.checkbox;
        orderItem.customOptionalWork.bottom.pocket = customOptionalWorkBottom.pocket.select;
        orderItem.customOptionalWork.bottom.pocketCustom = customOptionalWorkBottom.pocket.input;
        orderItem.customOptionalWork.bottom.lamination = customOptionalWorkBottom.lamination.select;
        orderItem.customOptionalWork.bottom.stickToPlastic = customOptionalWorkBottom.stickToPlastic.select;

        var customOptionalWorkLeft = createOptionalWorkBlok({
          blokName: 'left',
          insertIn: false
        });

        orderItem.customOptionalWork.left.cringle = customOptionalWorkLeft.cringle.select;
        orderItem.customOptionalWork.left.cringleCustom = customOptionalWorkLeft.cringle.input;
        orderItem.customOptionalWork.left.gain = customOptionalWorkLeft.gain.checkbox;
        orderItem.customOptionalWork.left.cut = customOptionalWorkLeft.cut.checkbox;
        orderItem.customOptionalWork.left.cord = customOptionalWorkLeft.cord.checkbox;
        orderItem.customOptionalWork.left.pocket = customOptionalWorkLeft.pocket.select;
        orderItem.customOptionalWork.left.pocketCustom = customOptionalWorkLeft.pocket.input;
        orderItem.customOptionalWork.left.lamination = customOptionalWorkLeft.lamination.select;
        orderItem.customOptionalWork.left.stickToPlastic = customOptionalWorkLeft.stickToPlastic.select;

        var customOptionalWorkRight = createOptionalWorkBlok({
          blokName: 'right',
          insertIn: false
        });

        orderItem.customOptionalWork.right.cringle = customOptionalWorkRight.cringle.select;
        orderItem.customOptionalWork.right.cringleCustom = customOptionalWorkRight.cringle.input;
        orderItem.customOptionalWork.right.gain = customOptionalWorkRight.gain.checkbox;
        orderItem.customOptionalWork.right.cut = customOptionalWorkRight.cut.checkbox;
        orderItem.customOptionalWork.right.cord = customOptionalWorkRight.cord.checkbox;
        orderItem.customOptionalWork.right.pocket = customOptionalWorkRight.pocket.select;
        orderItem.customOptionalWork.right.pocketCustom = customOptionalWorkRight.pocket.input;
        orderItem.customOptionalWork.right.lamination = customOptionalWorkRight.lamination.select;
        orderItem.customOptionalWork.right.stickToPlastic = customOptionalWorkRight.stickToPlastic.select;

        printCalcLibrary.tabs({
          blokName: itemOrderWindowName + '-optionalwork',
          insertIn: customOptionalWork,
          tabs: [
            {
              isActive: true,
              tabTitle: 'Верх',
              tabContent: customOptionalWorkTop.blok
            },
            {
              isActive: false,
              tabTitle: 'Низ',
              tabContent: customOptionalWorkBottom.blok
            },
            {
              isActive: false,
              tabTitle: 'Лево',
              tabContent: customOptionalWorkLeft.blok
            },
            {
              isActive: false,
              tabTitle: 'Право',
              tabContent: customOptionalWorkRight.blok
            }
          ]
        });
      }

      function showHideCustomOptionalWorkBlok() {
        if (currentMaterialType.materialCustomOptionalWork && customOptionalWorkToggle.checkbox.prop('checked')) {
          customOptionalWork.fadeIn(100);
        } else {
          customOptionalWork.fadeOut(0);
        }
      }

      function showHideCustomOptionalWorkItems() {
        if (currentMaterialType.materialCringle && currentMaterialType.materialCringle === true) {
          customOptionalWorkTop.cringle.blok.fadeIn(100);
          customOptionalWorkBottom.cringle.blok.fadeIn(100);
          customOptionalWorkLeft.cringle.blok.fadeIn(100);
          customOptionalWorkRight.cringle.blok.fadeIn(100);
        } else {
          customOptionalWorkTop.cringle.blok.fadeOut(0);
          customOptionalWorkBottom.cringle.blok.fadeOut(0);
          customOptionalWorkLeft.cringle.blok.fadeOut(0);
          customOptionalWorkRight.cringle.blok.fadeOut(0);
        }

        if (currentMaterialType.materialGain && currentMaterialType.materialGain === true) {
          customOptionalWorkTop.gain.blok.fadeIn(100);
          customOptionalWorkBottom.gain.blok.fadeIn(100);
          customOptionalWorkLeft.gain.blok.fadeIn(100);
          customOptionalWorkRight.gain.blok.fadeIn(100);
        } else {
          customOptionalWorkTop.gain.blok.fadeOut(0);
          customOptionalWorkBottom.gain.blok.fadeOut(0);
          customOptionalWorkLeft.gain.blok.fadeOut(0);
          customOptionalWorkRight.gain.blok.fadeOut(0);
        }

        if (currentMaterialType.materialCut && currentMaterialType.materialCut === true) {
          customOptionalWorkTop.cut.blok.fadeIn(100);
          customOptionalWorkBottom.cut.blok.fadeIn(100);
          customOptionalWorkLeft.cut.blok.fadeIn(100);
          customOptionalWorkRight.cut.blok.fadeIn(100);
        } else {
          customOptionalWorkTop.cut.blok.fadeOut(0);
          customOptionalWorkBottom.cut.blok.fadeOut(0);
          customOptionalWorkLeft.cut.blok.fadeOut(0);
          customOptionalWorkRight.cut.blok.fadeOut(0);
        }

        if (currentMaterialType.materialCord && currentMaterialType.materialCord === true) {
          customOptionalWorkTop.cord.blok.fadeIn(100);
          customOptionalWorkBottom.cord.blok.fadeIn(100);
          customOptionalWorkLeft.cord.blok.fadeIn(100);
          customOptionalWorkRight.cord.blok.fadeIn(100);
        } else {
          customOptionalWorkTop.cord.blok.fadeOut(0);
          customOptionalWorkBottom.cord.blok.fadeOut(0);
          customOptionalWorkLeft.cord.blok.fadeOut(0);
          customOptionalWorkRight.cord.blok.fadeOut(0);
        }

        if (currentMaterialType.materialPocket && currentMaterialType.materialPocket === true) {
          customOptionalWorkTop.pocket.blok.fadeIn(100);
          customOptionalWorkBottom.pocket.blok.fadeIn(100);
          customOptionalWorkLeft.pocket.blok.fadeIn(100);
          customOptionalWorkRight.pocket.blok.fadeIn(100);
        } else {
          customOptionalWorkTop.pocket.blok.fadeOut(0);
          customOptionalWorkBottom.pocket.blok.fadeOut(0);
          customOptionalWorkLeft.pocket.blok.fadeOut(0);
          customOptionalWorkRight.pocket.blok.fadeOut(0);
        }

        if (currentMaterialType.materialLamination && currentMaterialType.materialLamination === true) {
          customOptionalWorkTop.lamination.blok.fadeIn(100);
          customOptionalWorkBottom.lamination.blok.fadeIn(100);
          customOptionalWorkLeft.lamination.blok.fadeIn(100);
          customOptionalWorkRight.lamination.blok.fadeIn(100);
        } else {
          customOptionalWorkTop.lamination.blok.fadeOut(0);
          customOptionalWorkBottom.lamination.blok.fadeOut(0);
          customOptionalWorkLeft.lamination.blok.fadeOut(0);
          customOptionalWorkRight.lamination.blok.fadeOut(0);
        }

        if (currentMaterialType.materialStickToPlastic && currentMaterialType.materialStickToPlastic === true) {
          customOptionalWorkTop.stickToPlastic.blok.fadeIn(100);
          customOptionalWorkBottom.stickToPlastic.blok.fadeIn(100);
          customOptionalWorkLeft.stickToPlastic.blok.fadeIn(100);
          customOptionalWorkRight.stickToPlastic.blok.fadeIn(100);
        } else {
          customOptionalWorkTop.stickToPlastic.blok.fadeOut(0);
          customOptionalWorkBottom.stickToPlastic.blok.fadeOut(0);
          customOptionalWorkLeft.stickToPlastic.blok.fadeOut(0);
          customOptionalWorkRight.stickToPlastic.blok.fadeOut(0);
        }
      }


      // /////////-----OTHER PARAM BLOK------///////////-----OTHER PARAM BLOK------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      if (inputPrintData.userConfig.includeBloks.designPrice) {
        var otherParamBlok = $('<div>', {'class': 'p-3'}).appendTo(orderItemWindow);
        var otherParamBlokCaption = $('<h4>', {
          'class': 'text-primary py-3 border-top border-secondary'
        }).text('Дополнительно').appendTo(otherParamBlok);
      }


      // /////////-----DESIGN PRICE------///////////-----DESIGN PRICE------///////////
      // ////////////////////////////////////////////////////////////////////////////////


      if (inputPrintData.otherParam.designPrice &&
        inputPrintData.userConfig.includeBloks.designPrice &&
        inputPrintData.userConfig.includeBloks.designPrice === true) {


        var designPrice = printCalcLibrary.selectInputBlok({
          title: 'Стоимость макета',
          helpIconTitle: false,
          selectName: itemOrderWindowName + '-designprice',
          inputName: itemOrderWindowName + '-designprice-custom',
          inputTitle: 'Руб',
          insertIn: otherParamBlok
        });

        designPrice.blok.fadeOut(0);

        designPrice.inputWrapper.fadeOut(0);

        orderItem.designPrice = designPrice.select;
        orderItem.designPriceCustom = designPrice.input;

        for (var i = 0; i < inputPrintData.otherParam.designPrice.defaultOptions.length; i++) {
          $('<option>', {'value': inputPrintData.otherParam.designPrice.defaultOptions[i].value})
            .text(inputPrintData.otherParam.designPrice.defaultOptions[i].title)
            .appendTo(designPrice.select);
        }

        designPrice.select.data({
          'action': 'showHideCustomInput',
          'blok': designPrice.inputWrapper
        });
      }


      // /////////-----NOTES------///////////-----NOTES------///////////
      // ////////////////////////////////////////////////////////////////////////////////

      if (inputPrintData.userConfig.includeBloks.notes &&
        inputPrintData.userConfig.includeBloks.notes === true) {

        var notesWrapper = $('<div>', {'class': ''}).appendTo(otherParamBlok);
        notesWrapper.fadeOut(0);

        orderItem.notes = $('<input>', {
          'class': 'form-control form-control-sm',
          'id': itemOrderWindowName + '-notes',
          'type': 'text',
          'maxlength': '150',
          'rows': '1',
          'placeholder': 'заметки'
        }).appendTo(notesWrapper);

      }

      // ////////////////////////////////////////////////////////////////////////////////
      // ////////////////////////////////////////////////////////////////////////////////


      orderItemWindow.on('click', orderItemWindowClickHandler);
      orderItemWindow.on('change', orderItemWindowChangeHandler);

      materialGroup.select.on('change', materialGroupChangeHandler);
      materialType.select.on('change', materialTypeChangeHandler);
      printType.select.on('change', printTypeChangeHandler);

      if (manualMaterialFormat) {
        manualMaterialFormat.select.on('change', manualMaterialFormatChangeHandler);
      }

      if (inputPrintData.userConfig.includeBloks.canvasSize && inputPrintData.userConfig.includeBloks.canvasSize === true) {
        printSizeAddButton.on('click', printSizeAddButtonClickHandler);
        canvasSizeAddButton.on('click', canvasSizeAddButtonClickHandler);
        canvasSizeAutoCompleteButton.on('click', canvasSizeAutoCompleteButtonClickHandler);
      }

      if (inputPrintData.userConfig.includeBloks.customOptionalWork && inputPrintData.userConfig.includeBloks.customOptionalWork === true) {
        customOptionalWorkToggle.checkbox.on('change', customOptionalWorkToggleChangeHandler);
      }

      orderItem.removeEvtList = function() {
        orderItemWindow.off('click', orderItemWindowClickHandler);
        orderItemWindow.off('change', orderItemWindowChangeHandler);

        materialGroup.select.off('change', materialGroupChangeHandler);
        materialType.select.off('change', materialTypeChangeHandler);
        printType.select.off('change', printTypeChangeHandler);

        if (manualMaterialFormat) {
          manualMaterialFormat.select.off('change', manualMaterialFormatChangeHandler);
        }

        if (inputPrintData.userConfig.includeBloks.canvasSize && inputPrintData.userConfig.includeBloks.canvasSize === true) {
          printSizeAddButton.off('click', printSizeAddButtonClickHandler);
          canvasSizeAddButton.off('click', canvasSizeAddButtonClickHandler);
          canvasSizeAutoCompleteButton.off('click', canvasSizeAutoCompleteButtonClickHandler);
        }

        if (inputPrintData.userConfig.includeBloks.customOptionalWork && inputPrintData.userConfig.includeBloks.customOptionalWork === true) {
          customOptionalWorkToggle.checkbox.off('change', customOptionalWorkToggleChangeHandler);
        }
      };

      isertBefore.before(orderItemWindow.fadeIn(100));

      return orderItem;
    }


    // /////////-----ORDER ITEM ADD BUTTON------///////////-----ORDER ITEM ADD BUTTON------///////////
    // ////////////////////////////////////////////////////////////////////////////////


    var orderItemAddButton = $('<i>', {
      'class': 'material-icons material-icons_touchable text-secondary mb-5',
      'style': 'font-size:5rem'})
      .html('&#xE145;')
      .appendTo(insertIn);


    // /////////-----ORDER CONTROL WINDOW------///////////-----ORDER CONTROL WINDOW------///////////
    // ////////////////////////////////////////////////////////////////////////////////


    var orderControlWindow = $('<fieldset>', {'class': 'border border-secondary rounded'});

    form.orderControl.alertsWrapper = $('<div>').appendTo(orderControlWindow);

    var orderControlBlok = $('<div>', {'class': 'p-3'}).appendTo(orderControlWindow);


    // /////////-----CUSTOMER------///////////-----CUSTOMER------///////////
    // ////////////////////////////////////////////////////////////////////////////////


    if (inputPrintData.userConfig.includeBloks.customer || inputPrintData.userConfig.includeBloks.customer === true) {

      var customer = $('<div>', {'class': 'input-group form-group mb-0'}).appendTo(orderControlBlok);

      var customerSelect = $('<input>', {
        'type': 'text',
        'class': 'form-control form-control-sm',
        'placeholder': 'клиент поиск по имени почте или телефону',
        'id': 'ordercontrol-customer',
        'name': 'ordercontrol-customer',
        'list': 'customer-list'
      }).appendTo(customer);


      var customerAddButtom = $('<a>', {
        'href': inputPrintData.userConfig.includeBloks.addCustomerButton,
        'target': '_blank',
        'class': 'btn btn-outline-primary btn-sm',
        'role': 'button'
      }).html('добавить').appendTo($('<div>', {'class': 'input-group-append'}).appendTo(customer));

      form.orderControl.customerList = $('<div>', {'class': 'mb-3'}).appendTo(orderControlBlok);

      form.orderControl.customer = customerSelect;
    }


    // /////////-----PROMO CODES------///////////-----PROMO CODES------///////////
    // ////////////////////////////////////////////////////////////////////////////////


    if (inputPrintData.userConfig.includeBloks.promoCodes && inputPrintData.userConfig.includeBloks.promoCodes === true) {

      var promoCodes = $('<div>', {'class': 'form-group'}).appendTo(orderControlBlok);
      var promoCodeInput = $('<input>', {
        'type': 'text',
        'class': 'form-control form-control-sm',
        'placeholder': 'промо код',
        'id': 'ordercontrol-promocode',
        'name': 'ordercontrol-promocode'
      }).appendTo(promoCodes);

      if (inputPrintData.userConfig.includeBloks.quickPromoCodes.length && inputPrintData.userConfig.includeBloks.quickPromoCodes.length > 0) {
        for (var j = 0; inputPrintData.userConfig.includeBloks.quickPromoCodes.length > j; j++) {
          $('<span>', {'class': 'btn btn-sm btn-link', 'role': 'button'})
            .text(inputPrintData.userConfig.includeBloks.quickPromoCodes[j])
            .data({
              'action': 'quickFillPromoCode',
              'value': inputPrintData.userConfig.includeBloks.quickPromoCodes[j],
              'input': promoCodeInput
            }).appendTo(promoCodes);
        }
      }

      form.orderControl.promoCodes = promoCodeInput;
    }


    // /////////-----BUTTONS------///////////-----BUTTONS------///////////
    // ////////////////////////////////////////////////////////////////////////////////


    var buttonsBlok = $('<div>').appendTo(orderControlBlok);

    form.orderControl.calcButton = $('<button>', {'type': 'button', 'class': 'btn btn-sm btn-primary mr-1'})
      .html('расчитать')
      .appendTo(buttonsBlok);

    if (inputPrintData.userConfig.includeBloks.toSaveButton && inputPrintData.userConfig.includeBloks.toSaveButton === true) {
      form.orderControl.toSaveButton = $('<button>', {'type': 'button', 'class': 'btn btn-sm btn-primary mr-1'})
        .text('сохранить')
        .appendTo(buttonsBlok);
    }

    if (inputPrintData.userConfig.includeBloks.blankButton && inputPrintData.userConfig.includeBloks.blankButton === true) {
      form.orderControl.blankButton = $('<button>', {'type': 'button', 'class': 'btn btn-sm btn-primary mr-1'})
        .html('бланк')
        .appendTo(buttonsBlok);
    }

    form.orderControl.resetButton = $('<button>', {'type': 'button', 'class': 'btn btn-sm btn-danger mr-1'})
      .html('сбросить')
      .appendTo(buttonsBlok);

    form.orderControl.descriptionBlok = $('<div>').appendTo(orderControlWindow);


    // /////////-----PROMO SITE------///////////-----PROMO SITE------///////////
    // ////////////////////////////////////////////////////////////////////////////////


    if (inputPrintData.userConfig.includeBloks.promoSite && typeof inputPrintData.userConfig.includeBloks.promoSite === 'string') {
      $('<a>', {'href': inputPrintData.userConfig.includeBloks.promoSite, 'target': '_blank', 'class': 'badge badge-info'})
        .text('Хочу такую же форму себе на сайт')
        .appendTo($('<div>', {'class': 'mt-1 d-flex justify-content-end'}).appendTo(orderControlBlok));
    }


    // ////////////////////////////////////////////////////////////////////////////////
    // ////////////////////////////////////////////////////////////////////////////////


    function closeOrderItem(evt) {
      if (printCalcLibrary.getFullArrItemsNumber(form.orderItems) > 1) {
        var data = $(evt.target).data();

        if (data.action && data.action === 'closeOrderItemWindow') {
          $(evt.target).trigger('change');
          form.orderItems[data.orderItemIndex].removeEvtList();
          form.orderItems[data.orderItemIndex] = false;
          data.blok.fadeOut(0).remove();
        }
      }
    }

    function addOrderItem() {
      if (printCalcLibrary.getFullArrItemsNumber(form.orderItems) < inputPrintData.userConfig.includeBloks.maxOrderBlok) {
        var orderItemIndex = form.orderItems.length;
        form.orderItems[orderItemIndex] = newOrderItemWindow(orderItemIndex, inputPrintData, orderItemAddButton);
      }
    }

    addOrderItem();

    function quickFillPromoCode(evt) {
      var data = $(evt.target).data();

      if (data.action && data.action === 'quickFillPromoCode') {
        data.input.val(data.input.val() + data.value + ', ');
        data.input.trigger('change');
      }
    }

    function inputCustomer(evt) {
      var data = $(evt.target).data();
      if (data.action && data.action === 'inputCustomer') {
        data.orderControl.customer.val(data.name);
        data.orderControl.customerId = data.id;
        data.orderControl.customer.trigger('change');
      }
    }


    function showHideCustomInput(evt) {
      var data = $(evt.target).data();

      if (data.action && data.action === 'showHideCustomInput') {
        if ($(evt.target).val() === 'custom') {
          data.blok.fadeIn(100);
        } else {
          data.blok.fadeOut(100);
        }
      }
    }


    function orderItemAutoComplete(evt) {

      var data = $(evt.target).data();

      if (data.action && data.action === 'orderItemAutoComplete') {
        var fromIndex = printCalcLibrary.getFirstLastFillArrIndex(data.orderItemIndex, form.orderItems);

        var toIndex = data.orderItemIndex;

        if (typeof (fromIndex) === 'number' && typeof (toIndex) === 'number' && form.orderItems[fromIndex] && form.orderItems[toIndex]) {

          function autoCompleteOptionalWork(from, to) {
            if (from.cringle && from.cringle.val()) {
              to.cringle.val(from.cringle.val());
              to.cringleCustom.val(from.cringleCustom.val());
              to.cringle.trigger('change');
            }

            to.gain.prop('checked', from.gain.prop('checked'));
            to.cut.prop('checked', from.cut.prop('checked'));
            to.cord.prop('checked', from.cord.prop('checked'));

            if (from.pocket && from.pocket.val()) {
              to.pocket.val(from.pocket.val());
              to.pocketCustom.val(from.pocketCustom.val());
              to.pocket.trigger('change');
            }

            if (from.lamination && from.lamination.val()) {
              to.lamination.val(from.lamination.val());
              to.lamination.trigger('change');
            }

            if (from.stickToPlastic && from.stickToPlastic.val()) {
              to.stickToPlastic.val(from.stickToPlastic.val());
              to.stickToPlastic.trigger('change');
            }
          }

          if (form.orderItems[fromIndex].materialGroup && form.orderItems[fromIndex].materialGroup.val()) {
            form.orderItems[toIndex].materialGroup.val(form.orderItems[fromIndex].materialGroup.val());
            form.orderItems[toIndex].materialGroup.trigger('change');
          }
          if (form.orderItems[fromIndex].materialType && form.orderItems[fromIndex].materialType.val()) {
            form.orderItems[toIndex].materialType.val(form.orderItems[fromIndex].materialType.val());
            form.orderItems[toIndex].materialType.trigger('change');
          }
          if (form.orderItems[fromIndex].printType && form.orderItems[fromIndex].printType.val()) {
            form.orderItems[toIndex].printType.val(form.orderItems[fromIndex].printType.val());
            form.orderItems[toIndex].printType.trigger('change');
          }
          if (form.orderItems[fromIndex].noTechFields) {
            form.orderItems[toIndex].noTechFields.prop('checked', form.orderItems[fromIndex].noTechFields.prop('checked'));
          }
          if (form.orderItems[fromIndex].manualMaterialFormat) {
            form.orderItems[toIndex].manualMaterialFormat.val(form.orderItems[fromIndex].manualMaterialFormat.val());
            form.orderItems[toIndex].manualMaterialFormat.trigger('change');
          }

          autoCompleteOptionalWork(form.orderItems[fromIndex].simpleOptionalWork, form.orderItems[toIndex].simpleOptionalWork);

          if (form.orderItems[fromIndex].customOptionalWorkToggle) {
            form.orderItems[toIndex].customOptionalWorkToggle.prop('checked', form.orderItems[fromIndex].customOptionalWorkToggle.prop('checked'));
            form.orderItems[toIndex].customOptionalWorkToggle.trigger('change');
            autoCompleteOptionalWork(form.orderItems[fromIndex].customOptionalWork.top, form.orderItems[toIndex].customOptionalWork.top);
            autoCompleteOptionalWork(form.orderItems[fromIndex].customOptionalWork.bottom, form.orderItems[toIndex].customOptionalWork.bottom);
            autoCompleteOptionalWork(form.orderItems[fromIndex].customOptionalWork.left, form.orderItems[toIndex].customOptionalWork.left);
            autoCompleteOptionalWork(form.orderItems[fromIndex].customOptionalWork.right, form.orderItems[toIndex].customOptionalWork.right);
          }

          if (form.orderItems[fromIndex].designPrice) {
            form.orderItems[toIndex].designPrice.val(form.orderItems[fromIndex].designPrice.val());
            form.orderItems[toIndex].designPriceCustom.val(form.orderItems[fromIndex].designPriceCustom.val());
            form.orderItems[toIndex].designPrice.trigger('change');
          }
        }
      }
    }

    function formChangeHandler(evt) {
      showHideCustomInput(evt);
    }

    function orderItemAddButtonClickHandler(evt) {
      addOrderItem();
      $(evt.target).trigger('change');
    }

    function formClickHandler(evt) {
      closeOrderItem(evt);
      orderItemAutoComplete(evt);
      quickFillPromoCode(evt);
      inputCustomer(evt);
    }

    orderItemAddButton.on('click', orderItemAddButtonClickHandler);

    insertIn.on('click', formClickHandler);

    insertIn.on('change', formChangeHandler);

    orderControlWindow.appendTo(insertIn);
    insertIn.fadeIn(100);

    return form;
  }

  return {
    newForm: newForm,
  };
})();
