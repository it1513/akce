$(function(){
    $.nette.init();
    
    $('#confirm').on('show.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-title').text($(event.relatedTarget).data('title'));
        modal.find('.modal-body').html($(event.relatedTarget).data('message'));
        modal.find('.modal-footer').html('<a href="' + $(event.relatedTarget).data('link') + '" class="btn btn-danger">Ano</a> <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne</button>');
    });

    $.datepicker.regional['cs'] = {
      closeText: 'Zavřít',
      prevText: '&#x3c;Dříve',
      nextText: 'Později&#x3e;',
      currentText: 'Nyní',
      monthNames: ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen',
        'září', 'říjen', 'listopad', 'prosinec'],
      monthNamesShort: ['led', 'úno', 'bře', 'dub', 'kvě', 'čer', 'čvc', 'srp', 'zář', 'říj', 'lis', 'pro'],
      dayNames: ['neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'],
      dayNamesShort: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
      dayNamesMin: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
      weekHeader: 'Týd',
      dateFormat: 'dd. mm. yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['cs']);

    $('input#datepicker').datepicker(
    {
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd.mm.yy',  // mm/dd/yy
        yearRange: '2019:2030',
        regional: {
          closeText: 'Zavřít',
          prevText: '&#x3c;Dříve',
          nextText: 'Později&#x3e;',
          currentText: 'Nyní',
          monthNames: ['leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen',
            'září', 'říjen', 'listopad', 'prosinec'],
          monthNamesShort: ['led', 'úno', 'bře', 'dub', 'kvě', 'čer', 'čvc', 'srp', 'zář', 'říj', 'lis', 'pro'],
          dayNames: ['neděle', 'pondělí', 'úterý', 'středa', 'čtvrtek', 'pátek', 'sobota'],
          dayNamesShort: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
          dayNamesMin: ['ne', 'po', 'út', 'st', 'čt', 'pá', 'so'],
          weekHeader: 'Týd',
          dateFormat: 'dd. mm. yy',
          firstDay: 1,
          isRTL: false,
          showMonthAfterYear: false,
          yearSuffix: ''
        }
    });

    $('[name=termin]#datepicker').on('change', function(){
        var datum = $(this).val().split('.');
        $('[name=symbol]').val(datum[2]+datum[1]+datum[0]);
    });

    tinyMCE.init({
        language : "cs",
        selector: "textarea",
        plugins: "lists,paste,wordcount,quickbars",     
        contextmenu: "link image imagetools table spellchecker",
        quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote',
        toolbar: [
            {
              name: 'history', items: [ 'undo', 'redo' ]
            },
            {
              name: 'styles', items: [ 'styleselect' ]
            },
            {
              name: 'formatting', items: [ 'bold', 'italic', 'fontsizeselect']
            },
            {
              name: 'alignment', items: [ 'alignleft', 'aligncenter', 'alignright', 'alignjustify' ]
            },
            {
              name: 'indentation', items: [ 'outdent', 'indent', 'bullist', 'numlist', 'link', 'unlink' ]
            },
          ],
        font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace;',
        fontsize_formats: '11px 12px 14px 16px 18px 24px 36px 48px',    
        });
});
