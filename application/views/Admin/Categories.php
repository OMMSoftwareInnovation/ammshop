<?php if(!empty($Category)){
                                        foreach($Category as $category){?>
                                        <tr>
                                            <td><?php echo $category->catname;?></td>
                                            <td><img name="Image" height="50" width="50" src="<?php echo base_url().$category->catimage;?>"></td>
                                            <td><input id="catid" type="hidden" value="<?php echo $category->catid;?>">
                                            <a class="Edit" href="#" title="Edit" data-toggle="modal" data-target="#smallModal"><i class="material-icons">mode_edit</i></a>
                                            <a class="Delete" href="#" title="Delete"><i class="material-icons">delete_forever</i></a></td>
                                        </tr><?php }}?>

                                        <script>
            $(document).ready(function($){
                $('.Delete').on('click',function(){
                    var id=$(this).parent().find('#catid').val();
                    var form=$('#CatDetails');
                    $.ajax({
                    url: "<?php echo base_url();?>Admin/DeleteCategory",
                    method:"post",
                    data: {'catid' : id},
                    success: function(result)
                    {
                        //console.log(result);
                         $(form).fadeOut(800, function(){
                            form.html(result).fadeIn().delay(2000);
                        });
                           //$('#items').html(result); 
                    },
                    error: function()
                    {
                        alert("This Category is in Use So you can't Delete it");
                    }
                });
            });
            $('.Edit').on('click',function(){
                var id=$(this).parent().find('#catid').val();
                var catname=$(this).parent().find('#catname').val();
                var catimage=$(this).parent().find('#catimage').val();

                $('.formedit input#Name').val(catname);
                $('.formedit img#catimg').attr('src',catimage);
                $('.formedit input#catid').val(id);
            });
        });
        </script>