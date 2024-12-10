/**
 * JavaScript for form editing recompletion conditions.
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
 */
M.availability_enrol.form.initInner = function() {
    // Nothing to initialize
};

M.availability_recompletion.form.getNode = function(json) {

    //var html = '<label>' + M.util.get_string('title', 'availability_recompletion') + '</label>';
    var html = '<label>' +  M.util.get_string('short_description', 'availability_recompletion')  + '</label>';
    var node = Y.Node.create(html);

    return node;
    // Create HTML structure.
};

M.availability_recompletion.form.fillValue = function(value, node) {
    // No fills
};

M.availability_recompletion.form.fillErrors = function(errors, node) {

    // todo add error
    /*
    // Check recompletion item id.
    if (...) {
        errors.push('availability_recompletion:error_selectrecompletion');
    }
    */
};
