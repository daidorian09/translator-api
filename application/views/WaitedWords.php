<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="glyphicon glyphicon-search"></i>
									Search Your Waited Words
								</h3>
							</div>
							<div class="box-content">
								<form  class='form-horizontal form-validate' id="waited_words_search">
									
									<div class="form-group">
										<label for="textfield" class="control-label col-sm-2">Language From</label>
										<div class="col-sm-10">
											<select name="language_from" id="language_from" class="form-control" data-rule-required="true">
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
										<label for="textfield" class="control-label col-sm-2">Language To</label>
										<div class="col-sm-10">
											<select name="language_to" id="language_to" class="form-control" data-rule-required="true">
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

								

									<div class="form-actions col-md-offset-5">
										<label for="word" class="control-label col-sm-2"></label>
										<div class="col-md-8">
										<input type="submit" id="submit" name="submit" class="btn btn-primary" value="Search Words">
										<button type="button" id="error" name="error" class="btn btn-danger btn-sm noty-runner" data-layout="topCenter" data-type="error">Launch <i class="icon-play3 position-right"></i></button>
										 <input type="hidden" id="<?=$this->session->userdata("smt_csrf_token")?>" name="<?=$this->session->userdata("smt_csrf_token")?>" value="<?=$this->session->userdata("smt_csrf_hash")?>">
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>


<div class="row" id="waited_table">
					<div class="col-sm-12">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-table"></i>
									Waited Words
								</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-nomargin">
									<thead>
										<tr>
											<th>Waited Word</th>
											<th>Definiton</th>
										</tr>
									</thead>
									<tbody id="watited_words">
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<script type="text/javascript">
				$(document).ready(function ()
    			{

    				$("#waited_table").hide();
    				$("#error").hide();

    				$("#submit").click(function ()
    				{
    					$language_from = parseInt($("#language_from").val(), 10);	
    					$language_to = parseInt($("#language_to").val(), 10);	
    					$path = "api/MemoryService/waited/format/json";

    					if($language_from == $language_to)
    					{
    						$("#submit").hide();
    						$("#language_from").attr('disabled','disabled');
    						$("#language_to").attr('disabled','disabled');

    						$("#error").trigger("click");
    						setTimeout("location.reload(true);",3000);
    					}
    					else
    					{
    							$("#waited_table tbody").empty();
         						$.ajax({ 
            					type: "GET",
            					data: $('#waited_words_search').serialize(),
             					dataType :"json",
             					url: $path,
             					success: function(data,xhr)
             					{
             						 var fillWaitedTable = '';
             						$.each(data, function(index) 
             						{
             							fillWaitedTable += '<tr style="background-color:#e63a3a; color:#FFF; font-size:15px;" ><td>' + data[index].untranslated + '</td><td>' + data[index].message + '</td></tr>';
        							});
        							$("#waited_table").show();
        							$('#watited_words').append(fillWaitedTable);
             					},
             					error: function(xhr, textStatus, errorThrown) 
             					{ 
                    				console.log("Status: " + xhr); 
                    				console.log("Error: " + errorThrown);
                				} 
         						});
    					}
           			    return false;
        			});
    			});

    			</script>