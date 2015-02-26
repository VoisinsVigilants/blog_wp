jQuery(document).ready(function($){
	/**
	 * Ace editor
	 */
	var editor = ace.edit("ace-editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/css");
    editor.getSession().on('change', function(e) {
    	var code = editor.getSession().getValue();

    	jQuery("#ace_editor_value").val(code);        
        preview_button();
	});

    /**
     * Select2
     */
	function format(state) {
        if (!state.id) return state.text; // optgroup

        var name_select = state.id.toLowerCase();
        var name_select_array = name_select.split('-premium');

        if(name_select_array[1] == 'true')
        {
            var button = ecae_button_premium_dir_name + name_select_array[0];
        }
        else
        {
            var button = ecae_button_dir_name + name_select_array[0];
        }

        return "<div><img class='images' src='" + button + ".png'/></div>" + "<p>" + state.text + "</p>";
    }
    $("select[name='tonjoo_ecae_options[button_skin]']").select2({
        formatResult: format,
        formatSelection: format,
        escapeMarkup: function(m) { return m; }
    }).on("change", function(e) {
            preview_button(); 
    });

    /**
     * Readmore preview in options
     */
    $("input[name='tonjoo_ecae_options[read_more]']").on('keyup',function(){
        preview_button(); 
    })
    $("input[name='tonjoo_ecae_options[read_more_text_before]']").on('keyup',function(){
        preview_button(); 
    })
    $("select[name='tonjoo_ecae_options[read_more_align]']").on('change',function(){
        preview_button(); 
    })
    $("select[name='tonjoo_ecae_options[button_font]']").on('change',function(){
        if(ecae_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_ecae_options[button_font]']").val('Open Sans');
        }
        else
        {
            preview_button(); 
        }
    })
    $("input[name='tonjoo_ecae_options[button_font_size]']").on('keyup mouseup',function(){
        if(ecae_premium_enable == false)
        {
            alert('Please purchase the premium edition to enable this feature');
            $("input[name='tonjoo_ecae_options[button_font_size]']").val('14');
        }
        else
        {
            preview_button(); 
        }
    })
    $("select[name='tonjoo_ecae_options[excerpt_method]']").on('change',function(){
        if(ecae_premium_enable == false && $(this).val() != 'paragraph' && $(this).val() != 'word')
        {
            alert('The excerpt method below is only enable in premium edition. Please purchase the premium edition to enable this feature \n\n+ Show First Paragraph \n+ Show 1st - 2nd Paragraph \n+ Show 1st - 3rd');
            $("select[name='tonjoo_ecae_options[excerpt_method]']").val('paragraph');
        }
    })

    function preview_button()
    {
        var button_skin = $("select[name='tonjoo_ecae_options[button_skin]']").val();
        var lasSubstring = button_skin.substr(button_skin.length - 12);

        if(ecae_premium_enable == false && lasSubstring == "-PREMIUMtrue")
        {
            alert('Please purchase the premium edition to enable this feature');
            $("select[name='tonjoo_ecae_options[button_skin]']").select2("val", "ecae-buttonskin-none");

            button_skin = "ecae-buttonskin-none";
        }
        
        data = {
            action: 'ecae_preview_button',
            read_more: $("input[name='tonjoo_ecae_options[read_more]']").val(),
            read_more_text_before: $("input[name='tonjoo_ecae_options[read_more_text_before]']").val(),
            read_more_align: $("select[name='tonjoo_ecae_options[read_more_align]']").val(),
            button_font: $("select[name='tonjoo_ecae_options[button_font]']").val(),
            button_font_size: $("input[name='tonjoo_ecae_options[button_font_size]']").val(),
            button_skin: button_skin,
            custom_css: editor.getSession().getValue()
        }

        // $('#ecae_ajax_preview_button').html("<img src='" + ecae_dir_name + "/assets/loading.gif'>");

        $.post(ajaxurl, data,function(response){
            $('#ecae_ajax_preview_button').html(response);
        });
    }

    /**
     * Run on start
     */
    preview_button();
});