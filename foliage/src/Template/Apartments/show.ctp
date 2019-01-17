<?= $this->Html->css(['daterange.css']) ?>
<?= $this->Html->script(['jquery.min.js', 'moment.min.js', 'daterange.min.js', 'main.js']) ?>
<div class="container-fluid mt-4">
	<div class="row">
		<div class="col-6">
			<?= $this->Html->image('flats/'.$apartment->image, ['class' => 'img-fluid', 'style' => '']) ?>
		</div>
		<div class="col-6">
			<h5 class="font-weight-bold"><?= $apartment->Topic ?></h5>
			<div>Vermietet von <?= $this->Html->link($apartment->User->Name, ['controller' => 'users', 'action' => 'view', $apartment->User->UserID], ['class' => 'text-dark font-weight-bold']) ?> in <?= $apartment->Location ?><i class="ml-2 fas fa-map-marker-alt"></i>
			</div>
			<div class="text-warning p-1">
				<i class="fas fa-star fa-sm"></i>
                <i class="fas fa-star fa-sm"></i>
                <i class="fas fa-star fa-sm"></i>
                <i class="far fa-star fa-sm"></i>
                <i class="far fa-star fa-sm"></i>
                <span class="text-dark" style="font-size: .8rem">3/5 (18)</span>
			</div>
			
			<div class="mt-3 mb-2">
				<kbd class="bg-secondary">Dusche</kbd>
				<kbd class="bg-secondary">Internet</kbd>
				<kbd class="bg-secondary">Balkon</kbd>
				<kbd class="bg-secondary">Aufzug</kbd>
			</div>
			<div class="mt-3 pt-2 border-top">
				<h4>ab <b>€<?= $apartment->Price ?></b> pro Nacht</h4>
			</div>

			<div class="mt-3">
				<span class="text-secondary">Wann wollen Sie einreisen?</span>
				<?= $this->Form->create($apartment, ['action' => 'show', 'type' => 'post']) ?>
				<div class="row">
	  				<div class="container">
		    			<input id="daterangepicker1" type="hidden">
		    			<div id="daterangepicker1-container" class="embedded-daterangepicker"></div>
	  				</div>
				</div>
				<div class="row">
					<div class="col-8">
						<div class="input-group mt-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="">An- und Abreisedatum</span>
							</div>
						  	<input type="text" class="form-control text-center bg-white" name="from" id="from-date" value="<?= empty($data) ? '' : $data['to'] ?>" readonly="">
						  	<input type="text" class="form-control text-center bg-white" name="to" id="to-date" value="<?= empty($data) ? '' : $data['from'] ?>" readonly="">
					  	</div>
					</div>
					<div class="col-4">
						<?= $this->Form->submit('Prüfen', ['class' => 'btn pl-3 pr-3 mt-3 col-12 text-white float-right', 'style' => 'background-color: #e15236']); ?>
					</div>
				</div>
				<?= $this->Form->end(); ?>
			</div>
		</div>
		
	</div>
</div>