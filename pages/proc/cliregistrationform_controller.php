<script>

//auto age computation
$('#aabirthdate').on('change',function(e){
    $('#aaage').val(getAge($(this).val()));
});
$('#aabenebirthdate').on('change',function(e){
    $('#aabeneage').val(getAge($(this).val()));
});
$('#aadepbirthdate1').on('change',function(e){
    $('#aadepage1').val(getAge($(this).val()));
});
$('#aadepbirthdate2').on('change',function(e){
    $('#aadepage2').val(getAge($(this).val()));
});
$('#aadepbirthdate3').on('change',function(e){
    $('#aadepage3').val(getAge($(this).val()));
});
$('#aadepbirthdate4').on('change',function(e){
    $('#aadepage4').val(getAge($(this).val()));
});


function getAge(dateString) 
{
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) 
    {
        age--;
    }
    return age;
}

$('#cliregistrationform_submit').on('click', function(e) {
    e.preventDefault();

    //validate inputs

    var error_count = 0;

    //validation of required inputbox
    $('#cliregistrationformID input[type="text"]').each(function(){
        //if (this.value.match(/\D/)) // regular expression for numbers only.
            if (this.hasAttribute("required")){
              //  alert($(this).val());
                if ($(this).val().trim() == '') {
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                   $(this).closest("div").removeClass("has-error"); 
                }

            } 
    });

    //valdation of required  dropdown box
    $('#cliregistrationformID select').each(function(){
         if (this.hasAttribute("required")){
            if ($(this).val().trim()=='' || $(this).val().trim()=='Select' ){
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                   $(this).closest("div").removeClass("has-error");    
            }
         }
    });

    //validation of requried date
    $('#cliregistrationformID input[type="date"]').each(function(){
        //if (this.value.match(/\D/)) // regular expression for numbers only.
            if (this.hasAttribute("required")){

                if ($(this).val().trim()=='' || ($(this).val().trim()=='1900-01-01')){
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                   $(this).closest("div").removeClass("has-error");                       
                }

            } 
    });

    //check if age fields are greater that 140 years limit
    if ($('#aaage').val()> 140) {
         error_count+=1;
        $('#aaage').closest("div").addClass("has-error");
        $('#aabirthdate').closest("div").addClass("has-error");
        $('#aabirthdate').focus();
    }else{
         $('#aaage').closest("div").removeClass("has-error");
         $('#aabirthdate').closest("div").removeClass("has-error");
    }

    if ($('#aapayorage').val()> 140) {
         error_count+=1;
        $('#aapayorage').closest("div").addClass("has-error");
        $('#aapayorage').focus();
    }else{
         $('#aapayorage').closest("div").removeClass("has-error");
    }

    if ($('#aabeneage').val()> 140) {
         error_count+=1;
        $('#aabeneage').closest("div").addClass("has-error");
        $('#aabenebirthdate').closest("div").addClass("has-error");
        $('#aabenebirthdate').focus();
    }else{
         $('#aabeneage').closest("div").removeClass("has-error");
         $('#aabenebirthdate').closest("div").removeClass("has-error");
    }

    if ($('#aadepage1').val()> 140) {
         error_count+=1;
        $('#aadepage1').closest("div").addClass("has-error");
        $('#aadepbirthdate1').closest("div").addClass("has-error");
        $('#aadepbirthdate1').focus();
    }else{
         $('#aadepage1').closest("div").removeClass("has-error");
         $('#aadepbirthdate1').closest("div").removeClass("has-error");
    }

    if ($('#aadepage12').val()> 140) {
         error_count+=1;
        $('#aadepage1').closest("div").addClass("has-error");
        $('#aadepbirthdate2').closest("div").addClass("has-error");
        $('#aadepbirthdate2').focus();
    }else{
         $('#aadepage2').closest("div").removeClass("has-error");
         $('#aadepbirthdate2').closest("div").removeClass("has-error");
    }

    if ($('#aadepage3').val()> 140) {
         error_count+=1;
        $('#aadepage3').closest("div").addClass("has-error");
        $('#aadepbirthdate3').closest("div").addClass("has-error");
        $('#aadepbirthdate3').focus();
    }else{
         $('#aadepage3').closest("div").removeClass("has-error");
         $('#aadepbirthdate3').closest("div").removeClass("has-error");
    }

    if ($('#aadepage4').val()> 140) {
         error_count+=1;
        $('#aadepage4').closest("div").addClass("has-error");
        $('#aadepbirthdate4').closest("div").addClass("has-error");
        $('#aadepbirthdate4').focus();
    }else{
         $('#aadepage4').closest("div").removeClass("has-error");
         $('#aadepbirthdate4').closest("div").removeClass("has-error");
    }



    //number validation
    $('#cliregistrationformID input[type="text"]').each(function(){
            //check if required and numeric value
            if (this.hasAttribute("required") && this.hasAttribute("numberonly")){
              //  alert($(this).val());
                if ($(this).val().trim() == '') {
                   error_count+=1;
                   $(this).closest("div").addClass("has-error");
                   if (error_count==1) $(this).focus();
                }else{
                  
                   if ($.isNumeric($(this).val())) {
                         $(this).closest("div").removeClass("has-error"); 
                   }else{
                         error_count+=1;
                         $(this).closest("div").addClass("has-error"); 
                        if (error_count==1) $(this).focus();
                   }
                }
            }else if(this.hasAttribute("numberonly")) {
                    //check if numeric only (not required)
                   if ($.isNumeric($(this).val())) {
                         $(this).closest("div").removeClass("has-error"); 
                   }else{
                         error_count+=1;
                         $(this).closest("div").addClass("has-error"); 
                         if (error_count==1) $(this).focus();
                   }
            } 
    });

 
    if (error_count==0){
      //send POST here

        $.ajax({  
            type: 'GET',
            url: './proc/cliregistrationform_proc.php', 
            data: { 
               
                aamembercode:$('#aamembercode').val(),
                aafirstname :$('#aafirstname').val(),
                aamiddlename:$('#aamiddlename').val(),
                aasurname:$('#aasurname').val(),
                aasex:$('#aasex').val(),
                aacivilstatus:$('#aacivilstatus').val(),
                aapurok:$('#aapurok').val(),
                aabarangay:$('#aabarangay').val(),
                aamunicipality:$('#aamunicipality').val(),
                aaprovince:$('#aaprovince').val(),
                aavalidid:$('#aavalidid').val(),
                aabirthdate:$('#aabirthdate').val(),
                aaage:$('#aaage').val(),
                aabithplace:$('#aabithplace').val(),
                aaoccupation:$('#aaoccupation').val(),
                aareligion:$('#aareligion').val(),
                aapayorname:$('#aapayorname').val(),
                aapayorage:$('#aapayorage').val(),
                aapayorrelation:$('#aapayorrelation').val(),
                aapayorcontactno:$('#aapayorcontactno').val(),
                aapayorpurok:$('#aapayorpurok').val(),
                aapayorbarangay:$('#aapayorbarangay').val(),
                aapayormunicipality:$('#aapayormunicipality').val(),
                aapayorprovince:$('#aapayorprovince').val(),
                aamembercontactno:$('#aamembercontactno').val(),
                aabenename:$('#aabenename').val(),
                aabenebirthdate:$('#aabenebirthdate').val(),
                aabeneage:$('#aabeneage').val(),
                aabenerelation:$('#aabenerelation').val(),
                aabenecivilstatus:$('#aabenecivilstatus').val(),
                aabenecontactno:$('#aabenecontactno').val(),
                aadepname1:$('#aadepname1').val(),
                aadepbirthdate1:$('#aadepbirthdate1').val(),

                aadepage1:$('#aadepage1').val(),
                aadeprelationship1:$('#aadeprelationship1').val(),
                aadepcivilstatus1:$('#aadepcivilstatus1').val(),
                aadepname2:$('#aadepname2').val(),
                aadepbirthdate2:$('#aadepbirthdate2').val(),
                aadepage2:$('#aadepage2').val(),
                aadeprelationship2:$('#aadeprelationship2').val(),
                aadepcivilstatus2:$('#aadepcivilstatus2').val(),
                aadepname3:$('#aadepname3').val(),
                aadepbirthdate3:$('#aadepbirthdate3').val(),
                aadepage3:$('#aadepage3').val(),
                aadeprelationship3:$('#aadeprelationship3').val(),
                aadepcivilstatus3:$('#aadepcivilstatus3').val(),
                aadepname4:$('#aadepname4').val(),
                aadepbirthdate4:$('#aadepbirthdate4').val(),
                aadepage4:$('#aadepage4').val(),
                aadeprelationship4:$('#aadeprelationship4').val(),
                aadepcivilstatus4:$('#aadepcivilstatus4').val(),
                aaplantype:$('#aaplantype').val(),
                aaunits:$('#aaunits').val(),
                aaagent:$('#aaagent').val(),
                aainsurance:$('#aainsurance').val(),
                aamembershipdate:$('#aamembershipdate').val(),
                aaao:$('#aaao').val(),
                aabranchmanager:$('#aabranchmanager').val(),
                aaprdate:$('#aaprdate').val(),
                aaprno:$('#aaprno').val(),
                aaordate:$('#aaordate').val(),
                aaornumber:$('#aaornumber').val(),
                aaamount:$('#aaamount').val()



            },
            success: function(response) {

                 prompt(response,response);
/*
                if (response.indexOf("No Record") > -1){


                    $('#client_list_search_result').html('');
                    $("#client_not_found_box").removeClass("hidden");
                    $(".client_not_found_box_caption").html('No Necord Found!');
                    $("#client_list_search_result_count").html("0 entries found");

                }else{
                    alert(response);
                   
                     $("#client_not_found_box").addClass("hidden")
                     $('#client_list_search_result').html(response.split("|")[1]);
                     $("#client_list_search_result_count").html(response.split("|")[0] + " entries found");

                }
                //$('.clientlist_search_form').submit();
*/
            }
        });


    } //if error ==0
});







        






</script>   