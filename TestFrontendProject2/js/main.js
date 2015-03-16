/* attach a submit handler to the form */
$("#dtCalFormSubmit").click(function(event) {
    //alert("submit event");
    /* stop form from submitting normally */
    event.preventDefault();

    // validating the form
    var isFormValid = true;
    $(".required input").each(function() {
        if ($.trim($(this).val()).length === 0) {
            isFormValid = false;
        }
    });

    if (!isFormValid)
        alert("Please fill in all the required fields (indicated by *)");
    else {
        /*clear result div*/
        $("#results").html('');

        /* get some values from elements on the page: */
        var formValues = $('#dtCalForm').serialize();

        /* Send the data using post and put the results in a div */
        $.ajax({
            url: "WebServiceClientZF.php",
            type: "post",
            data: formValues,
            dataType: 'json',
            success: function(data) {
                var htmlString = '';
                if (data.success) {
                    for (var i = 0; i < data.total; i++) {
                        htmlString += data.data[i][0] + " - " + data.data[i][1] + " <br />";
                    }
                    $('#results').html(htmlString);
                    $("#results").removeClass('alert-danger');
                    $("#results").addClass('alert-info');
                    $("#results").fadeIn(1500);
                }
            },
            error: function() {
                $("#results").html('There was an error in processing the request.');
                $("#results").addClass('alert-danger');
                $("#results").fadeIn(1500);
            }
        });
    }
});



/* attach a submit handler to the form */
$("#dtCalFormSubmit_Old").click(function(event) {
    //alert("submit event");
    /* stop form from submitting normally */
    event.preventDefault();

    /*clear result div*/
    $("#results").html('');

    /* get some values from elements on the page: */
    var val = $('#dtCalForm').serialize();

    var params = JSON.stringify($('#dtCalForm').serializeObject(), null);
    /* Send the data using post and put the results in a div */
    $.ajax({
        url: "process.php?params=" + params,
        type: "post",
        data: val,
        dataType: 'json',
        success: function(data) {
            var htmlString = '';
            if (data.success) {
                for (var i = 0; i < data.total; i++) {
                    htmlString += data.data[i][0] + " - " + data.data[i][1] + " <br />";
                }
                $('#results').html(htmlString);
                $("#results").addClass('msg_notice');
                $("#results").fadeIn(1500);
            }
        },
        error: function() {
            $("#results").html('There was an error updating the settings');
            $("#results").addClass('msg_error');
            $("#results").fadeIn(1500);
        }
    });
});

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

(function($) {
    $.widget("custom.combobox", {
        _create: function() {
            this.wrapper = $("<span>")
                    .addClass("custom-combobox")
                    .insertAfter(this.element);
            this.element.hide();
            this._createAutocomplete();
            this._createShowAllButton();
        },
        _createAutocomplete: function() {
            var selected = this.element.children(":selected"),
                    value = selected.val() ? selected.text() : "";
            this.input = $("<input>")
                    .appendTo(this.wrapper)
                    .val(value)
                    .attr("title", "")
                    .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy(this, "_source")
                    })
                    .tooltip({
                        tooltipClass: "ui-state-highlight"
                    });
            this._on(this.input, {
                autocompleteselect: function(event, ui) {
                    ui.item.option.selected = true;
                    this._trigger("select", event, {
                        item: ui.item.option
                    });
                },
                autocompletechange: "_removeIfInvalid"
            });
        },
        _createShowAllButton: function() {
            var input = this.input,
                    wasOpen = false;
            $("<a>")
                    .attr("tabIndex", -1)
                    .attr("title", "Show All Items")
                    .tooltip()
                    .appendTo(this.wrapper)
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass("ui-corner-all")
                    .addClass("custom-combobox-toggle ui-corner-right")
                    .mousedown(function() {
                        wasOpen = input.autocomplete("widget").is(":visible");
                    })
                    .click(function() {
                        input.focus();
// Close if already visible
                        if (wasOpen) {
                            return;
                        }
// Pass empty string as value to search for, displaying all results
                        input.autocomplete("search", "");
                    });
        },
        _source: function(request, response) {
            var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
            response(this.element.children("option").map(function() {
                var text = $(this).text();
                if (this.value && (!request.term || matcher.test(text)))
                    return {
                        label: text,
                        value: text,
                        option: this
                    };
            }));
        },
        _removeIfInvalid: function(event, ui) {
// Selected an item, nothing to do
            if (ui.item) {
                return;
            }
// Search for a match (case-insensitive)
            var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
            this.element.children("option").each(function() {
                if ($(this).text().toLowerCase() === valueLowerCase) {
                    this.selected = valid = true;
                    return false;
                }
            });
// Found a match, nothing to do
            if (valid) {
                return;
            }
// Remove invalid value
            this.input
                    .val("")
                    .attr("title", value + " didn't match any item")
                    .tooltip("open");
            this.element.val("");
            this._delay(function() {
                this.input.tooltip("close").attr("title", "");
            }, 2500);
            this.input.data("ui-autocomplete").term = "";
        },
        _destroy: function() {
            this.wrapper.remove();
            this.element.show();
        }
    });
})(jQuery);



$("#dtCalFormReset").click(function(event) {
    //alert("reset event");
    /* stop link from navigationg normally */
    event.preventDefault();

    /*clear result div*/
    $("#results").html("Select required values and click calculate to view the results.");

    /* reset the form: */
    //var val = $('#dtCalForm').reset();
    $('#dtCalForm').trigger("reset");
});
