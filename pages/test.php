<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">

        $('#sessionlist').html('');  
            $.ajax({  
                type: 'GET',
                url: './proc/getActiveSession_proc.php', 
                data: { 
                    dummy:1

                },
                success: function(data) {

                	console.log(data);
                	var obj = $.parseJSON(data);
			        for(var i = 0; i < obj.length; i++) {
			            console.log(obj[i]);
			        }
                }
        });


</script>