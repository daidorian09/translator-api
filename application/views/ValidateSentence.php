<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3>
									<i class="glyphicon glyphicon-search"></i>Sentence Validation</h3>
							</div>
							<div class="box-content nopadding">
								<form id="validate_sentence" class='form-horizontal form-validate' name="validate_sentence" class='form-horizontal form-bordered'>
									<div class="form-group" style="margin-top: 15px;">
										<label for="textfield" class="control-label col-sm-2">Sentence From</label>
										<div class="col-sm-5">
											<select name="sentence_from" id="sentence_from" class="form-control" data-rule-required="true">
												<option value="" disabled="">-- Please select --</option>
												<?php
												foreach ($language_content as $rows)
												{
												?>
												<option value="<?=$rows->id?>"><?=$rows->name?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="password" class="control-label col-sm-2">Sentence To</label>
										<div class="col-sm-5">
											<select name="sentence_to" id="sentence_to" class="form-control" data-rule-required="true">
												<option value="" disabled="">-- Please select --</option>
												<?php
												foreach ($language_content as $rows)
												{
												?>
												<option value="<?=$rows->id?>"><?=$rows->name?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="textarea" class="control-label col-sm-2">Type Your Sentence</label>
										<div class="col-sm-5">
											<textarea name="sentence" id="sentence" rows="7"  data-rule-minlength="3"  data-rule-maxlength="140" placeholder="e.g.  I suppose you are searching for something" class="form-control" data-rule-required="true"></textarea>
										<div class="pull-right" id="count"></div>
										</div>
									</div>
									
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="button" id="search" name="search" class="btn btn-primary" value="Search Sentence">
										<input type="button" id="reset" name="reset" class="btn" value="Retype Your Sentence">
										<button type="button" id="error" name="error" class="btn btn-danger btn-sm noty-runner" data-layout="topCenter" data-type="error"><i class="icon-play3 position-right"></i></button>
										<button type="button" class="btn btn-default btn-sm" id="word_translated">Launch <i class="icon-play3 position-right"></i></button>
										 <input type="hidden" id="<?=$this->session->userdata("smt_csrf_token")?>" name="<?=$this->session->userdata("smt_csrf_token")?>" value="<?=$this->session->userdata("smt_csrf_hash")?>">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>


  <div id="success" class="alert alert-success alert-dismissable" style="display: none;">
											<button type="button" class="close" data-dismiss="alert">×</button>
										</div>

				<script type="text/javascript">

				var max = 140;
				$("#sentence").keyup(function(e)
				{
					$("#count").text("Remaining characters: " + (max - $(this).val().length));
					var sentence_text = $(this).val();
						$("#count").text("Remaining characters: " + (max - $(this).val().length));
					 if (sentence_text.length > max)
					 {
					 	$('#search').addClass('btn btn-danger');
        				$('#search').attr('disabled', 'disabled');
    				 }
    				 else
    				 {
    				 	 $("#search").removeClass("btn btn-danger").addClass('btn btn-primary');;
        				 $('#search').removeAttr('disabled');
    				 }
				});

				$("#reset").click(function() 
				{
    				$(this).closest('form').find("textarea").val("");
				});


				$(document).ready(function ()
    			{
    				$("#word_translated").hide();
    				$("#translate_required").hide();
    				$("#error").hide();
    				$("#search").click(function ()
    				{
    					$language_from = parseInt($("#sentence_from").val(), 10);	
    					$language_to = parseInt($("#sentence_to").val(), 10);	
    					$path = "api/MemoryService/value/format/json";

    					if($language_from == $language_to)
    					{
    						$("#search").hide();
    						$("#sentence_from").attr('disabled','disabled');
    						$("#sentence_to").attr('disabled','disabled');
    						$("#sentence").attr('disabled','disabled');

    							$("#error").trigger("click");
    							setTimeout("location.reload(true);",3000);
    					}
    					else
    					{
         						$.ajax({ 
            					type: "POST",
            					data: $('#validate_sentence').serialize(),
             					dataType :"json",
             					url: $path,
             					success: function(data,xhr)
             					{
             						$('#success').append("<h4 class='col-md-offset-3'><strong>"+data.message+"</strong></h4>").show();
             						$('#success').show(0).delay(5000).hide(0);
             					},
             					error: function(xhr, textStatus, errorThrown) 
             					{ 
             						switch(xhr.status)
             						{
             							case 403:
             							{
             								console.log("Status: " + textStatus); 
                    						console.log("Error: " + errorThrown); 
             								break;
             							}
             							case 409:
             							{
             								$("#word_translated").trigger("click");
             								break;
                    					}
                    					case 500:
                    					{
                    						console.log("Status: " + textStatus); 
                    						console.log("Error: " + errorThrown); 
             								break;
                    					}
             						}       	
                				} 
         						});
    					}
           			    return false;
        			});
    			});



				</script>