<div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color">
							<div class="box-title">
								<h3>
									<i class="glyphicon glyphicon-pencil"></i>Translate Your Sentence</h3>
							</div>
							<div class="box-content nopadding">
								<form id="form_sentence_translate" class='form-horizontal form-bordered'>
									<div class="form-group">
										<label for="sentence_from" class="control-label col-sm-2">Language From</label>
										<div class="col-sm-5">
											<select name="sentence_from" id="sentence_from" class="form-control" data-rule-required="true">
												<option value="" disabled="">-- Please select --</option>
												<?php
												foreach ($language_content as $rows)
												{
												?><
												<option value="<?=$rows->id?>"><?=$rows->name?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<label for="sentence_to" class="control-label col-sm-2">Language To</label>
										<div class="col-sm-5">
											<select name="sentence_to" id="sentence_to" class="form-control" data-rule-required="true">
												<option value="" disabled="">-- Please select --</option>
												<?php
												foreach ($language_content as $rows)
												{
												?><
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
													<textarea name="sentence" id="sentence" rows="7"  data-rule-minlength="3"  data-rule-maxlength="140" placeholder="e.g.  Can't you see I'm easily bothered by persistence One step from lashing out at you by Walk - Pantera" class="form-control" data-rule-required="true"></textarea>
												<div class="pull-right" id="count"></div>
										</div>
									</div>
									<div class="form-actions col-sm-offset-2 col-sm-10">
										<input type="button" id="submit" name="submit" class="btn btn-primary" value="Translate Sentence">
										<input type="button" id="reset" name="reset" class="btn col-sm-offset-2" value="Retype Sentence">
										<button type="button" id="error" name="error" class="btn btn-danger btn-sm noty-runner" data-layout="topCenter" data-type="error"><i class="icon-play3 position-right"></i></button>
										<button type="button" class="btn btn-default btn-sm" id="word_translated"><i class="icon-play3 position-right"></i></button>
										 <input type="hidden" id="<?=$this->session->userdata("smt_csrf_token")?>" name="<?=$this->session->userdata("smt_csrf_token")?>" value="<?=$this->session->userdata("smt_csrf_hash")?>">
									</div>
									</div>
								</form>
							</div>
							<div class="col-sm-6" id="show_translation">
						<div class="box box-color green box-small box-bordered col-sm-offset-6">
							<div class="box-title">
								<h3>
									<i class="fa fa-bars"></i>
									Small widget
								</h3>
								<div class="actions">
									<a href="#" class="btn btn-mini content-slideUp">
										<i class="fa fa-angle-down"></i>
									</a>
								</div>
							</div>
							<div class="box-content" id="translation">
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>







				<script type="text/javascript">
				var max = 140;
				$("#sentence").keyup(function(e)
				{
					var sentence_textarea = $(this).val();
					$("#count").text("Remaining characters: " + (max - $(this).val().length));

					 if (sentence_textarea.length > max)
					 {
					 	$('#submit').addClass('btn btn-danger');
        				$('#submit').attr('disabled', 'disabled');
    				 }
    				 else
    				 {
    				 	 $("#submit").removeClass("btn btn-danger").addClass('btn btn-primary');;
        				 $('#submit').removeAttr('disabled');
    				 }

				});

				$("#reset").click(function() 
				{
    				$(this).closest('form').find("textarea").val("");
				});


				$(document).ready(function ()
    			{
    				$("#show_translation").hide();
    				$("#word_translated").hide();
    				$("#error").hide();

    				$("#submit").click(function ()
    				{
    					$sentence_from = parseInt($("#sentence_from").val(), 10);	
    					$sentence_to = parseInt($("#sentence_to").val(), 10);	
    					$path = "api/MemoryService/translate/format/json";

    					if($sentence_from == $sentence_to)
    					{
    						$("#submit").hide();
    						$("#reset").hide();

    						$("#sentence_from").attr('disabled','disabled');
    						$("#sentence_to").attr('disabled','disabled');
    						$("#sentence").attr('disabled','disabled');

    						$("#error").trigger("click");
    						setTimeout("location.reload(true);",3000);
    					}
    					else
    					{	
    							$('#translation').empty();
         						$.ajax({ 
            					type: "POST",
            					data: $('#form_sentence_translate').serialize(),
             					dataType :"json",
             					url: $path,
             					success: function(data,xhr)
             					{
             						$("#show_translation").show();
             						$('#translation').append("<h4>"+data.translation+"</h4>");
             						$('#show_translation').show(0).delay(5000).hide(0);
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
             						}
             						//$("#word_translated").trigger("click");
                    				
                				} 
         						});
    					}
           			    return false;
        			});
    			});
				</script>