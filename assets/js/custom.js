
jQuery(document).ready(function(){
    jQuery("#dtlist").dataTable();
    jQuery('.resetdata').hide();

    jQuery( "#csvexport" ).validate();
    jQuery('#startdate').datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        autoclose: true,
        dateFormat: "yy-mm-dd",
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            jQuery("#enddate").datepicker("option", "minDate", dt);
        }

    });
    jQuery('#enddate').datepicker({
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        showButtonPanel: true,
        dateFormat: "yy-mm-dd",
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            jQuery("#startdate").datepicker("option", "maxDate", dt);
        }
    });

    jQuery('.csvdata').click( function(){
        jQuery('.resetdata').show();
        var startdate = jQuery('#startdate').val();
        var enddate = jQuery('#enddate').val();
        if((startdate == "") && (enddate == "")){
            jQuery('.errormsg').html('Please select at least start date');
            return false;
        }
        if(startdate == ""){
            jQuery('.errormsg').css('display', 'block');
            jQuery('.errormsg').html('Please select start date');
            return false;
        }
        if((startdate != "") && (enddate != "")){
            //jQuery('.errormsg').css('display', 'none');
            if( (startdate > enddate)){
                jQuery('.errormsg').html('startdate should be greater then enddate');
                return false;
            }
        }
    });
});