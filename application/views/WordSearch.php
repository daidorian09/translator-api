<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="glyphicon glyphicon-search"></i>
									Search Your Sentence
								</h3>
							</div>
							<div class="box-content">
								<form  class='form-horizontal form-validate' id="word_search">
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Sentence From</label>
										<div class="col-sm-10">
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
										<label for="textfield" class="control-label col-sm-2">Sentence To</label>
										<div class="col-sm-10">
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
										<label for="word" class="control-label col-sm-2">Type your sentence</label>
										<div class="col-sm-10">
											<input type="text" name="sentence" id="sentence" class="form-control" placeholder="e.g Have a nice day" data-rule-required="true" data-rule-minlength="3"  data-rule-maxlength="140">
											<div class="pull-right" id="count"></div>
										</div>

									</div>
									<div class="form-actions col-md-offset-5">
										<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Search Sentence Words">
										<input type="button" id="reset" name="reset" class="btn" value="Retype Sentence">
										<button type="button" id="error" name="error" class="btn btn-danger btn-sm noty-runner" data-layout="topCenter" data-type="error"><i class="icon-play3 position-right"></i></button>
										 <input type="hidden" id="<?=$this->session->userdata("smt_csrf_token")?>" name="<?=$this->session->userdata("smt_csrf_token")?>" value="<?=$this->session->userdata("smt_csrf_hash")?>">
									</div>
										
								</form>
							</div>
						</div>
					</div>
				</div>



		<div class="row" id="words_table">
					<div class="col-sm-12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-table"></i>
									Translated Words
								</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-nomargin">
									<thead>
										<tr>
											<th>Translated Words</th>
											<th>Definiton</th>
										</tr>
									</thead>
									<tbody id="found_words">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
	



				<script type="text/javascript">

				$(document).ready(function ()
    			{
    				var max = 140;
					$("#sentence").keyup(function(e)
					{
						var sentence_text = $(this).val();
						$("#count").text("Remaining characters: " + (max - $(this).val().length));
					 if (sentence_text.length > max)
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
    				$(this).closest('form').find("input:text").val("");
				});

    				$("#words_table").hide();
    				$("#error").hide();

    				$("#submit").click(function ()
    				{
    					$sentence_from = parseInt($("#sentence_from").val(), 10);	
    					$sentence_to = parseInt($("#sentence_to").val(), 10);	
    					$sentence = $("#sentence").val();

    					$path = "api/MemoryService/value/format/json";
    					if($sentence_from == $sentence_to)
    					{
    						$("#submit").hide();
    						$("#sentence_from").attr('disabled','disabled');
    						$("#sentence_to").attr('disabled','disabled');
    						$("#sentence").attr('disabled','disabled');

    						$("#error").trigger("click");
    						setTimeout("location.reload(true);",3000);
    					}
    					else
    					{
    							$("#words_table tbody").empty();
         						$.ajax({ 
            					type: "GET",
            					data: $('#word_search').serialize(),
             					dataType :"json",
             					url: $path,
             					success: function(data,xhr)
             					{
             						 var fillTable = '';
             						$.each(data, function(index) 
             						{
             							if(data[index].word_untranslated)
             							 fillTable += '<tr style="background-color:#e63a3a; color:#FFF; font-size:17px;" ><td>' + data[index].word + '</td><td>' + data[index].word + '</td></tr>';
             							 else
             							 	 fillTable += '<tr style="background-color:#56af45; color:#FFF; font-size:17px;"><td>' + data[index].word + '</td><td>' + data[index].translated_word + '</td></tr>';
             							/*if(data[index].word_untranslated)
             								 $('#error_response').append("<h4 class='col-md-offset-3'><strong>"+data[index].word+" => "+data[index].word+"</strong></h4>").show(); */
             							/*else
             								$('#success').append("<h4 class='col-md-offset-3'><strong>"+data[index].word+" => "+data[index].translated_word+"</strong></h4>").show();*/

        							});
        							$("#words_table").show();
        							$('#found_words').append(fillTable);
             					},
             					error: function(xhr, textStatus, errorThrown) 
             					{ 
                    				console.log("Status: " + textStatus); 
                    				console.log("Error: " + errorThrown); 
                				} 
         						});
    					}
           			    return false;
        			});
    			});



				</script>