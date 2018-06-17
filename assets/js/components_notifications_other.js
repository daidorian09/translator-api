/* ------------------------------------------------------------------------------
*
*  # Noty and jGrowl notifications
*
*  Specific JS code additions for components_notifications_other.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Noty plugin
    // ------------------------------

    var notes = [];

    // Text options
    notes['error'] = '<strong>Selected languages are same.\tPlease select different language to another.</strong>';

    // Initialize
    $('.noty-runner').click(function () {
        var self = $(this);
        noty({
            width: 200,
            text: notes[self.data('type')],
            type: self.data('type'),
            dismissQueue: true,
            timeout: 4000,
            layout: self.data('layout'),
            buttons: (self.data('type') != 'confirm') ? false : [
                {
                    addClass: 'btn btn-primary btn-xs',
                    text: 'Ok',
                    onClick: function ($noty) { //this = button element, $noty = $noty element
                        $noty.close();
                        noty({
                            force: true,
                            text: 'You clicked "Ok" button',
                            type: 'success',
                            layout: self.data('layout')
                        });
                    }
                },
                {
                    addClass: 'btn btn-danger btn-xs',
                    text: 'Cancel',
                    onClick: function ($noty) {
                        $noty.close();
                        noty({
                            force: true,
                            text: 'You clicked "Cancel" button',
                            type: 'error',
                            layout: self.data('layout')
                        });
                    }
                }
            ]
        });
        return false;
    });



    //
    // Positions
    //



    // Top center
    $('#word_translated').on('click', function () {
        $('body').find('.jGrowl').attr('class', '').attr('id', '').hide();
        $.jGrowl('<h4>Sentence is already translated<h4>', {
            position: 'top-left',
            theme: 'bg-teal',
            header: '<strong>Warning</strong>'
        });
    });


    
});
