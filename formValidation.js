// Form validation

// make sure the full set of fields are added
$("div.divForm form").append('<div class="form-group"><label for="contactLeerling" class="control-label col-xs-3">Contactleerling</label><div class="col-xs-9"><input type="text" class="form-control" name="contactLeerling" id="contactLeerling" placeholder="contactLeerling"></div></div>');


    $('.modal-body form').bootstrapValidator({
        message: 'Dit veld is niet correct ingevuld',
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        submitButtons: '.saveBtn',

        fields: {
            naamBieder: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and cannot be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 30,
                        message: 'The username must be more than 6 and less than 30 characters long'
                    }
                }
            }, 
            klas: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'De klas moet ingevuld worden'
                    }
                }

            }, 
            contactLeerling: {
                enabled: false,
                validators: {
                    notEmpty: {
                        message: 'De contactleerling moet ingevuld worden'
                    }
                }

            }, 
            email: {
                validators: {
                    emailAddress: {
                        message: 'Dit is geen geldig email-adres'
                    },
                    notEmpty: {
                        message: 'Het is verplicht een e-mailadres op te geven'
                    }
                }

            }, 
            telefoon: {
                validators: {
                    notEmpty: {
                        message: 'Het telefoonnummmer is een verplicht veld'
                    }
                }

            }
        }

    })
    .on('success.field.bv', function(e, data) {
            alert("yippie");
    });

    
// remove non-relevant fields
    $("input#contactLeerling").parent().parent().remove();


    $('.modal').on('shown.bs.modal', function() {
        $('.modal-body form').bootstrapValidator('resetForm', true);
    });

