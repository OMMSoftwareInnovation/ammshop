//ONLY NUMBER
$(document).on("keypress", '.only_number', function (e) {
    //e.preventDefault();   
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    //ONLY LETTERS
    $(document).on("keypress", '.only_letter', function (e) {
    //e.preventDefault();   
        //if the letter is not digit then display error and don't type anything
        if ((e.which > 47 && e.which < 58) && (e.which != 32)) {
            return false;
        }
    });