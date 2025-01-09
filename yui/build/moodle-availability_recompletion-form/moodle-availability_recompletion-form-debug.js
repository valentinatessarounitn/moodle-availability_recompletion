YUI.add('moodle-availability_recompletion-form', function (Y, NAME) {

    /**
     * JavaScript for form editing other completion conditions.
     *
     * @module moodle-availability_recompletion-form
     */
    M.availability_recompletion = M.availability_recompletion || {};
    
    /**
     * @class M.availability_recompletion.form
     * @extends M.core_availability.plugin
     */
    M.availability_recompletion.form = Y.Object(M.core_availability.plugin);
    
    /**
     * Initialises this plugin.
     *
     * @method initInner
     * @param {Array} datcms Array of objects containing cmid => name
     */
    M.availability_recompletion.form.initInner = function(datcms) {
        this.datcms = datcms;
    };
    
    M.availability_recompletion.form.getNode = function(json) {
        // Create HTML structure.
        var html =  '<span class="col-form-label p-r-1"> ' + M.util.get_string('title', 'availability_recompletion') + ' </span>' +
                    '<span class="availability-group form-group"><label>' +
                    M.util.get_string('label_start', 'availability_recompletion') +
                    ' <select class="custom-select" name="cm" style="margin-left:10px;margin-right:10px">' +
                    '<option value="0">' + M.util.get_string('choosedots', 'moodle') + '</option>';
        for (var i = 0; i < this.datcms.length; i++) {
            var cm = this.datcms[i];
            // String has already been escaped using format_string.
            html += '<option value="' + cm.id + '">' + cm.name + '</option>';
        }
        html += '</select></label>'
        html += '<br/><label>' + M.util.get_string('label_end', 'availability_recompletion') + ' </label></span>';
        var node = Y.Node.create('<span class="form-inline">' + html + '</span>');
    
        // Set initial values.
        if (json.cm !== undefined &&
                node.one('select[name=cm] > option[value=' + json.cm + ']')) {
            node.one('select[name=cm]').set('value', '' + json.cm);
        }
    
        // Add event handlers (first time only).
        if (!M.availability_recompletion.form.addedEvents) {
            M.availability_recompletion.form.addedEvents = true;
            var root = Y.one('.availability-field');
            root.delegate('change', function() {
                // Whichever dropdown changed, just update the form.
                M.core_availability.form.update();
            }, '.availability_recompletion select');
        }
    
        return node;
    };
    
    M.availability_recompletion.form.fillValue = function(value, node) {
        value.cm = parseInt(node.one('select[name=cm]').get('value'), 10);
    };
    
    M.availability_recompletion.form.fillErrors = function(errors, node) {
        var cmid = parseInt(node.one('select[name=cm]').get('value'), 10);
        if (cmid === 0) {
            errors.push('availability_recompletion:error_selectcmid');
        }
    };
    
    
    }, '@VERSION@', {"requires": ["base", "node", "event", "moodle-core_availability-form"]});
    