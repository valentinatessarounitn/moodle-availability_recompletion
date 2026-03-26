YUI.add('moodle-availability_recompletion-form', function (Y, NAME) {

/**
 * JavaScript for form editing completion conditions.
 *
 * @module moodle-availability_recompletion-form
 */
M.availability_recompletion = M.availability_recompletion || {}; // eslint-disable-line camelcase

/**
 * @class M.availability_recompletion.form
 * @extends M.core_availability.plugin
 */
M.availability_recompletion.form = Y.Object(M.core_availability.plugin);

/**
 * Initialises this plugin.
 *
 * @method initInner
 * @param {Array} cms Array of objects containing cmid => name
 */
M.availability_recompletion.form.initInner = function(cms) {
    this.cms = cms;
};

M.availability_recompletion.form.getNode = function(json) {
    // Create HTML structure.
    var html = '<span class="col-form-label p-r-1">' + M.util.get_string('title', 'availability_recompletion') + '</span><br/>' +
    '<label>' + M.util.get_string('label', 'availability_recompletion') +
    ' <select class="custom-select" name="cm" style="margin-right:20px">' +
    '<option value="0">' + M.util.get_string('choosedots', 'moodle') + '</option>';
    for (var i = 0; i < this.cms.length; i++) {
        var cm = this.cms[i];
        // String has already been escaped using format_string.
        html += '<option value="' + cm.id + '">' + cm.name + '</option>';
    }

    html += '</select></label></span>';
    var node = Y.Node.create('<div class="d-inline-block form-inline">' + html + '</div>');

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
