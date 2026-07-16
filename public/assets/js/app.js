$("#gerberForm").submit(function(e){

    let file = $("#gerber")[0].files[0];

    $("#error").text("");

    if(!file){
        e.preventDefault();
        $("#error").text("Please upload ZIP file");
        return;
    }

    if(!file.name.toLowerCase().endsWith(".zip")){
        e.preventDefault();
        $("#error").text("Only ZIP file allowed");
        return;
    }

    if(file.size > 1 * 1024 * 1024){
        e.preventDefault();
        $("#error").text("File size must be less than 1 MB");
        return;
    }


    $("#submitBtn")
        .prop("disabled", true)
        .text("Processing...");

});