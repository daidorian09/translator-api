
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1>SMT App</h1>
					</div>
					<div class="pull-right">
						<ul class="stats">
							<li class='satgreen'>
								<i class="glyphicon glyphicon-ok"></i>
								<div class="details">
										<span>Translated Sentences</span>
										<span class="big pull-right"><?=$count_translated_sentences?></span>
								</div>
							</li>
							<li class='lightred'>
								<i class="glyphicon glyphicon-globe"></i>
								<div class="details">
									<span>Avaliable Languages</span>
									<span class="big pull-right"><?=$count_languages?>
									
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="fa fa-bars"></i>
									Index
								</h3>
							</div>
							<div class="box-content">
								Overview
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-color box-bordered lightblue">
							<div class="box-title">
								<h3>
									<i class="fa fa-check"></i>Translated Sentence Examples</h3>
								<div class="actions">
									<a href="Pages/TranslateSentence" data-toggle="modal" class='btn btn--icon'>
										<i class="fa fa-plus-circle"></i>Translate Sentence</a>
								</div>
							</div>
							<div class="box-content nopadding">
								<ul class="tasklist">
								<?php
								foreach ($translated_sentences as $rows)
								{
								?>
									<li>
										<div class="check">
											<input type="checkbox" class='icheck-me' data-skin="square" data-color="blue">
										</div>
										<span class="task">
											<i class="fa fa-edit"></i>
											<span><?=$rows->sentence?> | <?=$rows->sentence_translated?></span>
										</span>
										<span class="task-actions">
											<a href="#" class='task-delete' rel="tooltip" title="Delete that sentence">
												<i class="fa fa-times"></i>
											</a>
											<a href="#" class='task-bookmark' rel="tooltip" title="Like that sentence">
												<i class="fa fa-bookmark-o"></i>
											</a>
										</span>
									</li>
								<?php
								}
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


					<script type="text/javascript">
						

/*function randomFeed() {
    var $el = $("#xhamster");
    var random = new Array('<span class="label label-default"><i class="fa fa-plus-square"></i></span> <a href="#">John Doe</a> added a new photo', '<span class="label label-success"><i class="fa fa-user"></i></span> New user registered', '<span class="label label-info"><i class="fa fa-shopping-cart"></i></span> New order received', '<span class="label label-warning"><i class="fa fa-comment"></i></span> <a href="#">John Doe</a> commented on <a href="#">News #123</a>'),
        auto = $el.parents(".box").find(".box-title .actions .custom-checkbox").hasClass("checkbox-active");
    var randomIndex = Math.floor(Math.random() * 4);
    var newElement = random[randomIndex];
    if (auto) {
        $el.prepend("<tr><td>" + newElement + "</td></tr>").find("tr").first().hide();
        $el.find("tr").first().fadeIn();
        if ($el.find("tbody tr").length > 20) {
            $el.find("tbody tr").last().fadeOut(400, function() {
                $(this).remove();
            });
        }
    }

    slimScrollUpdate($el.parents(".scrollable"));

    setTimeout(function() {
        randomFeed();
    }, 3000);
}*/




					</script>