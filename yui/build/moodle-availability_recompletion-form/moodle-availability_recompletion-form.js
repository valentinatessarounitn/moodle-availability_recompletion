YUI.add('moodle-availability_recompletion-form', function (Y, NAME) {

    /**
     * JavaScript for form editing group conditions.
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
     * Groups available for selection (alphabetical order).
     *
     * @property groups
     * @type Array
     */
    M.availability_recompletion.form.groups = null;
    
    /**
     * Initialises this plugin.
     *
     * @method initInner
     */
    M.availability_recompletion.form.initInner = function() {
      // nothing to initialize
    };
    
    M.availability_recompletion.form.getNode = function(json) {
        // Create HTML structure.

        var description = M.util.get_string('short_description', 'availability_recompletion');
        var html = '<span class="form-inline"><label><span class="p-r-1">'+ description + ' </span></label></span>';
        var node = Y.Node.create(html); 
        return node;
    };
    
    M.availability_recompletion.form.fillValue = function(value, node) {
        // no fills
    };
    
    M.availability_recompletion.form.fillErrors = function(errors, node) {
    // no errors possible
    };
    
    
    }, '@VERSION@', {"requires": ["base", "node", "event", "moodle-core_availability-form"]});