$(document).ready(function (e) {

});
$(function() {
    $(document).on('keypress', '.start_no_space', function(e) {
        if (e.which == 32) {
            return false;
        }
    });
    $(document).on('click', '[data-delete]', function() {
        var ele_sele = $(this).data('delete')
        $(document).find(ele_sele).trigger('submit');
    });

    $(document).on('change', '.my-preview', function() {
        previewSelectedFile(this);
    });

});

function previewSelectedFile(input) {
    var previewattr = $(input).data('preview');
    var preview = $(document).find(previewattr)
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
        preview.show();
        $(document).find(previewattr + "-default").hide();
    }
}

function check_permission($element) {
    var checked = $($element).prop('checked');
    var value = $($element).val();

    if (checked) {
        if (value == "add restaurants" || value == "edit restaurants" || value == "delete restaurants") {
            $('#restaurant_show').prop('checked', true);
        }

        if (value == "add category" || value == "edit category" || value == "delete category") {
            $('#category_show').prop('checked', true);
        }

        if (value == "add food" || value == "edit food" || value == "delete food") {
            $('#food_show').prop('checked', true);
        }

        if (value == "add staff" || value == "edit staff" || value == "delete staff") {
            $('#staff_show').prop('checked', true);
        }


        if (value == "add tables" || value == "edit tables" || value == "delete tables") {
            $('#tables_show').prop('checked', true);
        }


    } else {
        if (value == "show restaurants") {
            $('#restaurant_add').prop('checked', false);
            $('#restaurant_edit').prop('checked', false);
            $('#restaurant_delete').prop('checked', false);
        }

        if (value == "show category") {
            $('#category_add').prop('checked', false);
            $('#category_edit').prop('checked', false);
            $('#category_delete').prop('checked', false);
        }

        if (value == "show food") {
            $('#food_add').prop('checked', false);
            $('#food_edit').prop('checked', false);
            $('#food_delete').prop('checked', false);
        }

        if (value == "show staff") {
            $('#staff_add').prop('checked', false);
            $('#staff_edit').prop('checked', false);
            $('#staff_delete').prop('checked', false);
        }

        if (value == "show tables") {
            $('#tables_add').prop('checked', false);
            $('#tables_edit').prop('checked', false);
            $('#tables_delete').prop('checked', false);
        }
    }


}

function show_payment_section($element) {

    $("#offline_payment_section").addClass("d-none");
    $("#stripe_payment_section").addClass("d-none");
    $("#paypal_payment_section").addClass("d-none");
    $("#paytm_payment_section").addClass("d-none");

    let value = $($element).val();

    if (value == "offline") {

        $("#reference").attr('required',true);
        $("#offline_payment_section").removeClass("d-none");

    } else if (value == "paypal") {

        $("#paypal_payment_section").removeClass("d-none");

    } else if (value == "stripe") {

        $("#stripe_payment_section").removeClass("d-none");

    }
    else if (value == "paytm") {

        $("#paytm_payment_section").removeClass("d-none");

    }
}

function is_default_img($this) {
    let element = $($this);
    var hide_section = $(element.data("section"));
    var input = $(element.data("input"));
    var image_exist = $($this).data("imageexist");

    if(element.is(':checked')){
        input.prop('required',false);
        hide_section.addClass('d-none');
    }else{
        if (image_exist==0){
            input.prop('required',true);
        }
        hide_section.removeClass('d-none');
    }
}


function createSlug($this) {
    var title = $($this).val();
    if(title!=""){
        var slug = title.toLowerCase().trim().replace(/ /g,'-').replace(/[-]+/g, '-').replace(/[^\w-]+/g,'');
        $("#input-restaurant_slug").val(slug);
    }
}

function show_rightbar_section($element){
    let id=$($element).data('id');
    let url=$($element).data('url');
    let action=$($element).data('action');

    $.ajax({
        type:'GET',
        url:url,
        data:{
            id:id,
            action:action
        },
        success:function(data) {
            if (data!=""){
                $("#system_right_bar_content").html(data);
                $("body").toggleClass("right-bar-enabled");
            }
        }
    });
}

function closeSidebar(){
    $("body").removeClass("right-bar-enabled");
}
