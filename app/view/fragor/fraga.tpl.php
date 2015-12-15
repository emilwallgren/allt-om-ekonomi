<div class="container fragorsidan">

	<div class="row fragan">
	
		<div class="col-md-10">
			<h1><?= $fraga->titel ?></h1>
			<div class="backgroundImage" style="background: url('<?= $user->profileimage ?>') no-repeat center; background-size: contain;"></div>
			<h3>Skapad av: <a href="<?= $this->url->create('profil/anvandare') ?>/<?= $user->username ?>"><?= $user->username ?></a></h3>
			<h5><?= $fraga->created_at ?></h5>
				<p><?=$this->textFilter->doFilter($fraga->fraga, 'shortcode, markdown');?></p>
			</div>
			<div class="col-md-2">
				<a href="<?= $this->url->create('fragor/questionlike') ?>/<?= $fraga->id ?>/<?= $fraga->id ?>"><img src="<?= $this->url->create('') ?>/img/up.png" alt="upp"/></a> <h3 class="vote"><?= $fraga->fragor_votes ?></h3> <a href="<?= $this->url->create('fragor/questiondislike') ?>/<?= $fraga->id ?>/<?= $fraga->id ?>"><img src="<?= $this->url->create('') ?>/img/down.png" alt="ner"/>
				</a>
			</div>
		</div>
		
		<div class="row taggar">
			<div class="col-md-12">
			<p><b>Taggar: </b>
			<?php foreach ($taggar as $tagg) { ?>
			 <a href="<?= $this->url->create('taggar/tagg') ?>/<?= $tagg->tagg ?>" class="tagg"><?= $tagg->tagg ?></a> 
			<?php } ?>
			</p>
			</div>
		</div>
		
	
	
	
	<hr>
	
			<div class="row fraganKommentar">
			<div class="col-md-12">
				<h3>Kommentarer</h3>
			</div>
		<?php foreach ($kommentarer as $kommentar) { ?>
						<div class="col-md-12">
							<div class="comment">
								<div class="commentHeader clearfix">
									<div class="commenter">
									<div class="backgroundImage" style="background: url('<?= $kommentar->profileimage ?>') no-repeat center; background-size: contain;"></div><h5 style="padding: 0; margin: 0;">Postad av: <a href="<?= $this->url->create('profil/anvandare') ?>/<?= $kommentar->username ?>"><?= $kommentar->username ?></a></h5>
									<p><?= $kommentar->comment_created_at ?></p>
									</div>
									<div class="voteArrows">
										<a href="<?= $this->url->create('fragor/commentlike') ?>/<?= $kommentar->kommentar_id ?>/<?= $kommentar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/up.png" alt="upp"/></a> <h3 class="vote"><?= $kommentar->votes ?></h3> <a href="<?= $this->url->create('fragor/commentdislike') ?>/<?= $kommentar->kommentar_id ?>/<?= $kommentar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/down.png" alt="ner"/>
										</a>
									</div>
								</div>
						
								<div class="commentBody">
									<p><?=$this->textFilter->doFilter($kommentar->kommentar, 'shortcode, markdown');?></p>
								</div>
							</div>
						</div>
		<?php } ?>
			</div>
		
		
		<div class="row fraganKommentarForm">
			<div class="col-md-12">
				<form method="post" action="<?= $this->url->create('fragor/fraga') ?>/<?= $fraga->id ?>">
					<div class="form-group">
						<label for="kommentar">Skriv Kommentar</label>
						<textarea name="kommentar" class="form-control" style="width: 100%;"></textarea>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-default" name="postComment" />
					</div>
				</form>
			</div>
		</div>
		
		
		<hr>
		<div class="row fraganSvar">
			<div class="col-md-12">
				<h3>Svar</h3>
				<p><b>Ordna Efter:</b> <a href="<?= $this->url->create('fragor/fraga') ?>/<?= $fraga->id ?>">Tid</a> <b>eller</b> <a href="<?= $this->url->create('fragor/fraga') ?>/<?= $fraga->id ?>/1">Ranking</a></p>
			</div>
				
				<?php foreach ($allaSvar as $svar) { ?>
					<div class="col-md-12">
						<div class="answer">
							<div class="answerHeader clearfix">
								<div class="answerer">
										<div class="backgroundImage" style="background: url('<?= $svar->profileimage ?>') no-repeat center; background-size: contain;"></div><h5 style="padding: 0; margin: 0;">Postad av: <a href="<?= $this->url->create('profil/anvandare') ?>/<?= $svar->username ?>"><?= $svar->username ?></a></h5>
									<p><?= $svar->answer_created_at ?></p>
								</div>
								<div class="acceptedAndArrows">
									<div class="acceptedAnswer">
										<?php if ($fraga->anvandare_id == $anvandarID) { ?>
										
											<?php if ($svar->accepted == 0) { ?>
												<a href="<?= $this->url->create('fragor/setacceptedanswer') ?>/<?= $svar->id_svar ?>/<?= $svar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/unaccepted.png" alt="upp" style="width: 50px;"/></a> 	
											<?php } ?>
											<?php if ($svar->accepted == 1) { ?>
												<a href="<?= $this->url->create('fragor/setacceptedanswer') ?>/<?= $svar->id_svar ?>/<?= $svar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/accepted.png" alt="upp" style="width: 50px;"/></a> 	
											<?php } ?>
											
										<?php } ?>		
										
										
										<?php if ($fraga->anvandare_id !== $anvandarID) { ?>		
											<?php if ($svar->accepted == 0) { ?>
												<img src="<?= $this->url->create('') ?>/img/unaccepted.png" alt="upp" style="width: 50px;"/>
											<?php } ?>
											<?php if ($svar->accepted == 1) { ?>
												<img src="<?= $this->url->create('') ?>/img/accepted.png" alt="upp" style="width: 50px;"/>
											<?php } ?>
										<?php } ?>		
									</div>
								
									<div class="voteArrows">
										<a href="<?= $this->url->create('fragor/answerlike') ?>/<?= $svar->id_svar ?>/<?= $svar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/up.png" alt="upp" style="width: 20px;"/></a> <h3 class="vote"><?= $svar->svar_votes ?></h3> <a href="<?= $this->url->create('fragor/answerdislike') ?>/<?= $svar->id_svar ?>/<?= $svar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/down.png" alt="ner" style="width: 20px;"/>
										</a>
									</div>
								</div>
							</div>
						<div class="answerBody">
							<p><?=$this->textFilter->doFilter($svar->svar, 'shortcode, markdown');?></p>
						</div>
					</div>
				</div>
			
			
			<div class="row svarKommentar">
			<?php foreach ($kommentarerTillSvar as $svarKommentar) { ?>
				<?php if ($svar->id_svar == $svarKommentar->svar_id) { ?>
						<div class="col-md-10 col-md-offset-2">
							<div class="answerComment">
								<div class="answerCommentHeader clearfix">
									<div class="answerer">
										<div class="backgroundImage" style="background: url('<?= $svarKommentar->profileimage ?>') no-repeat center; background-size: contain;"></div><h5 style="padding: 0; margin: 0;">Postad av: <a href="<?= $this->url->create('profil/anvandare') ?>/<?= $svarKommentar->username ?>"><?= $svarKommentar->username ?></a></h5>
										<p><?= $svarKommentar->comment_created_at ?></p>
									</div>
									<div class="voteArrows">
										<a href="<?= $this->url->create('fragor/commentlike') ?>/<?= $svarKommentar->kommentar_id ?>/<?= $svarKommentar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/up.png" alt="upp"/></a> <h3 class="vote"><?= $svarKommentar->votes ?></h3> <a href="<?= $this->url->create('fragor/commentdislike') ?>/<?= $svarKommentar->kommentar_id ?>/<?= $svarKommentar->fragor_id ?>"><img src="<?= $this->url->create('') ?>/img/down.png" alt="ner"/></a>
									</div>
								</div>
		
								<div class="answerCommentBody">
								<p><?=$this->textFilter->doFilter($svarKommentar->kommentar, 'shortcode, markdown');?></p>
								</div>
								
							</div>
						</div>
			
				<?php } 
								} ?>
				</div>
				<div class="row svarKommentarForm">
					<div class="col-md-10 col-md-offset-2">
					<form method="post" action="<?= $this->url->create('fragor/fraga') ?>/<?= $fraga->id ?>">
							<input type="hidden" name="svar_id" value="<?= $svar->id_svar ?>">
							<div class="form-group">
								<label for="svarKommentar">Kommentera svar</label>
								<textarea name="svarKommentar" class="form-control" style="width: 100%;"></textarea>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-default" name="postAnswerComment" />
							</div>
					</form>
					</div>
				</div>
				
		<?php } ?>
		</div>
		<div class="row svarForm"> 
			<div class="col-md-12">
				<hr>
			<form method="post" action="<?= $this->url->create('fragor/fraga') ?>/<?= $fraga->id ?>">
				<div class="form-group">
					<label for="svar">Skriv Svar</label>
					<textarea name="svar" class="form-control" style="width: 100%;"></textarea>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-default" name="postAnswer" />
				</div>
			</form>
		</div>
	</div>
	
</div>