window.onload = function () {
    var validEle = document.getElementById("pristine-valid");

    if (validEle != undefined) {

        $(document).on('submit','#pristine-valid',function (e){
            var t = new Pristine(validEle);
            if (!t.validate()) {
                e.preventDefault();
                $('.has-danger:first .form-control').focus();
            }else{
                $(document).find('body').css('pointer-events','none');
                $(document).find('body').css('overflow','hidden');
                $(document).find('.pace').toggleClass('pace-active pace-inactive');
            }
        });
    }

};

function NumberValidate(e) {
    var keyCode = e.keyCode || e.which;
    var regex = /^[0-9]+$/;
    var isValid = regex.test(String.fromCharCode(keyCode));
    return isValid;
}
